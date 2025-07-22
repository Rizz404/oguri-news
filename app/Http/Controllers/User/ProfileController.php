<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load('profile');
        return view('pages.user.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        Log::info('--- Profile Update Process Started for User ID: ' . $user->id . ' ---');

        /** @var \Illuminate\Http\Request $request */
        $validated = $request->validated();
        Log::info('1. Validation Passed. Validated data: ', $validated);

        // Handle User Data Update
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        Log::info('2. Prepared base user data.', $userData);

        if ($request->hasFile('photo')) {
            Log::info('3a. Photo file detected.');
            if ($user->photo_url) {
                $oldPath = str_replace(Storage::url(''), '', $user->photo_url);
                Log::info('Attempting to delete old photo: ' . $oldPath);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('photo')->store('avatars', 'public');
            $userData['photo_url'] = Storage::url($path);
            Log::info('New photo stored. URL: ' . $userData['photo_url']);
        } else {
            Log::info('3b. No photo file detected in request.');
        }

        // Handle Role Change
        if ($request->filled('role') && $request->role === 'author' && $user->role === 'user') {
            $userData['role'] = 'author';
            Log::info('4. Role change requested and approved. New role will be "author".');
        }

        Log::info('5. Data to be updated on `users` table: ', $userData);
        $user->update($userData);
        Log::info('`users` table update executed.');

        // Data untuk tabel 'profiles'
        $profileData = [
            'fullname' => $validated['fullname'],
            'bio' => $validated['bio'],
            'phone_number' => $validated['phone_number'],
        ];
        Log::info('6. Data to be updated on `profiles` table: ', $profileData);
        $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);
        Log::info('`profiles` table update/create executed.');

        Log::info('--- Profile Update Process Finished. Redirecting... ---');
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
