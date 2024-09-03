<x-filament-widgets::widget>

    <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 ">
        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate
            href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Preventive+Maintenance') }}">
            <span class="font-bold text-2xl ">{{ $counts['Preventive Maintenance'] }}</span>
            <span class="text-sm">Preventive Maintenance</span>
        </div>

        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Trouble+Call') }}">
            <span class="font-bold text-2xl">{{ $counts['Trouble Call'] }}</span>
            <span class="text-sm">Trouble Call</span>
        </div>

        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Check-up') }}">
            <span class="font-bold text-2xl">{{ $counts['Check Up'] }}</span>
            <span class="text-sm">Check Up</span>
        </div>

        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Evaluation') }}">
            <span class="font-bold text-2xl">{{ $counts['Evaluation'] }}</span>
            <span class="text-sm">Evaluation</span>
        </div>


        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Start+Up') }}">
            <span class="font-bold text-2xl">{{ $counts['Start Up'] }}</span>
            <span class="text-sm">Start Up</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Testing') }}">
            <span class="font-bold text-2xl">{{ $counts['Testing'] }}</span>
            <span class="text-sm">Testing</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Commissioning') }}">
            <span class="font-bold text-2xl">{{ $counts['Commissioning'] }}</span>
            <span class="text-sm">Commissioning</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Monitoring') }}">
            <span class="font-bold text-2xl">{{ $counts['Monitoring'] }}</span>
            <span class="text-sm">Monitoring</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Site+Inspection') }}">
            <span class="font-bold text-2xl">{{ $counts['Site Inspection'] }}</span>
            <span class="text-sm">Site Inspection</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Operatorship') }}">
            <span class="font-bold text-2xl">{{ $counts['Operatorship'] }}</span>
            <span class="text-sm">Operatorship</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Parts') }}">
            <span class="font-bold text-2xl">{{ $counts['Parts/Installation'] }}</span>
            <span class="text-sm">Parts/ Installation</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Repair') }}">
            <span class="font-bold text-2xl">{{ $counts['Repair/Modification'] }}</span>
            <span class="text-sm">Repair/ Modification</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Hauling') }}">
            <span class="font-bold text-2xl">{{ $counts['Hauling'] }}</span>
            <span class="text-sm">Hauling</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Delivery') }}">
            <span class="font-bold text-2xl">{{ $counts['Delivery'] }}</span>
            <span class="text-sm">Delivery</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Retrofitting') }}">
            <span class="font-bold text-2xl">{{ $counts['Retrofitting'] }}</span>
            <span class="text-sm">Retrofitting</span>
        </div>



        <div class="flex flex-col justify-start gap-4 bg-white hover:bg-slate-200 px-4 py-4 rounded-xl border-slate-200 border shadow-sm cursor-pointer"
            wire:navigate href="{{ url('/fsrs?tableFilters%5Battended_to%5D%5Battended_to%5D=Others') }}">
            <span class="font-bold text-2xl">{{ $counts['Others'] }}</span>
            <span class="text-sm">Others</span>
        </div>


    </div>

</x-filament-widgets::widget>
