<div class="min-h-min">

    <div class="overflow-hidden rounded-lg w-full relative">


        <details open
            class="bg-gradient-to-br from-sky-600 to-sky-900 px-3 flex flex-col md:flex-row justify-between md:items-center w-full py-2 group relative">
            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">

                <x-filament::loading-indicator class="h-10 w-10 mx-auto z-50" />

            </div>

            <summary
                class="text-sm text-gray-700 mr-2 cursor-pointer flex flex-row justify-between items-center list-none ">

                <div class="flex flex-col w-full">
                    <p class="text-sm text-white  opacity-1">

                        Project:
                    </p>
                    <p class="text-white text-xl"> <strong>{{ $getRecord()->name ?? '-' }}</strong>
                    </p>
                </div>



                <span class="transition group-open:rotate-180 text-white">
                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"
                        width="24">
                        <path d="M6 9l6 6 6-6">
                        </path>

                    </svg>
                </span>






            </summary>

            <div class="flex gap-1 group-open:opacity-100 overflow-hidden rounded-md">
                <div class="flex flex-col items-start py-2">



                    <span
                        class="px-1 text-xs font-bold
                        @if ($getRecord()->warranty === 'Under Warranty') bg-green-600
                        @elseif ($getRecord()->warranty === 'Out of Warranty') bg-red-600
                        @elseif ($getRecord()->warranty === 'In House') bg-blue-600
                        @else bg-gray-400 @endif text-white rounded-full">
                        <strong>{{ $getRecord()->warranty ?? '-' }}</strong>
                    </span>


                    <span class="text-white py-2 text-sm">
                        {{ $getRecord()->address ?? 'No Address' }}
                    </span>
                    <span class="text-white py-2 text-sm">
                        ID: {{ $getRecord()->id }}
                    </span>


                </div>

            </div>
        </details>


    </div>
</div>
