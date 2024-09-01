<div id="{{ $record->getKey() }}" wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
    class="record cursor-grab font-medium text-gray-600 dark:text-gray-200 min-w-min group"
    @if ($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3) x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'dark:bg-primary-800')
            $el.classList.remove('dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('dark:bg-primary-800')
                $el.classList.add('dark:bg-gray-700')
            }, 3000)
        " @endif>

    <div @class([
        'flex flex-row flex-wrap items-center space-y-2',
        'ml-0' =>
            $loop->first &&
            ($record->status === 'waiting' || $record->status === 'in_office'),
        '-ml-4' =>
            !$loop->first &&
            ($record->status === 'waiting' || $record->status === 'in_office'),
        'ml-1 w-[200px]' => $record->status === 'on_site',
    ])>
        <span>
            @if ($record->profile_photo_path)
                <img src="{{ $record->profile_photo_path }}" alt="" class="w-12 h-12 rounded-full object-cover">
            @else
                <div
                    class="w-12 h-12 bg-gray-400 text-white flex items-center justify-center rounded-full text-lg font-bold border-2 border-white">
                    {{ strtoupper(substr($record->name, 0, 1)) }}
                </div>
            @endif
        </span>


        <div class="flex flex-col gap-1 py-2">
            <span @class([
                'mr-6 group-hover:block',
                'hidden ' =>
                    $record->status === 'waiting' || $record->status === 'in_office',
                'block px-2  ' => $record->status === 'on_site',
            ])>
                {{ $record->{static::$recordTitleAttribute} }}
            </span>
            {{-- <span class="text-xs">{{ $record->{static::$recordDescriptionAttribute} }}</span> --}}
            {{-- <span class="text-xs">{{ $record->status_location }}</span> --}}
            @if ($record->status === 'on_site')
                <span class="text-xs px-2">{{ $record->status_location }}</span>
            @endif
        </div>

    </div>


</div>
