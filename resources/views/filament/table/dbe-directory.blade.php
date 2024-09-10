<div class="min-h-min">
    <div class="overflow-hidden rounded-t-lg">
        <div class="bg-gradient-to-br from-sky-600 to-sky-900 px-2">
            <p class="text-xl text-white font-semibold uppercase opacity-0">
                {{ $getRecord()->status ?? null }}
            </p>
        </div>
        <div class="px-6 py-2">
            <div>
                <span class="text-sm">Project Name:</span>
                <p class="text-gray-600  text-xl"> <strong>{{ $getRecord()->directoryproject->name ?? '-' }}</strong></p>
            </div>
            <p class="text-gray-600 py-2 text-sm">
                Status: 
                <span class="px-4 text-md py-1 bg-red-600 text-white rounded-full">
                    <strong>{{ $getRecord()->status ?? '-' }}</strong>
                </span>
            </p>

            <table class="w-full bg-white">
                <thead>
                    <tr class="w-full bg-gray-200 text-gray-600 uppercase text-xs leading-normal font-bold">
                        <th class="py-3 px-6 text-center">Contact</th>
                        <th class="py-3 px-6 text-center">Name</th>
                       
                        <th class="py-3 px-6 text-center">Email</th>
                        <th class="py-3 px-6 text-center">Designation</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($getRecord()->contactsdbe as $directory)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left text-nowrap">{{ $directory->contact_no ?? '-' }}</td>
                            <td class="py-3 px-6 text-left text-nowrap">{{ $directory->contact_person ?? '-' }}</td>
                          
                            <td class="py-3 px-6 text-left">{{ $directory->email_address ?? '-' }}</td>
                            <td class="py-3 px-6 text-left">{{ $directory->designation ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center text-gray-500">No history available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- @forelse ($getRecord()->directoryproject as $directory )
                
            @empty
                
            @endforelse --}}
            

            {{-- @php
                $firstContact = $getRecord()->contactsdbe->first();
            @endphp

            @if($firstContact)
                <p class="text-gray-600 text-sm py-2">Contact No.: 
                    <span class="text-lg"><strong> {{ $firstContact->contact_no }}</strong></span>
                </p>
                   
                <p class="text-gray-600 py-1 text-sm">Contact Person: 
                    <span class="text-lg"><strong>{{ $firstContact->contact_person ?? '-' }}</strong> </span>
                </p>
                <p class="text-gray-600 py-1 text-sm">Designation: 
                    <span class="text-lg"><strong>{{ $firstContact->designation ?? '-' }}</strong></span> 
                </p>
                <p class="text-gray-600 py-1 text-sm">Email: 
                    <span class="text-lg"><strong>{{ $firstContact->email_address ?? '-' }}</strong></span>
                </p>
            @else
                <span class="text-base font-bold">No Contact Info Available</span>
            @endif --}}

            
        </div>
    </div>
</div>
