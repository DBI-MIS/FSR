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
        'flex flex-row flex-wrap items-center',
        'ml-0' =>
            $loop->first &&
            ($record->status === 'waiting' || $record->status === 'in_office'),
        '-ml-4' =>
            !$loop->first &&
            ($record->status === 'waiting' || $record->status === 'in_office'),
        'min-w-[280px] bg-gray-200 rounded-md shadow-sm shadow-gray-200 px-2 my-1 mx-2' => $record->status === 'on_site',
    ])>
        <span>
            @if ($record->profile_photo_path)
                <img src="{{ $record->profile_photo_path }}" alt="" class="w-12 h-12 rounded-full object-cover">
            @else
                <div
                    class="w-12 h-12 bg-blue-600 text-white flex items-center justify-center rounded-full text-lg font-bold border-2 border-white">
                    {{ strtoupper(substr($record->name, 0, 1)) }}
                </div>
            @endif
        </span>


        <div class="flex flex-col ml-2">
            <span @class([
                'mr-6 group-hover:block',
                'hidden ' =>
                    $record->status === 'waiting' || $record->status === 'in_office',
                'flex ' => $record->status === 'on_site',
            ])>
                {{ $record->{static::$recordTitleAttribute} }}
            </span>
            @if ($record->status === 'on_site')
                <span class="text-xs">{{ $record->status_location }}</span>
            @endif
        </div>

    </div>


</div>


