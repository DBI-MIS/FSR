<x-filament-widgets::widget>
    <x-filament::section>
        <table class="w-full">
            <thead>
                @forelse ($services as $service)
                    <tr>
                        <th>Project/Client</th>
                        <th>PM Freq</th>
                        <th>Free TC</th>
                        <th>Contract Period</th>
                        <th>Service</th>

                    </tr>
            </thead>
            <tbody>

                <tr>
                    <td>{{ $service->pm_project->name }}</td>
                    <td>{{ $service->subscription }}</td>
                    <td>{{ $service->free_tc }}</td>
                    <td>{{ $service->start_date }} to {{ $service->end_date }}</td>

                    @foreach ($service->date_slots as $slot)
    
    

        <!-- Loop through the date slots and display the dates -->
        @foreach ($slot['data'] as $key => $date)
              @if (!is_null($date))
                <td>{{ $key }}: {{ $date }}</td>
            @endif
        @endforeach
    
@endforeach

                </tr>
            @empty
                <tr>
                    <td colspan="1">Empty</td> <!-- Display when there are no services -->
                </tr>
                @endforelse
            </tbody>
        </table>
        {{-- {{ $services }} <!-- You can also output the raw collection here if needed --> --}}
    </x-filament::section>
</x-filament-widgets::widget>
