<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        // * Scan semua file gambar di folder users
        $categoryImagesPath = public_path('images/users');
        $imageFiles = [];

        if (File::exists($categoryImagesPath)) {
            $imageFiles = File::files($categoryImagesPath);
            $imageFiles = array_filter($imageFiles, function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            });

            // * Convert ke path relatif
            $imageFiles = array_map(function ($file) {
                return '/images/users/' . $file->getFilename();
            }, $imageFiles);
        }


        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['user', 'admin', 'author']),
            'photo_url' => !empty($imageFiles) ? fake()->randomElement($imageFiles) : null,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            Profile::factory()->create([
                'user_id' => $user->id,
                'fullname' => $user->name,
            ]);
        });
    }
}
