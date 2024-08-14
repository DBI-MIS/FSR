<div class="mx-20">
    @php
        $sortedFsrs = $getRecord()->fsrs->sortByDesc(function ($fsr) {
            return $fsr->job_date_started;
        });
    @endphp

    <div class="max-w-[90%] p-12 bg-white rounded-lg shadow-lg shadow-black/20 mx-auto mb-20">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-20">
            <!-- Title and Description Section -->
            <div class="col-span-2">
                <div class="fixed bg-white z-20 p-4 min-h-min">
                    <span class="text-sm text-gray-700">Project/Client:</span>
                    <h2 class="text-4xl font-bold mb-5 text-gray-900 dark:text-white">{{ $getRecord()->name ?? '-' }}
                    </h2>

                    <span class="text-sm text-gray-700">Address:</span>
                    <p class="text-xl font-bold mb-5 text-gray-900">{{ $getRecord()->address ?? '-' }}</p>

                    <span class="text-sm text-gray-700">Status:</span>
                    <p class="text-base font-bold mb-5 mt-1 text-gray-900">
                        {{-- based sa project table --}}
                        @php
                            $warrantyStatus = $getRecord()->warranty ?? '-';
                            $badgeColor = 'bg-gray-400';

                            if ($warrantyStatus === 'Under Warranty') {
                                $badgeColor = 'bg-green-400 text-white';
                            } elseif ($warrantyStatus === 'Out of Warranty') {
                                $badgeColor = 'bg-red-400 text-white';
                            } elseif ($warrantyStatus === 'In House') {
                                $badgeColor = 'bg-blue-400 text-white';
                            }
                        @endphp

                        <span class="px-2 py-1 rounded {{ $badgeColor }}">
                            {{ $warrantyStatus }}
                        </span>
                    </p>
                    <div>
                        @php
                            $latestFsrsByYear = $sortedFsrs
                                ->groupBy(function ($fsr) {
                                    return $fsr->job_date_started->format('Y');
                                })
                                ->map(function ($fsrs) {
                                    return $fsrs->sortByDesc('job_date_started')->first();
                                });
                        @endphp

                        <h3 class="text-xl font-bold mt-10">Select Year</h3>
                        <ul>
                            @foreach ($latestFsrsByYear as $year => $fsr)
                                <li>
                                    <a href="#fsr-{{ $fsr->id }}" class="text-blue-600 hover:underline">
                                        {{ $fsr->job_date_started->format('Y') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Timeline Section -->
            <div class="col-span-3 min-h-[500px]">
                <h1 class="text-2xl font-bold mb-10">FSR Timeline View</h1>
                <ul class="relative border-l-4 border-sky-600">



                    @forelse ($sortedFsrs as $fsr)

                        <li id="fsr-{{ $fsr->id }}" class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-sky-600 rounded-full -left-3.5 ring-8 ring-white dark:ring-gray-900">
                                <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.707a1 1 0 00-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <div class="flex flex-col gap-2">

                                <div class="block text-lg font-normal leading-none text-slate-500">
                                    {{ $fsr->job_date_started->format('l - M d, Y') ?? '-' }}</div>
                                <hr>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-700">FSR No.:</span>
                                    <span class="text-lg text-gray-700 font-semibold">{{ $fsr->fsr_no }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-700 mr-2">Attended To:</span>
                                    <div class="flex gap-1">
                                        @if (is_array($fsr->attended_to) || is_object($fsr->attended_to))
                                            @foreach ($fsr->attended_to as $action)
                                                <span class="text-lg font-semibold text-gray-900 inline-block">
                                                    {{ is_string($action) ? 'NA' : $action ?? 'NA' }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-lg font-semibold text-gray-900 inline-block">NA</span>
                                        @endif
                                    </div>
                                </div>
                            </div>




                        </li>
                        @empty
                            <li class="ml-6 text-sm text-gray-500 dark:text-gray-400">No records found.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>



    </div>
