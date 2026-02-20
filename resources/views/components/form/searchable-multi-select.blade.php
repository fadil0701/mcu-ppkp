@props([
    'name' => 'ids',
    'label' => '',
    'options' => [],
    'valueKey' => 'id',
    'labelKey' => 'name',
    'sublabelKey' => null,
    'placeholder' => 'Ketik untuk mencari...',
    'selectedIds' => [],
])

@php
    $optionsArray = collect($options)->map(function ($item) use ($valueKey, $labelKey, $sublabelKey) {
        $opt = [
            'value' => is_array($item) ? ($item[$valueKey] ?? '') : $item->{$valueKey},
            'label' => is_array($item) ? ($item[$labelKey] ?? '') : $item->{$labelKey},
        ];
        if ($sublabelKey !== null) {
            $opt['sublabel'] = is_array($item) ? ($item[$sublabelKey] ?? '') : ($item->{$sublabelKey} ?? '');
        }
        return $opt;
    })->values()->all();
    $selectedIds = old($name, $selectedIds);
    $selectedIds = is_array($selectedIds) ? array_map('intval', array_filter($selectedIds)) : [];
@endphp

<div
    x-data="{
        open: false,
        search: '',
        selected: @js($selectedIds),
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
        add(opt) {
            if (!this.selected.includes(opt.value)) {
                this.selected.push(opt.value);
            }
            this.search = '';
            this.$refs.searchInput?.focus();
        },
        remove(id) {
            this.selected = this.selected.filter(i => i !== id);
        },
        isSelected(id) {
            return this.selected.includes(id);
        },
        displayLabel(opt) {
            if (!opt) return '';
            return opt.sublabel ? opt.label + ' (' + opt.sublabel + ')' : opt.label;
        },
        getOption(id) {
            return this.options.find(o => o.value == id);
        }
    }"
    class="relative"
    @click.away="open = false"
>
    @if($label)
        <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    @endif

    <div class="rounded-lg border border-gray-200 dark:border-gray-800 dark:bg-gray-800/50 overflow-hidden">
        <div class="flex flex-wrap gap-2 p-2 min-h-[42px]">
            <template x-for="id in selected" :key="id">
                <span class="inline-flex items-center gap-1 rounded-full bg-brand-100 px-2.5 py-1 text-theme-sm text-brand-800 dark:bg-brand-500/20 dark:text-brand-300">
                    <span x-text="getOption(id) ? displayLabel(getOption(id)) : id"></span>
                    <button type="button" @click.stop="remove(id)" class="hover:text-brand-900 dark:hover:text-brand-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </span>
            </template>
            <div class="flex-1 min-w-[120px]">
                <input
                    type="text"
                    x-ref="searchInput"
                    x-model="search"
                    @focus="open = true"
                    @keydown.escape="open = false; search = ''"
                    placeholder="{{ $placeholder }}"
                    class="w-full border-0 bg-transparent px-1 py-1 text-theme-sm text-gray-800 placeholder-gray-400 outline-none dark:text-white/90 dark:placeholder-gray-500"
                >
            </div>
        </div>
        <div
            x-show="open && search.trim()"
            x-transition
            class="border-t border-gray-200 dark:border-gray-700 max-h-48 overflow-y-auto"
        >
            <template x-if="search.trim() && filteredOptions.length === 0">
                <p class="px-3 py-4 text-center text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada hasil.</p>
            </template>
            <template x-for="opt in filteredOptions" :key="opt.value">
                <button
                    type="button"
                    @click="add(opt)"
                    class="w-full px-3 py-2 text-left text-theme-sm hover:bg-gray-100 dark:hover:bg-white/5"
                    :class="{ 'bg-brand-50 dark:bg-brand-500/10': isSelected(opt.value) }"
                >
                    <span x-text="displayLabel(opt)"></span>
                    <span x-show="isSelected(opt.value)" class="ml-2 text-brand-600 dark:text-brand-400">✓</span>
                </button>
            </template>
        </div>
    </div>

    <template x-for="id in selected" :key="'input-'+id">
        <input type="hidden" :name="'{{ $name }}[]'" :value="id">
    </template>

    @error($name)
        <p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>
    @enderror
</div>
