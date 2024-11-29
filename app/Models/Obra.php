<?php

namespace App\Models;

use App\Casts\Date;
use App\Models\RSDE\Rdse;
use App\Supports\Enums\Comercial\ComercialStatus;
use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Obra extends Model
{
    use HasFactory, SoftDeletes, LogTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id',
        'client_id',
        'concessionaria_id',
        'address_id',
        'viabilization_id',
        'department_id',
        'razao_social',
        'description',
        'last_note',
        'cnpj',
        'razao_social_obra_cliente',
        'obr_informacoes',
        'status',
        'obr_urgence',
        'build_at',
        'cno',
        'requester',
        'requester_email',
        'requester_phone',
        'last_reminder_sent_at',
        'remove_finance',
        'ultima_atualizacao'
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['AddressComplete'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => Date::class,
        'status' => ComercialStatus::class,
    ];

    public function getAddressCompleteAttribute()
    {
        if (isset($this->address) && $this->address->street != '') {
            $street = $this->address->street;
            $number = $this->address->number;
            $complement = $this->address->complement != '' ?  ", " . $this->address->complement : null;
            return $street . ", Nº " . $number . $complement;
        }

        return 'Endereço não informado';
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'client_id');
    }

    public function UserFavorites()
    {
        return $this->morphToMany(User::class, 'favoritable');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function concessionaria()
    {
        return $this->belongsTo(Concessionaria::class, 'concessionaria_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function address()
    {
        return $this->hasOne(Addres::class, 'id', 'address_id');
    }

    public function viabilizacao()
    {
        return $this->belongsTo(Viabilization::class, 'viabilization_id');
    }

    public function financeiro()
    {
        return $this->hasOne(ObraFinanceiro::class, 'id_obra');
    }

    public function medicao()
    {
        return $this->hasOne(Rdse::class, 'obra_id');
    }

    public function etapas()
    {
        return $this->hasMany(ObraEtapa::class, 'id_obra');
    }

    public function compras()
    {
        return $this->hasMany(ObraEtapa::class, 'id_obra')->where('tipo_id', 4);
    }

    public function etapas_financeiro()
    {
        return $this->hasMany(ObraEtapasFinanceiro::class, 'obra_id');
    }

    public function pasta()
    {
        return $this->hasOne(Pasta::class, 'type_id', 'id')->orderBy('id', 'asc');
    }

    public function activities()
    {
        return $this->morphMany(Activitie::class, 'tipyssable');
    }

    public function favorited(): bool
    {
        return (bool) Favorite::where('user_id', Auth::id())
            ->where('favoritable_id', $this->id)
            ->where('favoritable_type', 'App\Models\Obra')
            ->first();
    }

    public function getCountEtapas()
    {
        $idObra = $this->id;

        $html = '';

        $soma_etapa = 0;

        $etapas = ObraEtapa::where('id_obra', $idObra)->get();
        $etapas_concluidas = $etapas->where('check', 'C')->count();

        if ($etapas_concluidas != 0) {
            $soma = (100) / count($etapas);
            $soma_etapa = $soma * $etapas_concluidas;
        }

        $etapas = count($etapas);
        $soma_etapa = str_replace(',', '.', $soma_etapa);

        $html .= '<div class="d-grid">';
        if ($soma_etapa < '54.165823') {
            $html .= "  <span style='color: #000'> $etapas_concluidas / $etapas </span>";
        }
        $html .= '  <div class="progress">';
        $html .= "      <div class='progress-bar' role='progressbar' style='width: $soma_etapa%;' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>";
        $html .= "          <span class='pd-5' style='color: #000'> $etapas_concluidas / $etapas </span>";
        $html .= '      </div>';
        $html .= '  </div>';
        $html .= '</div>';

        return $html;
    }
}
