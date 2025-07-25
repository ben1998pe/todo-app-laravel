@extends('layouts.app')

@section('title', 'Detalles de Tarea')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Detalles de Tarea
                    </h4>
                    <div>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-edit me-1"></i>
                            Editar
                        </a>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title {{ $task->completed ? 'completed' : '' }}">
                            {{ $task->title }}
                        </h5>
                        
                        @if($task->description)
                            <p class="card-text {{ $task->completed ? 'completed' : '' }}">
                                {{ $task->description }}
                            </p>
                        @endif
                        
                        <div class="mt-3">
                            <span class="badge bg-{{ $task->completed ? 'success' : 'warning' }} me-2">
                                <i class="fas fa-{{ $task->completed ? 'check' : 'clock' }} me-1"></i>
                                {{ $task->completed ? 'Completada' : 'Pendiente' }}
                            </span>
                            
                            <span class="badge bg-secondary me-2">
                                <i class="fas fa-folder me-1"></i>
                                {{ $task->category }}
                            </span>
                            
                            <span class="badge bg-{{ $task->priority_color }} me-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $task->priority }}
                            </span>
                            
                            @if($task->due_date)
                                <span class="badge bg-info">
                                    <i class="fas fa-calendar me-1"></i>
                                    Vence: {{ $task->due_date->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-end">
                        <div class="text-muted small">
                            <div class="mb-1">
                                <i class="fas fa-clock me-1"></i>
                                Creada: {{ $task->created_at->format('d/m/Y H:i') }}
                            </div>
                            @if($task->updated_at != $task->created_at)
                                <div>
                                    <i class="fas fa-edit me-1"></i>
                                    Actualizada: {{ $task->updated_at->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between">
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $task->completed ? 'warning' : 'success' }}">
                            <i class="fas fa-{{ $task->completed ? 'undo' : 'check' }} me-1"></i>
                            {{ $task->completed ? 'Marcar como Pendiente' : 'Marcar como Completada' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('¿Estás seguro de que quieres eliminar esta tarea?')">
                            <i class="fas fa-trash me-1"></i>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 