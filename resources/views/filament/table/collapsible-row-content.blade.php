<div class="flex flex-col gap-4">
    <div class="">
        <span class="font-light text-xs">
            Service Rendered:
        </span>
        <br>

        <div class="bg-gradient-to-tr from-yellow-50 to-white rounded-lg p-3">
            <span class="text-base font-light ">
                {{ $getRecord()->service_rendered }}
            </span>
        </div>
    </div>

    <div class="">
        <span class="font-light text-xs">
            Concerns:
        </span>
        <br>
        <div class="bg-gradient-to-tr from-yellow-50 to-white rounded-lg p-3">
        <span class="text-base font-bold">
            {{ $getRecord()->concerns }}
        </span>
        </div>
    </div>

    <div class="">
        <span class="font-light text-xs">
            Recommendation:
        </span>
        <br>
        <div class="bg-gradient-to-tr from-yellow-50 to-white rounded-lg p-3">
        <span class="text-base font-bold">
            {{ $getRecord()->recommendation }}
        </span>
        </div>
    </div>

</div>
