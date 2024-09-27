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
            @foreach ($slot['data'] as $key => $date)
                <td colspan="1">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
        @endif

        @if ($slot['type'] === 'MONTHLY')
            @foreach ($slot['data'] as $key => $date)
                <td colspan="2">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
        @endif

        @if ($slot['type'] === 'QUARTERLY')
            @foreach ($slot['data'] as $key => $date)
                <td colspan="3">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
        @endif

        @if ($slot['type'] === 'SEMI-ANNUAL')
            @foreach ($slot['data'] as $key => $date)
                <td colspan="6">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
        @endif

        @if ($slot['type'] === 'ANNUAL')
            @foreach ($slot['data'] as $key => $date)
                <td colspan="12">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
        @endif

        @if ($slot['type'] === 'CONTINUOUS')
            @foreach ($slot['data'] as $key => $date)
                <td colspan="2">
                    <abbr title="{{ $date ? 'Served: ' . $date : 'Not yet served.' }}">
                        <div class="{{ $date ? 'bg-blue-500' : 'bg-gray-300' }} h-5" style="width: 100%;"></div>
                    </abbr>
                </td>
            @endforeach
        @endif
    @endforeach
            </tr>
        </tbody>
    </table>
   

</div>
