<x-filament-widgets::widget class="fixed z-10 md:hidden">
        <div class="w-full items-center gap-4 bg-white px-6 py-4 rounded-xl border-slate-200 border shadow-sm">
            <span class="text-sm text-gray-700">Project/Client:</span>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $record->name ?? '-' }}
            </h2>   
        </div>
    
</x-filament-widgets::widget>
