@props(['name', 'label' => null, 'required' => false, 'value' => null, 'height' => 400])

<div x-data="{}" x-init="tinymce.init({
    target: $refs.tinymce,
    plugins: 'autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks code fullscreen insertdatetime media table emoticons',
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
    height: {{ $height }},
    setup: function(editor) {
        editor.on('change keyup', () => editor.save());
    }
});" wire:ignore class="form-group">

    @if ($label)
        <label for="{{ $name }}" @class(['form-label', 'form-label-required' => $required])>
            {{ $label }}
        </label>
    @endif

    <textarea x-ref="tinymce" id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'hidden']) }}>{!! old($name, $value) !!}</textarea>

    @error($name)
        <p class="form-error">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>
            {{ $message }}
        </p>
    @enderror
</div>
