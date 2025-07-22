<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory, HasUlids, HasSlug;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'excerpt',
        'featured_image_url',
        'status',
        'published_at',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            });
        });

        $query->when($filters['author'] ?? false, function ($query, $author) {
            $query->whereHas('user', function ($query) use ($author) {
                $query->where('name', $author);
            });
        });

        $query->when($filters['tag'] ?? false, function ($query, $tag) {
            $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag);
            });
        });
    }

    public function scopeSort(Builder $query, ?string $sortBy, ?string $direction): void
    {
        $sortBy = $sortBy ?? 'published_at';
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? strtolower($direction) : 'desc';

        $column = match ($sortBy) {
            'title' => 'title',
            'date' => 'published_at',
            default => 'published_at',
        };

        $query->orderBy($column, $direction);
    }
}
