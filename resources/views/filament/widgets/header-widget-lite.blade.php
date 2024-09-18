<x-filament-widgets::widget wire:init="getViewData">
    

    <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 ">
        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate
            href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Preventive+Maintenance') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl ">{{ $counts['Preventive Maintenance'] }}</span>
            <span class="text-sm">Preventive Maintenance</span>
            
        </div>

        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Trouble+Call') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Trouble Call'] }}</span>
            <span class="text-sm">Trouble Call</span>
        </div>

        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Check-up') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Check Up'] }}</span>
            <span class="text-sm">Check Up</span>
        </div>

        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Evaluation') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Evaluation'] }}</span>
            <span class="text-sm">Evaluation</span>
        </div>


        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Start+Up') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Start Up'] }}</span>
            <span class="text-sm">Start Up</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Testing') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Testing'] }}</span>
            <span class="text-sm">Testing</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Commissioning') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Commissioning'] }}</span>
            <span class="text-sm">Commissioning</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Monitoring') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Monitoring'] }}</span>
            <span class="text-sm">Monitoring</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Site+Inspection') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Site Inspection'] }}</span>
            <span class="text-sm">Site Inspection</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Operatorship') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Operatorship'] }}</span>
            <span class="text-sm">Operatorship</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Parts') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Parts/Installation'] }}</span>
            <span class="text-sm">Parts/ Installation</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Repair') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Repair/Modification'] }}</span>
            <span class="text-sm">Repair/ Modification</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Hauling') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Hauling'] }}</span>
            <span class="text-sm">Hauling</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Delivery') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Delivery'] }}</span>
            <span class="text-sm">Delivery</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Retrofitting') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Retrofitting'] }}</span>
            <span class="text-sm">Retrofitting</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer relative"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Others') }}">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <x-filament::loading-indicator class="h-10 w-10" />
            </div>
            <span class="font-bold text-2xl">{{ $counts['Others'] }}</span>
            <span class="text-sm">Others</span>
        </div>


    </div>

</x-filament-widgets::widget>
