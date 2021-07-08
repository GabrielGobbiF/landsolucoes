<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\SendNotificationTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class notifyLembrete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notifyLembrete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lembrar o usuário da tarefa';

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
        $db = DB::select("SELECT * from tasks where alert = 'N' AND `data` <> '' AND (`data` > DATE_SUB(NOW(), INTERVAL 1 MINUTE) OR `data` < NOW())");

        foreach ($db as $task) {

            $title = $task->tar_titulo;

            $user = User::where('id', $task->user_id)->first();
            $user->notify(new SendNotificationTask("Lembrete da sua tarefa $title", 'fas fa-tasks', route('obras.index')));

            $taskU = Task::find($task->id);
            $taskU->alert = 'Y';
            $taskU->update();
            $taskU->save();

            slack("Lembrete de sua tarefa $title, veja aqui " . route('obras.index'));
        }
    }
}
