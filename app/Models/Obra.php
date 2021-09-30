<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Obra extends Model
{
    use HasFactory, SoftDeletes;


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
        'cno'
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['AddressComplete'];

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

    public function etapas()
    {
        return $this->hasMany(ObraEtapa::class, 'id_obra');
    }

    public function etapas_financeiro()
    {
        return $this->hasMany(ObraEtapasFinanceiro::class, 'obra_id');
    }

    public function pasta()
    {
        return $this->hasOne(Pasta::class, 'type_id', 'id');
    }

    public function favorited(): bool
    {
        return (bool) Favorite::where('user_id', Auth::id())
            ->where('favoritable_id', $this->id)
            ->where('favoritable_type', 'App\Models\Obra')
            ->first();
    }
}
