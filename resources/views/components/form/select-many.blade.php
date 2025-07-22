@props(['name', 'label' => null, 'options' => [], 'selected' => [], 'placeholder' => 'Search and add tags...'])

@php
    // Konversi koleksi Eloquent menjadi array PHP biasa untuk Alpine
    $optionsArray = collect($options)->map(fn($option) => ['id' => $option->id, 'name' => $option->name])->values();
    $selectedArray = collect($selected)->map(fn($option) => ['id' => $option->id, 'name' => $option->name])->values();
@endphp

<div class="form-group" x-data="{
    open: false,
    search: '',
    options: {{ json_encode($optionsArray) }},
    selected: {{ json_encode($selectedArray) }},

    get filteredOptions() {
        return this.options.filter(
            option => !this.selected.some(selectedItem => selectedItem.id === option.id) &&
            option.name.toLowerCase().includes(this.search.toLowerCase())
        );
    },

    selectOption(option) {
        if (!this.selected.some(item => item.id === option.id)) {
            this.selected.push(option);
        }
        this.search = '';
        this.open = false;
    },

    removeOption(id) {
        this.selected = this.selected.filter(item => item.id !== id);
    }
}" x-on:click.outside="open = false">

    @if ($label)
        <label class="form-label">{{ $label }}</label>
    @endif

    <template x-for="item in selected" :key="item.id">
        <input type="hidden" name="{{ $name }}[]" :value="item.id">
    </template>

    <div class="relative">
        <div class="form-input flex flex-wrap items-center gap-2 p-1" @click="open = true">
            <template x-for="item in selected" :key="item.id">
                <span class="badge badge-primary flex items-center gap-1">
                    <span x-text="item.name"></span>
                    <button type="button" @click.stop="removeOption(item.id)" class="focus:outline-none">
                        <i class="fas fa-times-circle text-xs hover:text-white"></i>
                    </button>
                </span>
            </template>
            <input type="text" x-model="search" @focus="open = true" @keydown.escape.prevent="open = false"
                @keydown.enter.prevent="if(filteredOptions.length > 0) selectOption(filteredOptions[0])"
                placeholder="{{ $placeholder }}" class="flex-grow bg-transparent border-none focus:ring-0 p-1">
        </div>

        <div x-show="open" x-transition
            class="absolute z-10 mt-1 w-full bg-white border border-neutral-300 rounded-md shadow-lg max-h-60 overflow-y-auto"
            style="display: none;">
            <template x-if="filteredOptions.length > 0">
                <ul>
                    <template x-for="option in filteredOptions" :key="option.id">
                        <li @click="selectOption(option)" class="px-3 py-2 cursor-pointer hover:bg-primary-100"
                            x-text="option.name">
                        </li>
                    </template>
                </ul>
            </template>
            <template x-if="filteredOptions.length === 0 && search.length > 0">
                <p class="px-3 py-2 text-neutral-500">No tags found matching your search.</p>
            </template>
        </div>
    </div>
    @error($name)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
