

<div class="mb-10 min-h-min py-4">
    <div class="overflow-hidden rounded-lg">
        <div class="bg-gradient-to-br from-sky-600 to-sky-900 py-2 px-5">
            <p class="text-2xl text-white font-semibold uppercase mb-2">
                {{ $getRecord()->directoryproject->name }}
            </p>
            <span class="px-2 py-1 text-lg bg-red-600 text-white rounded-md">
                <strong>{{ $getRecord()->status }}</strong>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 p-6 gap-2 bg-white shadow-lg rounded-lg">
            @forelse($getRecord()->contactsdbe as $contact)
                <div class="text-gray-600 py-2 border-b border-gray-200">
                    <p>Contact Person:</p>
                    <span class="text-lg">
                        <strong>{{ $contact->contact_person }}</strong>
                    </span>
                </div>

                <div class="text-gray-600 py-2 border-b border-gray-200">
                    <p>Designation:</p>
                    <span class="text-lg">
                        <strong>{{ $contact->designation }}</strong>
                    </span>
                </div>

                <div class="text-gray-600 py-2 border-b-2 border-gray-400">
                    <p class="mb-1">Email:</p>
                    <span class="text-lg">
                        <strong>{{ $contact->email_address }}</strong>
                    </span>
                </div>

                <div class="text-gray-600 py-2 border-b-2 border-gray-400">
                    <p class="mb-1">Contact No.:</p>
                    <span class="text-lg">
                        <strong>{{ $contact->contact_no }}</strong>
                    </span>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-600 py-4">
                    <span>No Contact Details Available</span>
                </div>
            @endforelse
        </div>
    </div>
</div>



