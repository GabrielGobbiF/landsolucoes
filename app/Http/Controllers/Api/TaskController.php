<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTask;
use App\Http\Resources\TasksResource;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $repository;

    public function __construct(Task $task)
    {
        $this->repository = $task;
    }

    public function index()
    {
        return view('pages.painel.tasks.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $filter = $request->input('done');

        $tasks = auth()->user()->tasks()->where(function ($query) use ($filter) {
            $filter == 'true'
                ? $query->where('tar_status', 'concluido')
                : $query->where('tar_status', 'em_andamento');
        })->get();

        return TasksResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTask $request)
    {
        $columns = $request->all();

        $task = auth()->user()->tasks()->create($columns);

        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($task_id)
    {
        if (!$task = auth()->user()->tasks()->where('id', $task_id)->first()) {
            return response()->json('Object Task not found', 404);
        }

        return new TasksResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateTask $request, $task_id)
    {
        $columns = $request->except('_token');

        if (!$task = auth()->user()->tasks()->where('id', $task_id)->first()) {
            return response()->json('Object Task not found', 404);
        }

        $task = tap($task)->update($columns);

        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    /**
     * Update the specified resource Status
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $task_id)
    {
        $check = $request->input('check');

        if (!$task = auth()->user()->tasks()->where('id', $task_id)->first()) {
            return response()->json('Object Task not found', 404);
        }

        $task->update(['tar_status' => $check]);

        return  $task;
    }
}
