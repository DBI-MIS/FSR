<div class="flex flex-col gap-4">
    
    
    <div class="bg-gradient-to-br from-sky-600 to-sky-900 rounded-lg py-1 px-2 flex justify-between w-full items-center gap-2 group ">
    <img src="{{ asset('/DB_LOGO_WHITE_.png')}}" alt="" class="h-6 group-hover:rotate-90 ease-in-out transition-all duration-500">
    <p class="text-white group-hover:text-slate-400 ease-in-out transition-all duration-500">
        <span class="font-light text-sm">
            Date:
        </span>
        <span class="text-sm font-bold">
            {{ $getRecord()
            ->job_date_started
            ->format('M d, Y')
             ?? 'NA'}}
        </span>
    </p>
    </div>
   

<div class="grid grid-cols-2 gap-1">
    <p>
        <span class="font-light text-xs">
            FSR No.:
        </span>
        <br>
        <span class="text-2xl font-bold">
            {{ $getRecord()->fsr_no }}
        </span>
    </p>
    <p>
        <span class="font-light text-xs">
            Project/Client:
        </span>
        <br>
        <span class="text-lg font-bold">
            {{ $getRecord()->project->name }}
        </span>
    </p>
    

    
    {{-- <p>
    <span class="font-light text-xs">
        Attended to:
    </span>
    <br>
    @forelse ( $getRecord()->attended_to as $attended )
    <span class="text-base font-bold">
        {{ $attended }}
        @if (!$loop->last),@endif
        @empty
        <span>NA</span>
    </span>
    @endforelse
</p> --}}


</div>
<x-filament-tables::columns.layout :components="$getComponents()" :record="$getRecord()" :record-key="$recordKey" />
<div class="border-t-2 flex justify-end">
   
    <p class="text-slate-400">
        <span class="font-light text-xs">
            Updated:
        </span>
        <span class="text-xs font-bold">
            {{ $getRecord()->updated_at->diffForHumans() }}
        </span>
    </p>
</div>
</div>
