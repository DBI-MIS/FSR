<div>
<div class="w-full inline-flex gap-4 justify-start">
    <p>Today is <span class="font-bold"> {{ $currentDate }} </span></p>
    <p>Time: <span class="font-bold">{{ $currentTime }} </span></p>
</div>
<hr>

<div class="flex justify-between items-center mt-4">
    
   
    <a href="{{ $backUrl }}" class=" rounded-md text-slate-400 px-2 py-2 my-auto hover:text-white hover:bg-slate-500 hover:shadow-sm hover:shadow-black/20">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
          </svg> 
    </a>
    <a href="{{ $editUrl }}" class="bg-blue-500 rounded-md text-white px-5 py-1 my-auto hover:bg-blue-800 shadow-sm shadow-black/20">
            Edit
    </a>
    {{-- <a href="{{ $downloadPdfUrl }}" class="bg-blue-500 rounded-md text-white px-5 py-1 my-auto hover:bg-blue-800 shadow-sm shadow-black/20">
        Save PDF
    </a> --}}
    
</div>
</div>