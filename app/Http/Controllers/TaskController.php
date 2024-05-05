<?php

namespace App\Http\Controllers;

use App\Events\TaskCreatedEvent;
use App\Events\TaskStatusChangeEvent;
use App\Models\Task;
use App\Models\User;
use App\Utilities\APIResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    use Queueable;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, APIResponse $apiResponse)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in-progress,completed',
            'deadline' => 'required|date_format:Y-m-d H:i:s|after:now',
        ];

        $user = $request->user();

        $validated = $request->validate($rules);

        $validated['uuid'] = DB::raw('uuid()');
        $validated['user_id'] = $user->id;

        $task = Task::create($validated);
        event(new TaskCreatedEvent($user, $task));

        $apiResponse->statusCode = Response::HTTP_CREATED;
        $apiResponse->data = $task;
        return $apiResponse->getResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $uuid, APIResponse $apiResponse)
    {
        $user = $request->user();
        $task = Task::where('uuid', $uuid)->select('title','status','uuid','deadline','description')->where('user_id', $user->id)->first();

        if (!$task) {
            $apiResponse->statusCode = Response::HTTP_NOT_FOUND;
            $apiResponse->message = ["error" => 'Task not found'];
        } else {
            $apiResponse->data = $task;
        }

        return $apiResponse->getResponse();
    }

    /**
     * Display the resources.
     */
    public function index(Request $request, APIResponse $apiResponse)
    {
        $user = $request->user();
        $task = Task::where('user_id', $user->id)->select('uuid','title','description','status','deadline')->get();

        $apiResponse->data = $task;
        return $apiResponse->getResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid, APIResponse $apiResponse)
    {
        $user = $request->user();
        $task = Task::where('uuid', $uuid)->where('user_id', $user->id)->first();

        if (!$task) {
            $apiResponse->statusCode = Response::HTTP_NOT_FOUND;
            $apiResponse->message = ["error" => 'Task not found'];
        } else {

            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:pending,in-progress,completed',
                'deadline' => 'required|date_format:Y-m-d H:i:s|after:now',
            ];

            $validated = $request->validate($rules);

            if($validated['status'] != $task->status){
                event(new TaskStatusChangeEvent($user, $task));
            }

            $task->update($validated);
            $apiResponse->data = $task;
        }
        return $apiResponse->getResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $uuid, APIResponse $apiResponse)
    {
        $user = $request->user();
        $task = Task::where('uuid', $uuid)->where('user_id', $user->id)->first();

        if (!$task) {
            $apiResponse->statusCode = Response::HTTP_NOT_FOUND;
            $apiResponse->message = ["error" => 'Task not found'];
        } else {
            $apiResponse->statusCode = Response::HTTP_NO_CONTENT;
            $task->delete();
        }

        return $apiResponse->getResponse();
    }

    /**
     * Update the status if specified resource.
     */
    public function updateStatus(Request $request, APIResponse $apiResponse)
    {
        $rules = [
            'uuid' => 'required|uuid',
            'status' => 'required|in:pending,in-progress,completed',
        ];
        $validated = $request->validate($rules);
        $user = $request->user();
        $task = Task::where('uuid', $validated['uuid'])->where('user_id', $user->id)->first();

        if (!$task) {
            $apiResponse->statusCode = Response::HTTP_NOT_FOUND;
            $apiResponse->message = ["error" => 'Task not found'];
        } else {

            $rules = [
                'status' => 'required|in:pending,in-progress,completed',
            ];

            $task->update($validated);

            event(new TaskStatusChangeEvent($user, $task));

            $apiResponse->data = $task;
        }
        return $apiResponse->getResponse();
    }
}
