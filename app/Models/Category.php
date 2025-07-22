<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'description',
        'picture_url'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        });
    }

    public function scopeSort(Builder $query, ?string $sortBy, ?string $direction): void
    {
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? strtolower($direction) : 'desc';

        if ($sortBy === 'articles_count') {
            // Pastikan withCount('articles') dipanggil sebelum scope ini
            $query->orderBy('articles_count', $direction);
        } elseif ($sortBy === 'name') {
            $query->orderBy('name', $direction);
        } else {
            // Default sort
            $query->orderBy('created_at', $direction);
        }
    }
}
