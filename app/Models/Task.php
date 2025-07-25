<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'category',
        'priority',
        'description',
        'completed',
        'due_date'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date'
    ];

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function toggleComplete()
    {
        $this->update(['completed' => !$this->completed]);
    }

    public function getPriorityColorAttribute()
    {
        return [
            'Alta' => 'danger',
            'Media' => 'warning',
            'Baja' => 'success'
        ][$this->priority] ?? 'secondary';
    }
}
