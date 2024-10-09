<x-filament-widgets::widget>
    <div wire:loading.inline>
        <x-filament::loading-indicator class="h-10 w-10 mx-auto" />
    </div>
    <div class="w-full flex flex-col sm:flex-row min-h-[100px] items-center justify-between gap-4 bg-white px-6 py-4 sm:py-0 rounded-xl border-slate-200 border shadow-sm">
        <div class="w-full flex items-center justify-between sm:justify-start gap-1">
            <span class="text-[50pt] font-bold">{{ $currentTime->format('d') }}</span>
            <div class="flex flex-col items-end">
                <span class="text-xl font-bold">{{ $currentTime->format('M `Y') }}</span>
                <span class="font-medium text-xl">{{ $currentTime->format('l') }}</span>
                <span class="text-xs">{{ $currentTime->format('z') }} Days</span>
            </div>
            
        </div>
        
      
        {{-- <div class="w-full flex justify-between items-center gap-1 bg-gradient-to-br from-sky-600 to-sky-900 text-white rounded-md divide-x divide-white "> --}}
            <div class="w-full flex flex-row justify-start sm:justify-end items-center gap-1">

            <div href="{{route('filament.admin.resources.fsrs.create')}}"
            wire:navigate class="text-nowrap text-center cursor-pointer bg-gradient-to-br from-sky-600 to-sky-900 text-white rounded-md w-[74px] py-2">
            <x-heroicon-m-document-plus class="w-8 mx-auto"/>
            <span class="text-[10px]">FSR</span>
            </div>

            <div href="{{route('filament.admin.resources.projects.create')}}"
            wire:navigate class="text-nowrap text-center cursor-pointer bg-gradient-to-br from-sky-600 to-sky-900 text-white rounded-md w-[74px] py-2">
            <x-heroicon-m-arrow-down-on-square class="w-8 mx-auto"/>
            <span class="text-[10px]">Project</span>
            </div>

            <div href="{{route('filament.admin.resources.dbe-personnels.create')}}"
            wire:navigate class="text-nowrap text-center cursor-pointer bg-gradient-to-br from-sky-600 to-sky-900 text-white rounded-md w-[74px] py-2">
            <x-heroicon-m-user-plus class="w-8 mx-auto"/>
            <span class="text-[10px]">Personnel</span>
            </div>
            
        </div>
            
           
        
    </div>
</x-filament-widgets::widget>
