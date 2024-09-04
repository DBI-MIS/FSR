<x-filament-widgets::widget>
   
        <div class="w-full flex flex-col min-h-[100px] items-center justify-between gap-4 bg-white px-6 py-4 rounded-xl border-slate-200 border shadow-sm">
            <div class="w-full flex items-center justify-between">
                <h1 class="text-xl font-medium">Hi there <span class="capitalize">{{ $user->name }}</span>!</h1>
                <span class="font-medium text-xl">{{ $currentTime->format('l - M d, Y') }}</span>
            </div>
        
        </div>
   
</x-filament-widgets::widget>
