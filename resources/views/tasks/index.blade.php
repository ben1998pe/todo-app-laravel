@extends('layouts.app')

@section('title', 'Lista de Tareas')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
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
            
            <!-- Filtros -->
            <div class="card-body border-bottom">
                <form method="GET" action="{{ route('tasks.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="category" class="form-label">Categoría</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="priority" class="form-label">Prioridad</label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="">Todas las prioridades</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                    {{ $priority }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="status" class="form-label">Estado</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completadas</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-outline-primary flex-fill">
                                <i class="fas fa-filter me-1"></i>
                                Filtrar
                            </button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
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
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <span class="badge bg-secondary">{{ $task->category }}</span>
                                                        <span class="badge bg-{{ $task->priority_color }}">{{ $task->priority }}</span>
                                                        @if($task->due_date)
                                                            <span class="text-muted small">
                                                                <i class="fas fa-calendar me-1"></i>
                                                                {{ $task->due_date->format('d/m/Y') }}
                                                            </span>
                                                        @endif
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
                        <h5 class="text-muted">No hay tareas que coincidan con los filtros</h5>
                        <p class="text-muted">¡Crea una nueva tarea o ajusta los filtros!</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Crear Nueva Tarea
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 