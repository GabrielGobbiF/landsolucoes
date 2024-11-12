<?php

namespace App\Models;

use App\Casts\Currency;
use App\Casts\OnlyNumber;
use App\Models\Uploaded;
use App\Supports\Enums\Gestao\Purchases\PurchaseOrderStatus;
use App\Supports\Traits\GenerateUuidTrait;
use App\Supports\Traits\LogTrait;
use App\Supports\Traits\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Inventory extends Model
{
    use HasFactory, LogTrait, GenerateUuidTrait, SoftDeletes, LogsActivity,  SearchableTrait;

    #public $with = ['images'];

    public $searchable = ['*'];

    /**
     * The attributes hidden.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'code_omie',
        'code_ncm',
        'unit',
        'length',
        'width',
        'height',
        'weight',
        'image',
        #'stock',
        'opening_stock',
        'refueling_point',
        'market_price',
        'sale_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'market_price' => Currency::class,
        'sale_price' => Currency::class,
        'length' => OnlyNumber::class,
        'width' => OnlyNumber::class,
        'height' => OnlyNumber::class,
        'weight' => OnlyNumber::class,
        'opening_stock' => 'float',
        'stock' => 'float',
        'refueling_point' => 'float',
    ];

    #public function cover_url($size = 'medium')
    #{
    #    return $this->images->where('is_cover', true)->first()?->image_url($size);
    #}

    #public function images()
    #{
    #    return $this->morphMany(Uploaded::class, 'parentable');
    #}

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function canDelete()
    {
        return auth()->user()->id === 1;
    }

    public function haveStock($qnt)
    {
        if ($qnt > $this->stock) {
            return false;
        }
        return true;
    }

    public function addStock($qnt, $parentable = NULL)
    {
        $stockAtual = $this->stock;

        $stockAdicionado = $this->stock + $qnt;

        $this->increment('stock', $qnt);

        if ($parentable) {
            $table = $parentable->getTable();
            $parentableId = $parentable->id;
        }

        $this->setLog([
            'message' => 'add_stock',
            'description' => "Estoque adicionado de $stockAtual para $stockAdicionado",
            'icon' => "<i class='fa-solid fa-up-long text-success'></i>",
            #'route' => $parentable ? _route("admin.$table.show", $parentableId) : null,
        ]);
    }

    public function removeStock($qnt, $parentable = null)
    {
        $stockAtual = $this->stock;

        $stockRemovido = $this->stock - $qnt;

        $this->decrement('stock', $qnt);

        if ($parentable) {
            $table = $parentable->getTable();
            $parentableId = $parentable->id;
        }

        $this->setLog([
            'message' => 'remove_stock',
            'description' => "Estoque Removido de $stockAtual para $stockRemovido",
            'icon' => "<i class='fa-solid fa-up-down text-danger'></i>",
            'route' => $parentable ? route("admin.$table.show", $parentableId) : null,
        ]);
    }

    public function getCountStockGoing()
    {
        #return $approvedItems = PurchaseItens::where('itemable_type', 'App\Models\Gestao\PurchaseOrder')
        #    ->where('inventory_id', $this->id)
        #    ->whereHas('itemable', function ($query) {
        #        $query->where('status', PurchaseOrderStatus::APPROVED);
        #    })
        #    ->count();
        return;
    }
}
