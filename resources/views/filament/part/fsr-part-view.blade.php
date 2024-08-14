<div class="mb-20">
    <div  class="max-w-[1024px] min-h-full mx-auto bg-white my-5 px-6 py-14 rounded-lg shadow-lg shadow-black/20">
        <span class="float-right font-bold">Form-2</span>
        <div class="h-auto sm:h-16 flex flex-row items-center my-4 gap-32">
          <img src="{{ asset('/DB_LOGO.png')}}" alt="" class="h-12 md:h-full">
            <div class="text-xl sm:text-2xl md:text-4xl  font-black uppercase hidden sm:inline-block">
                Field Service Report
            </div>
          <div class="text-4xl font-black uppercase sm:hidden">FSR</div>
        </div>
         <hr class="border-2 border-black mb-2">
         <hr class="border-1 border-black">

         <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex flex-col my-3">
                <div class="inline-block gap-6">
                    <span class="text-base  mr-2">Client:</span>
                    <span class="text-base font-bold">{{ $getRecord()->project->name ?? '-' }}</span>
                 </div>
                <div class="inline-block gap-6">
                    <span class="text-base  mr-2">FSR No.:</span>
                    <span class="text-base font-bold">{{ $getRecord()->fsr->fsr_no ?? '-' }}</span>
                </div>
                
                <div class="inline-block gap-6">
                    <span class="text-base mr-2">Date:</span>
                      <span class="text-base font-bold">{{ $getRecord()->fsr_date->format("M d, Y")  ?? '-' }}</span> 
                </div>
            </div>
        </div>
        {{-- <div class="flex flex-col justify-center content-center  mx-20  gap-4">
            <div class="flex flex-col my-2">
               
                <div class="inline-block gap-6 my-2 min-h-40">
                    <span class="text-sm ">Findings:</span>
                    <br>
                    <span class="text-base font-bold">{{ $getRecord()->findings?? '-'  }}</span>
                  </div>
                  <div class="inline-block gap-6 my-2 min-h-40">
                    <span class="text-sm ">History:</span>
                    <br>
                    <span class="text-base font-bold">{{ $getRecord()->history?? '-'  }}</span>
                  </div>
                  <div class="inline-block gap-6 my-2 min-h-40">
                    <span class="text-sm ">Action Done:</span>
                    <br>
                    <span class="text-base font-bold">{{ $getRecord()->action_done?? '-'  }}</span>
                  </div>
                  <div class="inline-block gap-6 my-2 min-h-40 mb-20">
                    <span class="text-sm font-bold ">Recommendation / For Customer Urgent Action</span>
                    <br>
                    <span class="text-base font-bold">{{ $getRecord()->recommendation?? '-'  }}</span>
                  </div>
            </div>
        </div> --}}
        <div class="mx-20 my-2">
            <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                <div class="sm:col-span-1 text-sm font-bold">Findings:</div>
                <div class="sm:col-span-4 text-base font-bold min-h-40">{{ $getRecord()->findings ?? '-' }}</div>
        
                <div class="sm:col-span-1 text-sm font-bold">History:</div>
                <div class="sm:col-span-4 text-base font-bold min-h-40">{{ $getRecord()->history ?? '-' }}</div>
        
                <div class="sm:col-span-1 text-sm font-bold">Action Done:</div>
                <div class="sm:col-span-4 text-base font-bold min-h-40">{{ $getRecord()->action_done ?? '-' }}</div>
        
                <div class="sm:col-span-1 text-sm font-bold">Recommendation / For Customer Urgent Action:</div>
                <div class="sm:col-span-4 text-base font-bold min-h-40 mb-20">{{ $getRecord()->recommendation ?? '-' }}</div>
            </div>
        </div>

        <div class="flex float-end mx-10 ">
            <div>
                <hr class="border-black " >
                <span> Customer's Name & Signature</span>
            </div>
        </div>
    </div>
</div>
