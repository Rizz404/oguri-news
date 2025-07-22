<x-user-layout title="My Profile" :description="'Manage your profile and account settings.'" :show-header="true" :show-footer="false"
    container-class="container-narrow py-12">

    <h1 class="text-3xl font-bold text-neutral-900 mb-8">My Profile & Settings</h1>

    <div class="card">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <h2 class="text-xl font-semibold text-neutral-800 border-b pb-3 mb-6">Account Information</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <x-form.file-input name="photo" label="Profile Photo" accept="image/*"
                            help="Max 2MB. Recommended 1:1 ratio." :preview="$user->photo_url" />
                    </div>
                    <div class="md:col-span-2 grid content-start gap-y-4">
                        <x-form.input name="name" label="Display Name" required :value="$user->name" />
                        <x-form.input type="email" name="email" label="Email Address" required :value="$user->email" />
                    </div>
                </div>

                <h2 class="text-xl font-semibold text-neutral-800 border-b pb-3 my-6">Public Profile</h2>
                <x-form.input name="fullname" label="Full Name" placeholder="Your full name" :value="$user->profile?->fullname" />
                <x-form.textarea name="bio" label="Bio" rows="4"
                    placeholder="Tell us a little about yourself..." :value="$user->profile?->bio" />
                <x-form.input name="phone_number" label="Phone Number" placeholder="Your contact number"
                    :value="$user->profile?->phone_number" />

                <h2 class="text-xl font-semibold text-neutral-800 border-b pb-3 my-6">Role</h2>
                <div class="form-group">
                    <label for="role" class="form-label">Account Role</label>
                    @if ($user->role === 'admin')
                        <p class="form-input bg-neutral-100">Administrator (Cannot be changed)</p>
                    @else
                        <x-form.dropdown name="role" :label="false">
                            <option value="user" @selected($user->role === 'user')>User</option>
                            @if ($user->role === 'author')
                                <option value="author" selected disabled>Author (Approved)</option>
                            @else
                                <option value="author">Request to become an Author</option>
                            @endif
                        </x-form.dropdown>
                        <p class="form-help">Select 'Request to become an Author' to be able to write articles.</p>
                    @endif
                </div>

            </div>

            <div class="card-footer text-right">
                <x-ui.button type="submit" variant="primary">Save Changes</x-ui.button>
            </div>
        </form>
    </div>
</x-user-layout>
