<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(10)->create();
        Tag::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('177013'),
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'password' => Hash::make('177013'),
        ]);

        User::factory(18)->create();

        $users = User::all();
        $categories = Category::all();

        Article::factory(25)->make()->each(function ($article) use ($users, $categories) {
            $article->user_id = $users->random()->id;
            $article->category_id = $categories->random()->id;
            $article->save();
        });

        foreach ($users as $user) {
            $usersToFollow = $users->where('id', '!=', $user->id)->random(2);
            foreach ($usersToFollow as $userToFollow) {
                $user->following()->attach($userToFollow->id);
            }
        }
        // $this->call([
        //     UserSeeder::class,
        //     CategorySeeder::class,
        //     TagSeeder::class,
        //     ArticleSeeder::class,
        // ]);
    }
}
