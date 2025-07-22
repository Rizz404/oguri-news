<x-user-layout title="Create New Article" :description="'Share your story with the world.'" :show-header="true" :show-footer="false"
    container-class="container-narrow py-12">

    <h1 class="text-3xl font-bold text-neutral-900 mb-2">Create New Article</h1>
    <p class="text-neutral-600 mb-8">Fill out the form below to publish your new story.</p>

    <div class="card">
        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <x-form.input name="title" label="Article Title" required placeholder="Your Awesome Title" />

                <x-form.rich-text name="content" label="Content" required />

                <x-form.file-input name="featured_image" label="Featured Image" accept="image/jpeg,image/png,image/webp"
                    help="Recommended size: 1200x630px. Max 2MB." />

                <div class="grid md:grid-cols-2 gap-6">
                    <x-form.dropdown name="category_id" label="Category" required>
                        <option value="" disabled selected>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-form.dropdown>

                    <x-form.dropdown name="status" label="Status">
                        <option value="draft" @selected(old('status', 'draft') == 'draft')>Draft</option>
                        <option value="published" @selected(old('status') == 'published')>Publish</option>
                    </x-form.dropdown>
                </div>

                <x-form.select-many name="tags" label="Tags" :options="$tags" />

                <x-form.textarea name="excerpt" label="Excerpt (Summary)"
                    placeholder="A short summary of your article..." rows="3" />
            </div>
            <div class="card-footer text-right space-x-2">
                <x-ui.button :href="route('articles.index')" variant="ghost">Cancel</x-ui.button>
                <x-ui.button type="submit">Create Article</x-ui.button>
            </div>
        </form>
    </div>
</x-user-layout>
