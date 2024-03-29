<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function save(Request $request) {

        $id = Auth::id();

        $validatedData = $request -> validate([
            'title' => 'required|string|max:250',
            'description' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => $id,
            'status' => false
        ]);

        $task->tags()->attach($validatedData['tags']);

        return response()->json($task, 201);
    }

    public function get() {

        $userId = Auth::id();

        $taskList = Task::where('user_id', $userId)
        ->with('tags')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($taskList, 200);
    }

    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:250',
            'description' => 'required|string',
            'status' => 'boolean',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        $task -> update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $request->input('status', $task->status)
        ]);

        $task->tags()->sync($validatedData['tags']);

        return response()->json(['message'=>'Task updated'], 200);
    }

    public function delete($id) {
        $task = Task::findOrFail($id);

        $task->tags()->detach();

        $task->delete();

        return response()->json(['message'=>'Task Deleted'], 200);
    }
}
