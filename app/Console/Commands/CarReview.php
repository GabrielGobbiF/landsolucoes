<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\VehicleActivities;
use App\Notifications\SendNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CarReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:carReview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar se o carro está com KM Multiplo de 10000';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Slack::send(
            'oi'
        );

        $db = DB::select('select * from vehicle_activities t where t.id = (select id from vehicle_activities va where va.vehicle_id = t.vehicle_id order by created_at desc limit 0, 1) AND notify_send = 0');

        foreach ($db as $activityVehicle) {
            $km = $activityVehicle->km_end != '' ? $activityVehicle->km_end : $activityVehicle->km_start;

            if ($km != '') {
                if ((($km % 10000) == 0 || $km % 10000 == 0) && $activityVehicle->notify_send != '1') {
                    $users = User::whereIn('id', [1, 5])->get();
                    $users->each->notify(new SendNotification("Carro chegou a $km km", 'fas fa-car-alt', route('vehicles.show', $activityVehicle->id)));
                    $activityVeh = VehicleActivities::find($activityVehicle->id);
                    $activityVeh->notify_send = '1';
                    $activityVeh->update();
                    $activityVeh->save();
                }
            }
        }
    }
}
