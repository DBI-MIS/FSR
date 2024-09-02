@props(['status'])

<div class="w-[80%] mb-5 flex flex-col mx-auto bg-white rounded-lg px-2 py-2 shadow-gray-200 shadow-sm min-h-24">
    @include(static::$headerView)
    <div
        data-status-id="{{ $status['id'] }}"
        class="flex flex-wrap"
    >
        @foreach($status['records'] as $record)
            @include(static::$recordView)
        @endforeach

        
    </div>
</div>

