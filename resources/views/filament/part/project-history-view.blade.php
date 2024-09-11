<div class="container mx-auto py-8">
    <div class="mb-10 min-h-min bg-white py-4 px-4 border border-gray-300 rounded-lg w-full ">
        <div class="flex flex-col xl:flex-row justify-between">
            <div class="flex flex-col w-full items-start pt-2 pb-6">
                <span class="text-sm text-gray-700">Project/Client:</span>
                <h2 class="text-3xl font-bold text-gray-600 dark:text-white">{{ $record->name ?? '-' }}</h2>
            </div>

            <div class="mb-4">
                <form method="GET" action="{{ route('filament.admin.resources.projects.history', $record->id) }}">
                    <div class="flex flex-col md:flex-row gap-2 items-start">
                            
                            <input type="date" id="from_date" name="from_date" class="block w-full bg-gray-50 border-b border-gray-300 shadow-sm rounded-md" 
                                value="{{ request('from_date') }}" >
                               
                            <input type="date" id="to_date" name="to_date" class="block w-full bg-gray-50 border-b border-gray-300 shadow-sm rounded-md" 
                                value="{{ request('to_date') }}">
                       
                            <select id="attended_to_filter" name="attended_to" class="block w-full bg-gray-50 border-b border-gray-300 shadow-sm rounded-md" style="min-width: 200px">
                                <option value="">All</option>
                                @foreach ([
                                    'Preventive Maintenance' => 'Preventive Maintenance',
                                    'Trouble Call' => 'Trouble Call',
                                    'Check Up' => 'Check Up',
                                    'Evaluation' => 'Evaluation',
                                    'Start Up' => 'Start Up',
                                    'Testing' => 'Testing',
                                    'Commissioning' => 'Commissioning',
                                    'Monitoring' => 'Monitoring',
                                    'Site Inspection' => 'Site Inspection',
                                    'Operatorship' => 'Operatorship',
                                    'Parts/Installation' => 'Parts/Installation',
                                    'Repair/Modification' => 'Repair/Modification',
                                    'Hauling' => 'Hauling',
                                    'Delivery' => 'Delivery',
                                    'Retrofitting' => 'Retrofitting',
                                    'Others' => 'Others',
                                ] as $value => $label)
                                    <option value="{{ $value }}" {{ request('attended_to') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        <div class="inline-flex gap-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-800 text-white py-2 px-4 cursor-pointer shadow-sm rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                          </svg>
                          </button>
                        <button href="{{ route('filament.admin.resources.projects.history', $record->id) }}" 
                            class="bg-gray-300 hover:bg-gray-500 text-gray-700 py-2 px-4 cursor-pointer shadow-sm rounded-md" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                              </svg>
                              </button>
                            </div>
                            
                    </div>
                </form>
            </div>

        </div>


        <div>
            

    <!-- Query Label -->
    <span class="text-sm text-gray-500">
        @if(request('from_date') || request('to_date') || request('attended_to'))
        <span class="text-sm text-gray-700">History</span>
            {{-- <strong>Queried:</strong> --}}
            @if(request('from_date'))
                from <strong>{{ \Carbon\Carbon::parse(request('from_date'))->format('M j, Y') }}</strong>
            @endif
            @if(request('to_date'))
                to <strong>{{ \Carbon\Carbon::parse(request('to_date'))->format('M j, Y') }}</strong>
            @endif
            @if(request('attended_to'))
                - <strong>{{ request('attended_to') }}</strong>
            @endif
        @else
            <strong> </strong>
        @endif
    </span>
            <div class="w-full mt-4 overflow-hidden rounded-lg">
                <table class="w-full bg-white ">
                    <thead>
                        <tr class="w-full bg-gradient-to-br from-sky-600 to-sky-900 text-white uppercase text-sm leading-normal font-bold">
                            <th class="py-1 px-1 text-center">Date</th>
                            <th class="py-1 px-1 text-center">FSR No.:</th>
                            <th class="py-1 px-1 text-center">Attended To</th>
                            <th class="py-1 px-1 text-center">Concerns</th>
                            <th class="py-1 px-1 text-center">Service Rendered</th>
                            <th class="py-1 px-1 text-center">Recommendation</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($fsrs as $fsr)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 even:bg-blue-50/50">
                                <td class="py-3 px-6 text-left text-nowrap">{{ $fsr->job_date_started ? \Carbon\Carbon::parse($fsr->job_date_started)->format('M j, Y') : 'No Date' }}</td>
                                <td class="py-3 px-6 text-left text-nowrap">{{ $fsr->fsr_no ?? 'No FSR' }}</td>
                                <td class="py-3 px-6 text-left uppercase">
                                    @if (is_array($fsr->attended_to))
                                        {{ implode(', ', $fsr->attended_to) }}
                                    @else
                                        {{ $fsr->attended_to ?? 'No Data' }}
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left">{{ $fsr->concerns ?? 'No Concerns' }}</td>
                                <td class="py-3 px-6 text-left">{{ $fsr->service_rendered ?? 'No Service Rendered' }}</td>
                                <td class="py-3 px-6 text-left">{{ $fsr->recommendation ?? 'No Recommendation' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-6 text-center text-gray-500">No history available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <div class="bg-white p-4">
                @forelse($fsrs as $fsr)
                    <div class="text-sm text-balance">
                        <span class="text-gray-500">Date:</span>
                        <strong>{{ $fsr->job_date_started ? \Carbon\Carbon::parse($fsr->job_date_started)->format('M j, Y') : 'No Date' }}
                        </strong> |
                        <span class="text-gray-500">FSR:</span> <strong> {{ $fsr->fsr_no ?? 'No FSR' }} </strong> |
                        <span class="text-gray-500">Service Type:</span>
                        <strong>
                            @if (is_array($fsr->attended_to))
                                {{ implode(', ', $fsr->attended_to) }}
                            @else
                                {{ $fsr->attended_to ?? 'No Data' }}
                            @endif
                        </strong> |

                        <span class="text-gray-500">Concerns:</span>
                        <strong>
                            {{ $fsr->concerns ?? 'No Concerns' }} </strong> |

                        <span class="text-gray-500">Service Rendered:</span>
                        <strong>
                            {{ $fsr->service_rendered ?? 'No Service Rendered' }} </strong> |

                        <span class="text-gray-500">Recommendation:</span>
                        <strong>
                            {{ $fsr->recommendation ?? 'No Recommendation' }} </strong> *
                    </div>
                    <hr>
                @empty

                    <td colspan="6" class="py-3 px-6 text-center text-gray-500">No history available.</td>
                @endforelse

            </div> --}}

            <div class="mt-4">
                {{ $fsrs->links() }}
            </div>
        </div>
    </div>
</div>
