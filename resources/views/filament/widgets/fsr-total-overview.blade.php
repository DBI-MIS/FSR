<x-filament-widgets::widget wire:init="getViewData">
    
        <div class="w-full grid grid-cols-2 gap-4">
            
            <div class="flex flex-col justify-between bg-white hover:bg-slate-200 px-4 py-3 rounded-xl border-slate-200 border shadow-sm min-h-[100px] bg-no-repeat bg-cover bg-right-top relative " style="background-image: url({{asset('/FSR_BG.png')}});">
                
                <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                    <x-filament::loading-indicator class="h-10 w-10" />
                </div>
                <span class="font-bold text-4xl">{{ $counts['fsr'] }}</span>
                <span>No. of Field Service Reports</span>
            </div>
            

                <div class="flex flex-col justify-between bg-white hover:bg-slate-200 px-4 py-3 rounded-xl border-slate-200 border shadow-sm min-h-[100px] bg-no-repeat bg-cover bg-right-bottom relative" style="background-image: url({{asset('/FSR_BG.png')}})">
                    
                    <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <x-filament::loading-indicator class="h-10 w-10" />
                    </div>
                    <span class="font-bold text-4xl">{{ $counts['project'] }}</span>
                    <span>No. of Projects/Clients</span>
                </div>
                

            
        </div>
    

    
</x-filament-widgets::widget>
