<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        // * Scan semua file gambar di folder articles
        $categoryImagesPath = public_path('images/articles');
        $imageFiles = [];

        if (File::exists($categoryImagesPath)) {
            $imageFiles = File::files($categoryImagesPath);
            $imageFiles = array_filter($imageFiles, function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            });

            // * Convert ke path relatif
            $imageFiles = array_map(function ($file) {
                return '/images/articles/' . $file->getFilename();
            }, $imageFiles);
        }

        // $categories = Category::all()->pluck('id');
        $title = fake()->sentence(4);
        $status = fake()->randomElement(['published', 'draft', 'pending']);

        return [
            'title' => $title,
            // 'category_id' => fake()->randomElement($categories),
            'content' => fake()->paragraphs(10, true),
            'excerpt' => fake()->paragraph(2),
            'featured_image_url' => !empty($imageFiles) ? fake()->randomElement($imageFiles) : null,
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $article->tags()->attach($tags);
        });
    }
}
