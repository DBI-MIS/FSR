<x-filament-widgets::widget>
    
        <div class="w-full flex min-h-[100px] items-center justify-between gap-4 bg-white hover:bg-slate-200 px-10 py-4 rounded-xl border-slate-200 border shadow-sm">
            <h1 class="text-xl font-medium">Hi there <span class="capitalize">{{ $user->name }}</span>! </h1>
            <span class="font-medium text-xl">{{ $currentTime->format('l - M d, Y') }}</span>
        </div>
    
</x-filament-widgets::widget>
