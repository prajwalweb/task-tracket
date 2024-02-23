<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $dueDate = $request->input('due_date');
        $categories = Category::all();
        $query = Task::query();
        if ($category) {
            $query->where('category_id', $category);
        }
        if ($dueDate) {
            $query->whereDate('due_date', '=', $dueDate);
        }
        $tasks = $query->where('user_id', auth()->user()->id)->get();
        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => [
                'required', 'after:today',
            ],
            'category_id' => 'exists:categories,id',
        ]);

        $data = array(
            'user_id' => auth()->user()->id,
            'title' => $request['title'],
            'description' => $request['description'],
            'due_date' => $request['due_date'],
            'category_id' => $request['category_id'],
        );

        Task::create($data);

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => [
                'required', 'after:today',
            ],
            'category_id' => 'exists:categories,id',
        ]);

        $data = array(
            'title' => $request['title'],
            'description' => $request['description'],
            'due_date' => $request['due_date'],
            'category_id' => $request['category_id'],
        );

        $task->update($data);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
