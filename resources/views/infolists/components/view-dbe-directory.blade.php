<div class="mb-10 min-h-min py-4">
    <div class="overflow-hidden rounded-t-lg">
        <div class=" bg-gradient-to-br from-sky-600 to-sky-900 py-2 px-5">
            <p class="text-2xl text-white font-semibold uppercase mb-2">
                {{ $getRecord()->project->name ?? null }}
            </p>
            <span class=" px-2 py-1 text-lg bg-red-600 text-white rounded-md">
                <strong>{{ $getRecord()->status }}</strong>
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 p-6 bg-white shadow-[0px_29px_147px_35px_rgba(165,_39,_255,_0.48)]">

          
            
            <div class="text-gray-600 py-2">
                <p>Contact Person: </p>
                <span class="text-lg">
                <strong>
                    {{ $getRecord()->contact_person }}
                </strong>
                </span>

            </div>

           <div  class="text-gray-600 py-2">
                <p>Designation:</p>
                <span class="text-lg">
                    <strong>{{ $getRecord()->designation }}</strong>
                </span>
           </div>

           <div  class="text-gray-600 py-2">
                <p class="text-gray-600 py-2">Email: </p>
                <span class="text-lg">
                    <strong>{{ $getRecord()->email_address }}</strong>
                </span>
           </div>
           <div class="text-gray-600 py-2">
            <p >Contact No.:</p>
            @if($getRecord()->contact_no && is_array($getRecord()->contact_no))
            <span class="text-lg">
                    <strong>
                        {{ implode(', ', array_column($getRecord()->contact_no, 'contact_no')) }}
                    </strong>
                </span>
            @else
                <p  class="text-lg" ><strong>No contacts available.</strong></p>
            @endif
        </div>
           
            
        </div>
    </div>
</div>