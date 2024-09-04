<x-filament-panels::page>
   <div>
    <div x-data wire:ignore.self class="flex flex-col gap-x-2 ">
        @foreach($statuses as $status)
            @include(static::$statusView)
        @endforeach

        <div wire:ignore>
            @include(static::$scriptsView)
        </div>
    </div>

    @unless($disableEditModal)
        <x-filament-kanban::edit-record-modal/>
    @endunless
</div>

</x-filament-panels::page>
