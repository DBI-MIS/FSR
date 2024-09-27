<x-filament-widgets::widget>
    <x-filament::section>

        <div class="w-full flex flex-row ">



            <table class="w-full">

                <thead class="text-left">
                    <tr>
                        <th>Project/Client</th>
                        <th>PM Frequency</th>
                        <th>Contract Period</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">1</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">2</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">3</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">4</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">5</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">6</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">7</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">8</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">9</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">10</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">11</th>
                        <th colspan="2" style="width: 36px" class="text-center text-xs text-gray-400">12</th>
                    </tr>

                </thead>
                <tbody >

                    @forelse ($services as $service)
                    <tr class="odd:bg-gray-100 even:bg-white">

                            <td>{{ $service->pm_project->name }}</td>
                            <td>{{ $service->subscription }}</td>
                            {{-- <td>{{ $service->start_date }} to {{ $service->end_date }} </td> --}}
                            <td>
                                {{ \Carbon\Carbon::parse($service->start_date)->format('m-d-Y') }} <span class="text-xs">to</span> {{ \Carbon\Carbon::parse($service->end_date)->format('m-d-Y') }}
                            </td>
                            


                            {{-- @foreach ($service->date_slots as $slot)
                                @foreach ($slot['data'] as $key => $date)
                                    <td>
                                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5"
                                            style="width: 100%;"></div>
                                    </td>
                                @endforeach
                            @endforeach --}}

                            @foreach ($service->date_slots as $slot)
                                @if ($slot['type'] === 'BIMONTHLY')
                                    @foreach ($slot['data'] as $key => $date)
                                        <td colspan="1">
                                            <abbr title="{{ $date ? 'Served: '.$date : 'Not yet served.' }}">
                                            <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5"
                                                style="width: 100%;"></div>
                                            </abbr>
                                        </td>
                                    @endforeach
                                @endif

                                @if ($slot['type'] === 'MONTHLY')
                                @foreach ($slot['data'] as $key => $date)
                                    <td colspan="2">
                                        <abbr title="{{ $date ? 'Served: '.$date : 'Not yet served.' }}">
                                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5"
                                            style="width: 100%;"></div>
                                        </abbr>
                                    </td>
                                @endforeach
                                @endif

                                @if ($slot['type'] === 'QUARTERLY')
                                @foreach ($slot['data'] as $key => $date)
                                    <td colspan="6">
                                        <abbr title="{{ $date ? 'Served: '.$date : 'Not yet served.' }}">
                                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5"
                                            style="width: 100%;"></div>
                                        </abbr>
                                    </td>
                                @endforeach
                                @endif

                                @if ($slot['type'] === 'SEMI-ANNUAL')
                                @foreach ($slot['data'] as $key => $date)
                                    <td colspan="12">
                                        <abbr title="{{ $date ? 'Served: '.$date : 'Not yet served.' }}">
                                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5"
                                            style="width: 100%;"></div>
                                        </abbr>
                                    </td>
                                @endforeach
                                @endif

                                @if ($slot['type'] === 'ANNUAL')
                                @foreach ($slot['data'] as $key => $date)
                                    <td colspan="24">
                                        <abbr title="{{ $date ? 'Served: '.$date : 'Not yet served.' }}">
                                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5"
                                            style="width: 100%;"></div>
                                        </abbr>
                                    </td>
                                @endforeach
                                @endif


                            @endforeach







                        </tr>
                    @empty
                        <tr>
                            <td colspan="1">Empty</td> <!-- Display when there are no services -->
                        </tr>
                    @endforelse


                </tbody>
            </table>

            {{-- <table class="gantt-chart w-full border-collapse">
                <thead class="text-left ">
                    
                </thead>
                <tbody>
                    @foreach ($service->date_slots as $slot)
                        <tr>
                            @foreach ($slot['data'] as $key => $date)
                                <td class="">
                                    <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}

        </div>





        {{-- {{ $services }} <!-- You can also output the raw collection here if needed --> --}}
    </x-filament::section>
</x-filament-widgets::widget>

{{-- {
    "id":1,
    "project_id":1,
    "subscription":"bimonthly",
    "contract_type":"new",
    "contract_duration":"1 Year",
    "details":null,
    "status":"active",
    "equipment":[{"CH":"2","CT":"1","AHU":"1","ACU":"1"}],
    "free_tc":0,
    "start_date":"2024-09-20",
    "end_date":"2025-09-25",
    "renewal_date":null,
    "date_slots":
        [
            {
            "type":"BIMONTHLY",
            "data":
                {
                    "date_slot_01":"2024-09-25",
                    "date_slot_01_":"2024-09-25",
                    "date_slot_02":"2024-09-25",
                    "date_slot_02_":"2024-09-30",
                    "date_slot_03":null,
                    "date_slot_03_":null,
                    "date_slot_04":null,
                    "date_slot_04_":null,
                    "date_slot_05":null,
                    "date_slot_05_":null,
                    "date_slot_06":null,
                    "date_slot_06_":null,
                    "date_slot_07":null,
                    "date_slot_07_":null,
                    "date_slot_08":null,
                    "date_slot_08_":null,
                    "date_slot_09":null,
                    "date_slot_09_":null,
                    "date_slot_10":null,
                    "date_slot_10_":null,
                    "date_slot_11":null,
                    "date_slot_11_":null,
                    "date_slot_12":null,
                    "date_slot_12_":null
                }
            }
        ],
        "po_ref":null,
        "deleted_at":null,
        "created_at":"2024-09-25T06:06:26.000000Z",
        "updated_at":"2024-09-26T09:17:11.000000Z",
        "pm_project":
        {
            "id":1,
            "name":"TEST",
            "warranty":"Under Warranty",
            "address":"asda",
            "created_at":"2024-09-25T06:05:56.000000Z",
            "updated_at":"2024-09-25T06:05:56.000000Z"
        }
    }, --}}
