<div class="w-full">
    <table>
        <thead class="text-left">
            @foreach ($getRecord()->date_slots as $slot)
                <tr class="w-full">
                    @if ($slot['type'] === 'BIMONTHLY')
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">1</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">2</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">3</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">4</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">5</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">6</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">7</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">8</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">9</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">10</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">11</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">12</th>
                    @endif

                    @if ($slot['type'] === 'MONTHLY')
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">1</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">2</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">3</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">4</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">5</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">6</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">7</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">8</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">9</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">10</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">11</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">12</th>
                    @endif

                    @if ($slot['type'] === 'QUARTERLY')
                        <th colspan="3" style="width: 126px" class="text-center text-xs text-gray-400">1</th>
                        <th colspan="3" style="width: 126px" class="text-center text-xs text-gray-400">2</th>
                        <th colspan="3" style="width: 126px" class="text-center text-xs text-gray-400">3</th>
                        <th colspan="3" style="width: 126px" class="text-center text-xs text-gray-400">4</th>
                    @endif

                    @if ($slot['type'] === 'SEMI-ANNUAL')
                        <th colspan="6" style="width: 252px" class="text-center text-xs text-gray-400">1</th>
                        <th colspan="6" style="width: 252px" class="text-center text-xs text-gray-400">2</th>
                    @endif

                    @if ($slot['type'] === 'ANNUAL')
                        <th colspan="12" style="width: 504px" class="text-center text-xs text-gray-400">1</th>
                    @endif

                    @if ($slot['type'] === 'CONTINUOUS')
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">1</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">2</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">3</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">4</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">5</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">6</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">7</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">8</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">9</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">10</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">11</th>
                        <th colspan="2" style="width: 42px" class="text-center text-xs text-gray-400">12</th>
                    @endif

                </tr>

        </thead>
        <tbody>
            <tr class="odd:bg-gray-100 even:bg-white">

                @if ($slot['type'] === 'BIMONTHLY')
                    @foreach (range(1, 24) as $i)
                        <!-- Loop from 1 to 12 for the 12 slots -->
                        @php
                            $dateKey = 'date_slot_0' . $i; // Construct the date key
                            $noteKey = 'note_slot_0' . $i; // Construct the note key
                            $date = $slot['data'][$dateKey] ?? null; // Get the date value
                            $note = $slot['data'][$noteKey] ?? null; // Get the note value
                        @endphp

                        <td colspan="1">
                            <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                                <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;">
                                </div>
                            </abbr>
                            <abbr title="{{ $note ? 'Note: ' . $note : '' }}">
                                <div class="{{ $note ? 'bg-orange-500' : ($date ? 'bg-blue-500' : 'bg-gray-300') }} h-5"
                                    style="width: 100%;"></div>
                            </abbr>
                        </td>
                    @endforeach
                @endif



                {{-- @if ($slot['type'] === 'BIMONTHLY')
      
            @foreach ($slot['data'] as $key => $date)
                <td colspan="1">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                    </abbr>
                </td>
         
            @endforeach
          
        @endif --}}

                @if ($slot['type'] === 'MONTHLY')

                @foreach (range(1, 12) as $i)
                <!-- Loop from 1 to 12 for the 12 slots -->
                @php
                    $dateKey = 'date_slot_0' . $i; // Construct the date key
                    $noteKey = 'note_slot_0' . $i; // Construct the note key
                    $date = $slot['data'][$dateKey] ?? null; // Get the date value
                    $note = $slot['data'][$noteKey] ?? null; // Get the note value
                @endphp

                <td colspan="2">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;">
                        </div>
                    </abbr>
                    <abbr title="{{ $note ? 'Note: ' . $note : '' }}">
                        <div class="{{ $note ? 'bg-orange-500' : ($date ? 'bg-blue-500' : 'bg-gray-300') }} h-5"
                            style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
                   
                @endif

                @if ($slot['type'] === 'QUARTERLY')
                @foreach (range(1, 4) as $i)
                <!-- Loop from 1 to 12 for the 12 slots -->
                @php
                    $dateKey = 'date_slot_0' . $i; // Construct the date key
                    $noteKey = 'note_slot_0' . $i; // Construct the note key
                    $date = $slot['data'][$dateKey] ?? null; // Get the date value
                    $note = $slot['data'][$noteKey] ?? null; // Get the note value
                @endphp

                <td colspan="3">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;">
                        </div>
                    </abbr>
                    <abbr title="{{ $note ? 'Note: ' . $note : '' }}">
                        <div class="{{ $note ? 'bg-orange-500' : ($date ? 'bg-blue-500' : 'bg-gray-300') }} h-5"
                            style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
                @endif

                @if ($slot['type'] === 'SEMI-ANNUAL')
                @foreach (range(1, 2) as $i)
                <!-- Loop from 1 to 12 for the 12 slots -->
                @php
                    $dateKey = 'date_slot_0' . $i; // Construct the date key
                    $noteKey = 'note_slot_0' . $i; // Construct the note key
                    $date = $slot['data'][$dateKey] ?? null; // Get the date value
                    $note = $slot['data'][$noteKey] ?? null; // Get the note value
                @endphp

                <td colspan="6">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;">
                        </div>
                    </abbr>
                    <abbr title="{{ $note ? 'Note: ' . $note : '' }}">
                        <div class="{{ $note ? 'bg-orange-500' : ($date ? 'bg-blue-500' : 'bg-gray-300') }} h-5"
                            style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
                @endif

                @if ($slot['type'] === 'ANNUAL')
                @foreach (range(1, 1) as $i)
                <!-- Loop from 1 to 12 for the 12 slots -->
                @php
                    $dateKey = 'date_slot_0' . $i; // Construct the date key
                    $noteKey = 'note_slot_0' . $i; // Construct the note key
                    $date = $slot['data'][$dateKey] ?? null; // Get the date value
                    $note = $slot['data'][$noteKey] ?? null; // Get the note value
                @endphp

                <td colspan="12">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;">
                        </div>
                    </abbr>
                    <abbr title="{{ $note ? 'Note: ' . $note : '' }}">
                        <div class="{{ $note ? 'bg-orange-500' : ($date ? 'bg-blue-500' : 'bg-gray-300') }} h-5"
                            style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
                @endif

                @if ($slot['type'] === 'CONTINUOUS')
                @foreach (range(1, 12) as $i)
                <!-- Loop from 1 to 12 for the 12 slots -->
                @php
                    $dateKey = 'date_slot_0' . $i; // Construct the date key
                    $noteKey = 'note_slot_0' . $i; // Construct the note key
                    $date = $slot['data'][$dateKey] ?? null; // Get the date value
                    $note = $slot['data'][$noteKey] ?? null; // Get the note value
                @endphp

                <td colspan="2">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;">
                        </div>
                    </abbr>
                    <abbr title="{{ $note ? 'Note: ' . $note : '' }}">
                        <div class="{{ $note ? 'bg-orange-500' : ($date ? 'bg-blue-500' : 'bg-gray-300') }} h-5"
                            style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
                @endif
                @endforeach
            </tr>
        </tbody>
    </table>


</div>
