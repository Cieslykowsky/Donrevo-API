<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;

class GroupController extends Controller
{
    public function index(): ResourceCollection
    {
        $groups = Group::all();
        return GroupResource::collection($groups);
    }

    public function store(GroupRequest $request): GroupResource
    {
        $validated = $request->validated();

        $group = Group::create($validated);

        return GroupResource::make($group);
    }

    public function show(Group $group): GroupResource
    {
        return GroupResource::make($group);
    }

    public function update(GroupRequest $request, Group $group): GroupResource
    {
        $validated = $request->validated();

        $group->update($validated);

        return GroupResource::make($group);
    }

    public function destroy(Group $group): JsonResponse
    {
        $group->delete();

        return response()->json(null, 204);
    }
}