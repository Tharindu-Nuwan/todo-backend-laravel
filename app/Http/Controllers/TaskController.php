<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function saveTask(Request $request) {
        $validatedData = $request -> validate([
            'title' => 'required|string|max:250',
            'description' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'date' => now()
        ]);

        $task -> tags() -> attach($validatedData['tags']);

        return response() -> json($task, 201);
    }
}
