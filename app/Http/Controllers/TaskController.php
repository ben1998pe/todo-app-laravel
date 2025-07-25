<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        // Filtros
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->completed();
            } elseif ($request->status === 'pending') {
                $query->pending();
            }
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        // Datos para los filtros
        $categories = Task::distinct()->pluck('category')->sort();
        $priorities = ['Alta', 'Media', 'Baja'];

        return view('tasks.index', compact('tasks', 'categories', 'priorities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Personal', 'Trabajo', 'Salud', 'Hogar', 'Estudio', 'Otros'];
        $priorities = ['Baja', 'Media', 'Alta'];
        
        return view('tasks.create', compact('categories', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'priority' => 'required|in:Baja,Media,Alta',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $categories = ['Personal', 'Trabajo', 'Salud', 'Hogar', 'Estudio', 'Otros'];
        $priorities = ['Baja', 'Media', 'Alta'];
        
        return view('tasks.edit', compact('task', 'categories', 'priorities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'priority' => 'required|in:Baja,Media,Alta',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Toggle the completion status of a task.
     */
    public function toggle(Task $task)
    {
        $task->toggleComplete();

        return redirect()->route('tasks.index')
            ->with('success', 'Estado de la tarea actualizado.');
    }
}
