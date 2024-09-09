
<div class="container mx-auto py-8">
    <div class="mb-10 min-h-min bg-white py-4 px-4 border border-gray-300 rounded-lg w-full">
        <div class="flex flex-col w-full items-start pt-2 pb-6">
            <span class="text-sm text-gray-700">Project/Client:</span>
            <h2 class="text-3xl font-bold text-gray-600 dark:text-white">{{ $record->name ?? '-' }}</h2>
        </div>
    

    <div>
        <span class="text-sm text-gray-700">Equipments:</span>
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mt-2">
            @forelse ($uniqueEquipments as $equipment)
            <div class="bg-white border border-gray-200 rounded-lg bg-no-repeat bg-cover bg-right-bottom"
                style="background-image: url({{ asset('/FSR_BG.png') }})">
                <div class="overflow-hidden rounded-t-lg">
                    <div class="bg-gradient-to-br from-sky-600 to-sky-900 px-2 text-right py-1">
                        <p class="text-white text-xs">ID:{{ $equipment->id ?? null }}</p>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-gray-600">Brand: <strong>{{ $equipment->brand ?? null }}</strong></p>
                    <p class="text-gray-600">Model: <strong>{{ $equipment->model ?? null }}</strong></p>
                    <p class="text-gray-600">Serial No: <strong>{{ $equipment->serial ?? null }}</strong></p>
                    <p class="text-gray-600">Description: <strong>{{ $equipment->description ?? null }}</strong></p>
                </div>
            </div>
            @empty
            <p class="text-gray-600">No equipment found.</p>
            @endforelse
        </div>

    </div>
</div>

</div>
