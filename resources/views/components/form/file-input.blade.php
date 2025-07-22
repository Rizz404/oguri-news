@props(['name', 'label' => null, 'required' => false, 'help' => null, 'accept' => 'image/*', 'preview' => null])

@php
    $dotName = str_replace(['[', ']'], ['.', ''], $name);
    $hasError = $errors->has($dotName);
@endphp

<div class="form-group" x-data="{
    fileName: '',
    filePreview: '{{ $preview }}',
    handleFileSelect(event) {
        if (event.target.files.length > 0) {
            this.fileName = event.target.files[0].name;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.filePreview = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        } else {
            this.fileName = '';
            this.filePreview = '{{ $preview }}';
        }
    }
}">
    @if ($label)
        <label for="{{ $name }}" @class(['form-label', 'form-label-required' => $required])>
            {{ $label }}
        </label>
    @endif

    <div class="flex items-center space-x-4">
        <template x-if="filePreview">
            <img :src="filePreview" alt="Image Preview" class="h-16 w-16 rounded-md object-cover bg-neutral-100">
        </template>

        <label class="w-full">
            <span class="btn btn-outline w-full cursor-pointer">
                <i class="fa-solid fa-upload mr-2"></i>
                <span x-text="fileName ? fileName : 'Choose a file...'"></span>
            </span>
            <input id="{{ $name }}" name="{{ $name }}" type="file" @change="handleFileSelect"
                class="sr-only" accept="{{ $accept }}">
        </label>
    </div>


    @if ($help)
        <p class="form-help">{{ $help }}</p>
    @endif

    @error($dotName)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
