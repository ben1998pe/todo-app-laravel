@extends('layouts.app')

@section('title', 'Lista de Tareas')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Mis Tareas
                    </h4>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Nueva Tarea
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($tasks->count() > 0)
                    <div class="row">
                        @foreach($tasks as $task)
                            <div class="col-12 mb-3">
                                <div class="card task-item {{ $task->completed ? 'border-success' : 'border-primary' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="me-3">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn-toggle">
                                                            <i class="fas fa-{{ $task->completed ? 'check-circle text-success' : 'circle text-muted' }} fa-lg"></i>
                                                        </button>
                                                    </form>
                                                    <h5 class="card-title mb-1 {{ $task->completed ? 'completed' : '' }}">
                                                        {{ $task->title }}
                                                    </h5>
                                                </div>
                                                
                                                @if($task->description)
                                                    <p class="card-text text-muted {{ $task->completed ? 'completed' : '' }}">
                                                        {{ $task->description }}
                                                    </p>
                                                @endif
                                                
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="text-muted small">
                                                        @if($task->due_date)
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Vence: {{ $task->due_date->format('d/m/Y') }}
                                                        @endif
                                                        <span class="ms-3">
                                                            <i class="fas fa-clock me-1"></i>
                                                            Creada: {{ $task->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar esta tarea?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay tareas aún</h5>
                        <p class="text-muted">¡Crea tu primera tarea para comenzar!</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Crear Primera Tarea
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 