<x-filament-widgets::widget>
    
        <div class="w-full grid grid-cols-2 gap-4">
            
            <div class="flex flex-col justify-between bg-white hover:bg-slate-200 px-4 py-3 rounded-xl border-slate-200 border shadow-sm min-h-[100px] bg-no-repeat bg-cover bg-right-top " style="background-image: url({{asset('/FSR_BG.png')}});">
                <span class="font-bold text-4xl">{{ $counts['fsr'] }}</span>
                <span>No. of Field Service Reports</span>
            </div>
            

                <div class="flex flex-col justify-between bg-white hover:bg-slate-200 px-4 py-3 rounded-xl border-slate-200 border shadow-sm min-h-[100px] bg-no-repeat bg-cover bg-right-bottom" style="background-image: url({{asset('/FSR_BG.png')}})">
                    <span class="font-bold text-4xl">{{ $counts['project'] }}</span>
                    <span>No. of Projects/Clients</span>
                </div>
                

            
        </div>
    

    
</x-filament-widgets::widget>
