<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        // * Scan semua file gambar di folder categories
        $categoryImagesPath = public_path('images/categories');
        $imageFiles = [];

        if (File::exists($categoryImagesPath)) {
            $imageFiles = File::files($categoryImagesPath);
            $imageFiles = array_filter($imageFiles, function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            });

            // * Convert ke path relatif
            $imageFiles = array_map(function ($file) {
                return '/images/categories/' . $file->getFilename();
            }, $imageFiles);
        }

        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'picture_url' => !empty($imageFiles) ? fake()->randomElement($imageFiles) : null,
        ];
    }
}
