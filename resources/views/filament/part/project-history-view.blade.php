<div class="container mx-auto py-8">
    <div class="mb-10 min-h-min bg-white py-4 px-4 border border-gray-300 rounded-lg w-full ">
        <div class="flex flex-row justify-between">
        <div class="flex flex-col w-full items-start pt-2 pb-6">
            <span class="text-sm text-gray-700">Project/Client:</span>
            <h2 class="text-3xl font-bold text-gray-600 dark:text-white">{{ $record->name ?? '-' }}</h2>
        </div>

        <div class="mb-4">
            <form method="GET" action="{{ route('filament.admin.resources.projects.history', $record->id) }}" >
                {{-- <label for="attended_to_filter" class="block text-sm text-gray-700">Filter</label> --}}
                <div class="flex flex-row items-center">
                    <select id="attended_to_filter" name="attended_to" class="block w-full bg-gray-50 border-b border-gray-300 shadow-sm ">
                        <option value="">All</option>
                        @foreach([
                            'Preventive Maintenance' => 'Preventive Maintenance',
                            'Trouble Call' => 'Trouble Call',
                            'Check Up' => 'Check-up',
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
                            'Others' => 'Others'
                        ] as $value => $label)
                            <option value="{{ $value }}" {{ request('attended_to') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                <button type="submit" class=" bg-blue-500 text-white py-2 px-4 ">Filter</button>
            </div>
            </form>
        </div>
    </div>


        <div>
            <span class="text-sm text-gray-700">History:</span>
            <hr>
            <div class="w-full">
                <table class="w-full bg-white">
                    <thead>
                        <tr class="w-full bg-gray-200 text-gray-600 uppercase text-xs leading-normal font-bold">
                            <th class="py-3 px-6 text-center">Date</th>
                            <th class="py-3 px-6 text-center">FSR No.:</th>
                            <th class="py-3 px-6 text-center">Attended To</th>
                            <th class="py-3 px-6 text-center">Concerns</th>
                            <th class="py-3 px-6 text-center">Service Rendered</th>
                            <th class="py-3 px-6 text-center">Recommendation</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($fsrs as $fsr)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left text-nowrap">{{ $fsr->job_date_started ?? '-' }}</td>
                                <td class="py-3 px-6 text-left text-nowrap">{{ $fsr->fsr_no ?? '-' }}</td>
                                <td class="py-3 px-6 text-left uppercase">
                                    @if(is_array($fsr->attended_to))
                                        {{ implode(', ', $fsr->attended_to) }}
                                    @else
                                        {{ $fsr->attended_to ?? '-' }}
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left">{{ $fsr->concerns ?? '-' }}</td>
                                <td class="py-3 px-6 text-left">{{ $fsr->service_rendered ?? '-' }}</td>
                                <td class="py-3 px-6 text-left">{{ $fsr->recommendation ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-6 text-center text-gray-500">No history available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $fsrs->links() }}
            </div>
        </div>
    </div>
</div>
