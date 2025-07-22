<x-user-layout :title="'Edit: ' . $article->title" :description="'Update your story.'" :show-header="true" :show-footer="false"
    container-class="container-narrow py-12">

    <h1 class="text-3xl font-bold text-neutral-900 mb-2">Edit Article</h1>
    <p class="text-neutral-600 mb-8">Make changes to your article below.</p>

    <div class="card">
        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <x-form.input name="title" label="Article Title" required :value="$article->title" />

                <x-form.rich-text name="content" label="Content" required :value="$article->content" />

                <x-form.file-input name="featured_image" label="Featured Image" accept="image/jpeg,image/png,image/webp"
                    help="Upload a new image to replace the current one. Max 2MB." :preview="$article->featured_image_url" />

                <div class="grid md:grid-cols-2 gap-6">
                    <x-form.dropdown name="category_id" label="Category" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-form.dropdown>

                    <x-form.dropdown name="status" label="Status">
                        <option value="draft" @selected(old('status', $article->status) == 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $article->status) == 'published')>Publish</option>
                    </x-form.dropdown>
                </div>

                <x-form.select-many name="tags" label="Tags" :options="$tags" :selected="$article->tags" />

                <x-form.textarea name="excerpt" label="Excerpt (Summary)"
                    placeholder="A short summary of your article..." rows="3" :value="$article->excerpt" />

            </div>
            <div class="card-footer text-right space-x-2">
                <x-ui.button :href="route('articles.show', $article)" variant="ghost">Cancel</x-ui.button>
                <x-ui.button type="submit">Update Article</x-ui.button>
            </div>
        </form>
    </div>

</x-user-layout>
