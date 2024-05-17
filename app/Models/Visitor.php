<?php

namespace App\Models;

use App\Casts\DateTime;
use App\Supports\Enums\Frota\VisitorsStatus;
use App\Traits\LogTrait;
use App\Traits\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory, SearchableTrait, LogTrait;

    public $searchable = ['name', 'company_name', 'vehicle_plate', 'document', 'id'];

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
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_name',
        'finality',
        'document',
        'vehicle_model',
        'vehicle_plate',
        'vehicle_color',
        'visitor_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visitor_at' => DateTime::class,
        'status' => VisitorsStatus::class,
    ];

    protected $appends = ['VehicleComplete', 'optionsToChangeStatus'];

    public function getVehicleCompleteAttribute()
    {
        return $this->vehicle_model . ' Placa: ' . $this->vehicle_plate . ' Cor: ' . $this->vehicle_color;
    }

    public function getStatusBadgeAttribute()
    {
        $label = __('campaings.badge.' . $this->status);

        return "<span class='badge rounded-pill bg-$label'>"
            . __trans('campaings.statuses.' . $this->status)
            . "</span>";
    }

    public function getOptionsToChangeStatusAttribute()
    {
        $options = [];

        $statusCreated = VisitorsStatus::CREATED;
        $statusReleased = VisitorsStatus::RELEASED;
        $statusClosed = VisitorsStatus::CLOSED;

        if ($this->status == $statusCreated) {
            $options = [
                [
                    'name' =>  $statusReleased->name,
                    'value' =>  $statusReleased->value,
                    'trans' => 'Liberar',
                ],
                [
                    'name' =>  $statusClosed->name,
                    'value' =>  $statusClosed->value,
                    'trans' => 'Encerrar',
                ],
            ];
        }

        if ($this->status == $statusReleased) {
            $options = [
                [
                    'name' =>  $statusClosed->name,
                    'value' =>  $statusClosed->value,
                    'trans' => 'Encerrar',
                ],
            ];
        }

        return $options;
    }
}
