<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function save(Request $request) {
        $validatedData = $request -> validate([
            'title' => 'required|string|max:250',
            'description' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description']
        ]);

        $task->tags()->attach($validatedData['tags']);

        return response()->json($task, 201);
    }

    public function get() {
        $taskList = Task::with('tags')->get();

        return response()->json($taskList, 200);
    }

    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:250',
            'description' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        $task -> update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description']
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
