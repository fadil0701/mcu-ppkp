@props([
    'name',
    'label' => '',
    'options' => [],
    'valueKey' => 'id',
    'labelKey' => 'name',
    'sublabelKey' => null,
    'placeholder' => '-- Pilih --',
    'value' => '',
    'required' => false,
])

@php
    $optionsArray = collect($options)->map(function ($item) use ($valueKey, $labelKey, $sublabelKey) {
        $opt = [
            'value' => is_array($item) ? ($item[$valueKey] ?? '') : $item->{$valueKey},
            'label' => is_array($item) ? ($item[$labelKey] ?? '') : $item->{$labelKey},
        ];
        if ($sublabelKey !== null) {
            $opt['sublabel'] = is_array($item) ? ($item[$sublabelKey] ?? '') : $item->{$sublabelKey} ?? '';
        }
        return $opt;
    })->values()->all();
    $selectedValue = old($name, $value);
    $selectedOption = collect($optionsArray)->firstWhere('value', $selectedValue);
@endphp

<div
    x-data="{
        open: false,
        search: '',
        selected: @js($selectedOption),
        options: @js($optionsArray),
        get filteredOptions() {
            if (!this.search.trim()) return [];
            const q = this.search.toLowerCase();
            return this.options.filter(o => {
                const label = (o.label || '').toLowerCase();
                const sub = (o.sublabel || '').toLowerCase();
                return label.includes(q) || sub.includes(q);
            });
        },
        select(opt) {
            this.selected = opt;
            this.$refs.input.value = opt ? opt.value : '';
            this.open = false;
            this.search = '';
        },
        clear() {
            this.selected = null;
            this.$refs.input.value = '';
            this.open = false;
            this.search = '';
        },
        displayLabel(opt) {
            if (!opt) return '';
            return opt.sublabel ? opt.label + ' (' + opt.sublabel + ')' : opt.label;
        }
    }"
    class="relative"
    @click.away="open = false"
>
    @if($label)
        <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    @endif

    <input type="hidden" name="{{ $name }}" x-ref="input" value="{{ $selectedValue }}" {{ $required ? 'required' : '' }}>

    <div class="relative">
        <button
            type="button"
            @click="open = !open; if(open) $nextTick(() => $refs.searchInput?.focus())"
            class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-left text-theme-sm text-gray-800 dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 flex items-center justify-between gap-2 min-h-[42px]"
            :class="{ 'border-brand-500 ring-1 ring-brand-500': open }"
        >
            <span x-text="selected ? displayLabel(selected) : '{{ addslashes($placeholder) }}'" class="truncate" :class="{ 'text-gray-400 dark:text-gray-500': !selected }"></span>
            <svg class="w-4 h-4 shrink-0 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-20 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-800 dark:bg-gray-800"
            style="display: none;"
        >
            <div class="p-2 border-b border-gray-100 dark:border-gray-700">
                <input
                    type="text"
                    x-ref="searchInput"
                    x-model="search"
                    @keydown.escape="open = false"
                    placeholder="Cari..."
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >
            </div>
            <div class="max-h-60 overflow-y-auto py-1">
                <button type="button" @click="clear()" class="w-full px-3 py-2 text-left text-theme-sm text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400">
                    {{ $placeholder }}
                </button>
                <template x-if="!search.trim()">
                    <p class="px-3 py-4 text-center text-theme-sm text-gray-500 dark:text-gray-400">Ketik untuk mencari...</p>
                </template>
                <template x-for="opt in filteredOptions" :key="opt.value">
                    <button
                        type="button"
                        @click="select(opt)"
                        class="w-full px-3 py-2 text-left text-theme-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-brand-50 dark:bg-brand-500/10 text-brand-700 dark:text-brand-400': selected && selected.value == opt.value }"
                    >
                        <span x-text="displayLabel(opt)"></span>
                    </button>
                </template>
                <template x-if="search.trim() && filteredOptions.length === 0">
                    <p class="px-3 py-4 text-center text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada hasil.</p>
                </template>
            </div>
        </div>
    </div>

    @error($name)
        <p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>
    @enderror
</div>
