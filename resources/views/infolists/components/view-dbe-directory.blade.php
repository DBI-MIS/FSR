<div class="mb-10 min-h-min ">
    <div class="overflow-hidden rounded-lg shadow-lg">
        <div class="bg-gradient-to-br from-sky-600 to-sky-900 py-4 px-6 flex items-center justify-between">
            <div class="flex flex-col">
                <div class="text-3xl text-white font-bold ">
                    {{ $getRecord()->directoryproject->name }}
                </div>
                <div class="text-md text-white ">
                    {{ $getRecord()->directoryproject->address }}
                </div>
                {{-- <div class="inline-block mt-2 px-3 py-1 text-lg bg-red-600 text-white rounded-md">
                    <strong>{{ $getRecord()->status }}</strong>
                </div> --}}
            </div>
        </div>

        <div class="grid grid-cols-1 p-6 gap-4 bg-white">
            @forelse($getRecord()->contactsdbe as $contact)
                <div class="grid grid-cols-1 md:grid-cols-4 border text-wrap border-gray-200 rounded-lg py-2 px-4">
                    <div>
                        <p class="text-gray-500 text-xs">Contact Details:</p>
                        <span class="text-md text-gray-700 text-wrap font-semibold"> 
                           @if(is_array($contact->contact_no))
                                        @foreach($contact->contact_no as $cont)
                                            <div>{{ $cont['contact_no'] ?? 'No contacts ' }}</div>
                                        @endforeach
                                    @else
                                        <p>No contacts</p>
                             @endif
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Name:</p>
                        <span class="text-md text-gray-700 text-wrap font-semibold">{{ $contact->contact_person }}</span>
                    </div>
                     <div class="">
                        <p class="text-gray-500 text-xs">Email:</p>
                        <p class="text-md text-gray-700 break-words font-semibold">{{ $contact->email_address }}</>
                    </div>
                     <div>
                         <p class="text-gray-500 text-xs">Designation:</p>
                        <span class="text-md text-gray-700 break-words text-wrap font-semibold">{{ $contact->designation }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-600 py-6">
                    <span>No Contact Details Available</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
