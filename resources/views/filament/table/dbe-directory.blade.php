<div class="mb-10 min-h-min py-4">
    <div class="overflow-hidden rounded-t-lg">
        <div class="bg-gradient-to-br from-sky-600 to-sky-900 px-2">
            <p class="text-xl text-white font-semibold uppercase opacity-0">
                {{ $getRecord()->status ?? null }}
            </p>
        </div>
        <div class="p-6">
            <p class="text-gray-600 py-2">Project Name: <strong>{{ $getRecord()->project->name }}</strong></p>

            <p class="text-gray-600 py-2">Contact No.:</p>
            @if($getRecord()->contact_no && is_array($getRecord()->contact_no))
                <span class="text-gray-600">
                    <strong>
                        {{ implode(', ', array_column($getRecord()->contact_no, 'contact_no')) }}
                    </strong>
                </span>
            @else
                <p><strong>No contacts available.</strong></p>
            @endif
            

            <p class="text-gray-600 py-2">Contact Person: <strong>{{ $getRecord()->contact_person }}</strong></p>
            <p class="text-gray-600 py-2">Designation: <strong>{{ $getRecord()->designation }}</strong></p>
            <p class="text-gray-600 py-2">Email: <strong>{{ $getRecord()->email_address }}</strong></p>
            <p class="text-gray-600 py-2">
                Status: 
                <span class="px-2 py-1 bg-red-600 text-white rounded-full">
                    <strong>{{ $getRecord()->status }}</strong>
                </span>
            </p>
        </div>
    </div>
</div>


{{-- <div class=" grid grid-cols-2">
   
        <p class="col-span-1  font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ $getRecord()->project->name }}
        </p>
        <p class="col-span-1 ">
            {{ $getRecord()->contact_no }}
        </p>
        <div class="col-span-1  ">
            {{ $getRecord()->contact_person }}
        </div>
        <div class="col-span-1  ">
            {{ $getRecord()->designation }}
        </div>
        <div class="col-span-1  ">
            {{ $getRecord()->email_address }}
        </div>
        <div class="  ">
            {{ $getRecord()->status }}
        </div>
        <div class="  ">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </div>
</div> --}}
