<div class="max-w-[1024px] mx-auto bg-white px-6 py-4 rounded-lg shadow-lg shadow-black/20">
    {{-- {{ $getChildComponentContainer() }} --}}
    <div class="h-auto sm:h-16 flex flex-row items-center justify-between my-4 gap-4">
        <img src="{{ asset('/DB_LOGO.png') }}" alt="" class="h-12 md:h-full">
        <div class="text-xl sm:text-2xl md:text-4xl font-black uppercase hidden sm:inline-block">Field Service Report
        </div>
        <div class="text-4xl font-black uppercase sm:hidden">FSR</div>
        <div class="min-w-max">
            <span>No.:</span>
            <span class="text-3xl font-black text-red-700">{{ $getRecord()->fsr_no ?? '-' }}</span>
        </div>
    </div>

    <hr>

    <div class="flex flex-col lg:flex-row gap-4">
        <div class="w-full lg:w-3/4">

            <div class="flex flex-col my-2">

                <div class="flex flex-col sm:flex-row justify-between">
                    <div class="inline-block gap-6 order-2 sm:order-1">
                        <span class="text-sm uppercase">Client:</span>
                        <span class="text-base font-bold">{{ $getRecord()->project->name ?? '-' }}</span>
                    </div>
                    <div class="inline-block gap-6 order-1 sm:order-2">
                        <span class="text-sm uppercase">Date:</span>
                        <span class="text-base font-bold">
                            @if ($getRecord()->job_date_started)
                                {{ \Carbon\Carbon::parse($getRecord()->job_date_started)->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Address:</span>
                    <span class="text-base font-bold">{{ $getRecord()->project->address ?? '-' }}</span>
                </div>
                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Status:</span>
                    <span class="text-base font-bold">{{ $getRecord()->project->warranty ?? '-' }}</span>
                </div>

                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Attended to:</span>
                    @if (is_array($getRecord()->attended_to) || is_object($getRecord()->attended_to))
                        @forelse($getRecord()->attended_to as $attended)
                            <span class="text-base font-bold">
                                {{-- {{ is_string($attended) ? 'NA' : ($attended ?? 'NA') }} --}}
                                {{ $attended ?? 'NA' }}
                            </span>
                            @if (!$loop->last)
                                ,
                            @endif
                        @empty
                            <span class="text-base font-bold">NA</span>
                        @endforelse
                    @else
                        <span class="text-base font-bold">NA</span>
                    @endif
                </div>


                <div class="inline-block gap-6  min-h-20">
                    <span class="text-sm uppercase">Concerns:</span>
                    <span class="text-base font-bold">{{ $getRecord()->concerns ?? '-' }}</span>
                </div>

            </div>

            <hr>

            <div class="flex flex-col my-2 min-h-24">
                <span class="uppercase">Equipment And Compressor Details:</span>
                <div class="flex gap-6 justify-between mx-4">

                    <table class="hidden md:table w-full">
                        <tr>
                            <td>
                                <span class="text-sm uppercase">Item</span>
                            </td>
                            <td>
                                <span class="text-sm uppercase">Brand/Model/Description/Designation/Type</span>
                            </td>
                            <td>
                                <span class="text-sm uppercase">Serial Nos.</span>
                            </td>
                            <td>
                                <span class="text-sm uppercase">Qty</span>
                            </td>
                        </tr>

                        <tbody>
                            @forelse($getRecord()->equipments as $index => $equipment)
                                <tr>
                                    <td>
                                        <span class="text-base font-bold">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">
                                            {{ $equipment->brand }}
                                        </span>
                                        <span class="text-base font-bold">
                                            {{ $equipment->model }}
                                        </span>
                                        <span class="text-base font-bold">
                                            {{ $equipment->description }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">{{ $equipment->serial }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-base font-bold">1</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                    <div class="flex md:hidden flex-col w-full">
                        @forelse($getRecord()->equipments as $index => $equipment)
                            <div class="p-3 grid grid-cols-1 sm:grid-cols-2 grid-flow-row">

                                <div class="sm:col-span-2">
                                    <span class="text-sm uppercase">Item No.: </span>
                                    <span class="text-base font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm uppercase">Brand: </span><br>
                                    <span class="text-base font-bold">
                                        {{ $equipment->brand ?? 'NA' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm uppercase">Model: </span><br>
                                    <span class="text-base font-bold">
                                        {{ $equipment->model ?? 'NA' }}
                                    </span>
                                </div>


                                <div>
                                    <span class="text-sm uppercase">Description: </span><br>
                                    <span class="text-base font-bold">
                                        {{ $equipment->description ?? 'NA' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm uppercase">Serial Nos.: </span><br>
                                    <span class="text-base font-bold">
                                        {{ $equipment->serial ?? 'NA' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm uppercase">Qty: </span>
                                    <span class="text-base font-bold">
                                        1
                                    </span>
                                </div>



                            </div>
                            <hr>

                        @empty
                            <div>
                                <span class="text-base font-bold">-</span>
                            </div>
                        @endforelse


                    </div>
                </div>

            </div>

            <hr>

            <div class="grid grid-cols-1 sm:grid-cols-2 my-2">

                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Actual Voltage(V):</span>
                    <span class="text-base font-bold">{{ $getRecord()->actual_voltage_v1 ?? '-' }}</span>
                    <span class="text-base font-bold">{{ $getRecord()->actual_voltage_v2 ?? '-' }}</span>
                    <span class="text-base font-bold">{{ $getRecord()->actual_voltage_v3 ?? '-' }}</span>
                </div>

                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Voltage Imbalance(%):</span>
                    <span class="text-base font-bold">{{ $getRecord()->voltage_imbalance ?? '-' }}</span>
                </div>

                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Amperage(A):</span>
                    <span class="text-base font-bold">{{ $getRecord()->actual_amperage_v1 ?? '-' }}</span>
                    <span class="text-base font-bold">{{ $getRecord()->actual_amperage_v2 ?? '-' }}</span>
                    <span class="text-base font-bold">{{ $getRecord()->actual_amperage_v3 ?? '-' }}</span>
                </div>

                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Currrent Imbalance(%):</span>
                    <span class="text-base font-bold">{{ $getRecord()->voltage_imbalance ?? '-' }}</span>
                </div>

                <div class="inline-block gap-6">
                    <!----blank--->
                </div>

                <div class="inline-block gap-6">
                    <span class="text-sm uppercase">Control Voltage(V):</span>
                    <span class="text-base font-bold">{{ $getRecord()->control_voltage ?? '-' }}</span>
                </div>

            </div>

            <hr>

            <div class="inline-block gap-6 my-2 min-h-40">
                <span class="text-sm uppercase">Services Rendered:</span>
                <br>
                <span class="text-base font-bold">{{ $getRecord()->service_rendered ?? '-' }}</span>
            </div>

            <hr>

            <div class="flex flex-col my-2">
                <div class="inline-block">
                    <span class="text-sm uppercase">For:</span>
                    <span class="text-base font-bold">{{ $getRecord()->reading_for ?? '-' }}</span>
                </div>

                <div class="inline-block">
                    <span class="text-sm uppercase">Refrigerant Type:</span>
                    <span class="text-base font-bold">{{ $getRecord()->refrigerant_type ?? '-' }}</span>
                </div>
            </div>

            <table class="hidden md:table w-full mx-4">
                <tr class="text-left">
                    <th>
                        <span class="text-sm uppercase">Log Readings: UNIT</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">1</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">2</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">3</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">4</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase"> </span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">1</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">2</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">3</span>
                    </th>
                    <th>
                        <span class="text-sm uppercase">4</span>
                    </th>
                </tr>
                <tbody>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <span class="text-base">Suction Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Suction Pressure</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure4 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base">Discharge Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Discharge Pressure</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure4 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base">Liquid Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Oil Pressure</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure4 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base">Oil Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <span class="text-base">Discharge Superheat</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat4 ?? '-' }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="md:hidden w-full">
                <tr class="text-left">
                    <th>
                        <span class="text-sm uppercase">Log Readings: UNIT</span>
                    </th>
                    <td>
                        <span class="text-sm uppercase">1</span>
                    </td>
                    <td>
                        <span class="text-sm uppercase">2</span>
                    </td>
                    <td>
                        <span class="text-sm uppercase">3</span>
                    </td>
                    <td>
                        <span class="text-sm uppercase">4</span>
                    </td>
                </tr>
                <tbody>
                    <tr>
                        <td>
                            <span class="text-base">Suction Pressure</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_pressure4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Suction Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->suction_temp4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Discharge Pressure</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_pressure4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Discharge Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_temp4 ?? '-' }}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="text-base">Liquid Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->liquid_temp4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Oil Pressure</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_pressure4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Oil Temp.</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->oil_temp4 ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Discharge Superheat</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat1 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat2 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat3 ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->discharge_superheat4 ?? '-' }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="inline-block">
                <span class="text-base md:mx-4 mx-1">Compressor Type:</span>
                <span class="text-base font-bold">{{ $getRecord()->compressor_type ?? '-' }}</span>
            </div>

            <hr>

            <table class="w-full mx-4 my-2">
                <tbody>
                    <tr class="text-left">
                        <td>
                            <span class="text-sm uppercase font-bold">Water Cooled Chiller</span>
                        </td>
                        <td>
                            <span class="text-sm hidden md:inline-table"></span>
                        </td>
                        <td>
                            <span class="text-sm ">Cooler Temperature (In/Out)</span>
                        </td>
                        <td>
                            <span class="text-sm ">Condenser Temperature (In/Out)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Temperature</span>
                        </td>
                        <td>
                            <span class="text-xs hidden md:inline-table">(Water In / Water Out)</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->wcc_cooler_temp ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->wcc_condenser_temp ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>
                            <span class="text-sm uppercase font-bold">Air Cooled Chiller</span>
                        </td>
                        <td>
                            <span class="text-sm hidden md:inline-table"></span>
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Temperature</span>
                        </td>
                        <td>
                            <span class="text-xs hidden md:inline-table">(Water In / Water Out)</span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->acc_cooler_temp ?? '-' }}</span>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Ambient Temperature</span>
                        </td>
                        <td>
                            <span class="text-sm hidden md:inline-table"></span>
                        </td>
                        <td>
                            <span class="text-base font-bold">{{ $getRecord()->acc_ambient_temp ?? '-' }}</span>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Pressure</span>
                        </td>
                        <td>
                            <span class="text-xs hidden md:inline-table">(Water In)</span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->pressure_cooler_water_in ?? '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->pressure_condenser_water_in ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <span class="text-xs hidden md:inline-table">(Water Out)</span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->pressure_cooler_water_out ?? '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->pressure_condenser_water_out ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Water Pressure Drop</span>
                        </td>
                        <td>
                            <span class="text-sm hidden md:inline-table"></span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->water_pressure_drop_cooler ?? '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->water_pressure_drop_condenser ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Approach - Condenser</span>
                        </td>
                        <td>
                            <span class="text-sm hidden md:inline-table"></span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->approach_condenser_cooler_temp ?? '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->approach_condenser_condenser_temp ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-base">Approach - Evaporator</span>
                        </td>
                        <td>
                            <span class="text-sm hidden md:inline-table"></span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->approach_evaporator_cooler_temp ?? '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-base font-bold">{{ $getRecord()->approach_evaporator_condenser_temp ?? '-' }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <hr>

            <div class="flex flex-col my-2 min-h-24">
                <div class="flex gap-6 justify-between">
                    <table class="hidden md:table w-full text-left mx-4">

                        <tr>
                            <td>
                                <span class="text-sm uppercase">qty</span>
                            </td>
                            <td>
                                <span class="text-sm uppercase">Part Description To Be Replace</span>
                            </td>
                            <td>
                                <span class="text-sm uppercase">Parts No.</span>
                            </td>
                        </tr>
                        <tbody>
                            @forelse($getRecord()->replacements as $replacement)
                                <tr>
                                    <td>
                                        <span class="text-base font-bold">{{ $replacement->part_quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">{{ $replacement->brand }}</span>
                                        <span class="text-base font-bold">{{ $replacement->model }}</span>
                                        <span class="text-base font-bold">{{ $replacement->part_description }}</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">{{ $replacement->part_no }}</span>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                    <td>
                                        <span class="text-base font-bold">-</span>
                                    </td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>

                <div class="flex md:hidden flex-col w-full">
                    <span class="text-sm uppercase">Part/s Description To Be Replace</span>
                    @forelse($getRecord()->replacements as $replacement)
                        <div class="p-3 grid grid-cols-1 sm:grid-cols-2 grid-flow-row">

                            <div class="sm:col-span-2">
                                <span class="text-sm uppercase">Qty.: </span>
                                <span class="text-base font-bold">
                                    {{ $replacement->part_quantity ?? 'NA' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm uppercase">Brand: </span><br>
                                <span class="text-base font-bold">
                                    {{ $replacement->brand ?? 'NA' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm uppercase">Model: </span><br>
                                <span class="text-base font-bold">
                                    {{ $replacement->model ?? 'NA' }}
                                </span>
                            </div>


                            <div>
                                <span class="text-sm uppercase">Description: </span><br>
                                <span class="text-base font-bold">
                                    {{ $replacement->part_description ?? 'NA' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm uppercase">Parts No.: </span><br>
                                <span class="text-base font-bold">
                                    {{ $equipment->part_no ?? 'NA' }}
                                </span>
                            </div>



                        </div>
                        <hr>

                    @empty
                        <div>
                            <span class="text-base font-bold">-</span>
                        </div>
                    @endforelse


                </div>

            </div>

            <hr>

            <div class="inline-block gap-6 my-2 min-h-40">
                <span class="text-sm uppercase">Reccomendations/Existing Condition/For Customer Urgent Action:</span>
                <br>
                <span class="text-base font-bold">{{ $getRecord()->recommendation ?? '-' }}</span>
            </div>
            <hr>
        </div>

        <div class="w-full lg:w-1/4 ">
            <div class="border px-3">
                <div class="flex flex-col max-h-min flex-wrap">
                    <div class="inline-block gap-6 my-2 min-h-40">
                        <span class="text-xs uppercase font-bold">DB Service Personnel Attendee:</span>
                        <br>
                        @if ($personnels = $getRecord()->personnels)
                            @foreach ($personnels as $personnel)

                            <div class="flex flex-row gap-2 items-center">
                                <img 
                                class="w-8 h-8 rounded-full border border-blue-500"
                                src="{{ $personnel->profile_photo_path ? asset('storage/' . $personnel->profile_photo_path) : asset('/user_profile.svg') }}" 
                                alt="{{ $personnel->name }}">
                                <span class="text-base font-bold text-nowrap">{{ $personnel->getprofile() ?? 'N/A' }}@if(!$loop->last),
                                    @endif</span>
                                
                            </div>
                               
                            @endforeach
                        @else
                            <span class="text-base font-bold">NA</span>
                        @endif
                    </div>
                    <div class="inline-block">
                        <span class="text-xs uppercase">Time Arrived:</span>
                        <span class="text-base font-bold">
                        @if ($getRecord()->time_arrived)
                            {{ \Carbon\Carbon::parse($getRecord()->time_arrived)->format('h:i A') }}
                        @else
                            N/A
                        @endif
                        </span>
                    </div>
                    <div class="inline-block">
                        <span class="text-xs uppercase">Date Completed:</span>
                        <span class="text-base font-bold">
                          @if ($getRecord()->job_date_finished)
                            {{ \Carbon\Carbon::parse($getRecord()->job_date_finished)->format('M d, Y') }}
                            @else
                            N/A
                        @endif
                        </span>
                    </div>
                    <div class="inline-block">
                        <span class="text-xs uppercase">Time Completed:</span>
                        <span class="text-base font-bold">
                          @if ($getRecord()->time_completed)
                            {{ \Carbon\Carbon::parse($getRecord()->time_completed)->format('h:i A') }}
                            @else
                            N/A
                        @endif
                        </span>
                    </div>
                    <hr>

                    @php
                        function getSatisfactionText($rate)
                        {
                            switch ($rate) {
                                case 1:
                                    return '1 - Dissatisfied';
                                case 2:
                                    return '2 - Somewhat Dissatisfied';
                                case 3:
                                    return '3 - Acceptable';
                                case 4:
                                    return '4 - Very Satisfied';
                                case 5:
                                    return '5 - Excellent';
                                default:
                                    return '-';
                            }
                        }
                    @endphp

                    <div class="inline-block my-2 min-h-40">
                        <span class="text-xs">1) How satisfied were you with our respond time for equipment breakdown
                            when complain lodged? </span>
                        <br>
                        <div class="border-2 text-center">
                            <span
                                class="text-base font-bold">{{ getSatisfactionText($getRecord()->response_time_rate ?? null) }}</span>

                        </div>
                        <span class="text-xs">Comments:</span>
                        <br>
                        <span class="text-base font-bold">{{ $getRecord()->response_time ?? '-' }}</span>
                    </div>
                    <hr>
                    <div class="inline-block my-2 min-h-40">
                        <span class="text-xs">2) How satisfied were you with our service experience and work
                            attitude?</span>
                        <br>
                        <div class="border-2 text-center">
                            <span
                                class="text-base font-bold">{{ getSatisfactionText($getRecord()->service_time_rate ?? null) }}</span>
                        </div>
                        <span class="text-xs">Comments:</span>
                        <br>
                        <span class="text-base font-bold">{{ $getRecord()->service_time ?? '-' }}</span>
                    </div>
                    <hr>
                    <div class="inline-block my-2 min-h-40">
                        <span class="text-xs">3) How satisfied were you with how the support staff resolved your most
                            recent problem?</span>
                        <br>
                        <div class="border-2 text-center">
                            <span
                                class="text-base font-bold">{{ getSatisfactionText($getRecord()->resolution_time_rate ?? null) }}</span>
                        </div>
                        <span class="text-xs">Comments:</span>
                        <br>
                        <span class="text-base font-bold">{{ $getRecord()->resolution_time ?? '-' }}</span>
                    </div>
                    <hr>
                    <div class="inline-block my-2 min-h-40">
                        <span class="text-xs">Do you have any suggestions for us to provide better service to
                            you?</span>
                        <br>
                        <span class="text-base font-bold">{{ $getRecord()->suggestions ?? '-' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr>

    <div class=" text-right px-4">
        <span class="text-xs">Encoded By:</span>

        <span class="text-base font-bold">{{ $getRecord()->author->name }}</span>


    </div>

</div>
