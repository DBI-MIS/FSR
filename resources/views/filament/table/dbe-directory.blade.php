<div class="min-h-min">
    <div class="overflow-hidden rounded-t-lg">
        <div class="bg-gradient-to-br from-sky-600 to-sky-900 px-2">
            <p class="text-xl text-white font-semibold uppercase opacity-0">
                {{ $getRecord()->status ?? null }}
            </p>
        </div>

        @php
        $latestFsr= $getRecord()->directoryproject->fsrs->sortByDesc('created_at')->first();
        @endphp
        <div class=" px-6 py-2">
            <div class="flex justify-between">
                <div>
                    <span class="text-sm">Project Name:</span>
                    <p class="text-gray-600  text-xl"> <strong>{{ $getRecord()->directoryproject->name ?? '-' }}</strong></p>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-gray-600 py-2  text-sm">
                        <span class="px-3 text-md py-1 {{$getRecord()->status === 'active' ? 'bg-green-600' : ' bg-red-600'}} text-white rounded-full">
                            <strong>{{ $getRecord()->status ?? '-' }}</strong>
                        </span>
                    </p>
                    <p class="text-gray-600 text-md">
                        <span class="text-sm">
                            Last Service Update:
                            </span>
                        <span >
                            <strong>{{ $latestFsr ? \Carbon\Carbon::parse($latestFsr->job_date_started)->format('M d, Y') : 'No Update' }}</strong>
                        </span>
                       
                    </p>
                 
                </div>
                
            </div>

            <table class="w-full bg-white mt-4">
                <thead>
                    <tr class="w-full bg-gray-200 text-gray-600 uppercase text-xs leading-normal font-bold">
                        <th class="py-3 text-left px-3 ">Contact Details</th>
                        <th class="py-3 text-left px-3 ">Name</th>
                       
                        <th class="py-3 text-left px-3 ">Email</th>
                        <th class="py-3 text-left px-3 ">Designation</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($getRecord()->contactsdbe as $directory)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class=" py-3 px-2 text-left text-nowrap">
                                <span class="flex flex-row items-center gap-2">
                                      @if(is_array($directory->contact_no))
                                            <div class="grid gap-2 ">
                                                    @foreach($directory->contact_no as $contact)
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                                            </svg>
                                                            {{ $contact['contact_no'] ?? 'No contacts ' }}
                                                        </div>
                                                    @endforeach
                                            </div>
                                        @else
                                          <p>No contacts</p>
                                        @endif
                                     
                                 
                                </span>
                            </td>
                            <td class=" py-3 px-2 text-left text-nowrap">
                                <span class="flex flex-row items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                      </svg>  
                                      
                                    {{ $directory->contact_person ?? '-' }}
                                </span>
                            </td>
                          
                            <td class=" py-3 px-2 text-left">
                                <span class="flex flex-row items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                      </svg>
                                   
                                      {{ $directory->email_address ?? '-' }}</td>

                                </span>
                              
                            <td class=" py-3 px-2 text-left">
                                <span class="flex flex-row items-center  gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                      </svg>
                                    {{ $directory->designation ?? '-' }}
                                </span>
                               </td>
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
