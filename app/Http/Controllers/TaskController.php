<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(): ResourceCollection
    {
        return TaskResource::collection(Task::all());
    }

    public function store(TaskRequest $request): TaskResource
    {
        $validated = $request->validated();
        $task = Task::create($validated);

        return TaskResource::make($task);
    }

    public function show(Task $task): TaskResource
    {
        return TaskResource::make($task);
    }

    public function update(TaskRequest $request, Task $task): TaskResource
    {
        $validated = $request->validated();
        $task->update($validated);

        return TaskResource::make($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(null, 204);
    }
}