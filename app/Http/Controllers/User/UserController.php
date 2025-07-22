<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the authors.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->where('role', 'author') // Hanya tampilkan penulis
            ->withCount('articles')
            ->filter($request->only('search'))
            ->sort($request->input('sort_by'), $request->input('direction'))
            ->paginate(12)
            ->withQueryString();

        return view('pages.user.user.index', compact('users'));
    }

    /**
     * Display the specified user's public profile.
     */
    public function show(Request $request, User $user)
    {
        $user->load('profile');

        // Ambil artikel milik user ini, lalu filter & sort berdasarkan request
        $articles = $user->articles()
            ->where('status', 'published')
            ->filter($request->only('search', 'category')) // Menggunakan scope filter dari model Article
            ->sort($request->input('sort_by'), $request->input('direction')) // Menggunakan scope sort dari model Article
            ->paginate(9)
            ->withQueryString();

        return view('pages.user.user.show', compact('user', 'articles'));
    }
}
