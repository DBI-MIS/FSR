<div class="w-full">
    {{-- <x-filament::loading-indicator class="h-5 w-5" /> --}}
    
    <div class="max-w-full pb-4 px-6 mx-auto mb-20 min-h-screen">
        
        @php
            $sortedFsrs = $getRecord()->fsrs->sortByDesc(function ($fsr) {
                return $fsr->job_date_started;
            });

        @endphp

        
            <!-- Title and Description Section -->
            <div class="flex flex-col z-10 sticky top-0">
                <div id="sticky-div" class="w-full hidden" style="min-height: 60px">
                                
                </div>
                
                <div class="flex flex-col min-h-min bg-white py-4 px-4 border border-gray-300 rounded-lg w-full gap-4 relative">
                    
                        
                        <!-- Project Title -->
                        <div class="flex flex-col w-full items-start">
                            
                        <span class="text-sm text-gray-700">Project/Client:</span>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $getRecord()->name ?? '-' }}
                        </h2>
                        </div>
                        
                        <button data-tooltip-target="tooltip-default" onclick="scrollToTop()" class=" text-white rounded h-min absolute top-1 right-0 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" id="Arrow-Up-Large-2--Streamline-Sharp" height="20" width="20"><desc>Arrow Up Large 2 Streamline Icon: https://streamlinehq.com</desc><g id="arrow-up-large-2--move-up-arrow-arrows-large-head"><path id="Vector (Stroke)" fill="#2859c5" fill-rule="evenodd" d="m22.5 3.938 -21 0 0 -3 21 0 0 3Z" clip-rule="evenodd" stroke-width="1"></path><path id="Union" fill="#8fbffa" fill-rule="evenodd" d="m12 5.875 8.012 8.011v2.67h-5.508V23h-5v-6.443H3.989v-2.67l8.012 -8.012Z" clip-rule="evenodd" stroke-width="1"></path></g></svg>
                        </button>

                        <div class="flex flex-col md:flex-row justify-between">
                        

                        <div class="flex flex-row gap-2">
                            <p class="text-xs font-bold my-1 text-gray-900">
                                
                                @php
                                    $warrantyStatus = $getRecord()->warranty ?? '-';
                                    $badgeColor = 'bg-gray-400';
        
                                    if ($warrantyStatus === 'Under Warranty') {
                                        $badgeColor = 'bg-green-600 text-white';
                                    } elseif ($warrantyStatus === 'Out of Warranty') {
                                        $badgeColor = 'bg-red-600 text-white';
                                    } elseif ($warrantyStatus === 'In House') {
                                        $badgeColor = 'bg-blue-600 text-white';
                                    }
                                @endphp
        
                                <span class="px-2 py-1 rounded {{ $badgeColor }}">
                                    {{ $warrantyStatus }}
                                </span>
                            </p>
        
                        </div>
                        <!-- Search Bar -->
                        <div class="">
                            <input type="text" id="search" placeholder="Search by FSR No."
                                class="w-full p-1 border border-gray-300 rounded-md" oninput="filterFsrs()">
                        </div>
                   </div>
                   
                    
                   

                    <div>

                       

                        @php
                            use Carbon\Carbon;

                            $latestFsrsByQuarter = $sortedFsrs
                                ->groupBy(function ($fsr) {
                                    $date = $fsr->job_date_started ? Carbon::parse($fsr->job_date_started) : null;
                                    if ($date) {
                                        $year = $date->format('Y');
                                        $quarter = ceil($date->month / 3);
                                        return ' Q' . $quarter . $year;
                                    }
                                    return 'Unknown';
                                })
                                ->map(function ($fsrs) {
                                    return $fsrs
                                        ->sortByDesc(function ($fsr) {
                                            $date = $fsr->job_date_started
                                                ? Carbon::parse($fsr->job_date_started)
                                                : null;
                                            return $date ?: now();
                                        })
                                        ->first();
                                });
                        @endphp
                        @if ($latestFsrsByQuarter)


                        <details class="border-t px-2 pb-2 group hidden md:flex">
                            <summary
                                class="text-sm text-gray-700 mr-2 cursor-pointer flex justify-between items-center list-none ">

                                <span class="text-sm text-gray-700">
                                    Go to:
                                </span>

                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24"
                                        shape-rendering="geometricPrecision" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6">
                                        </path>

                                    </svg>
                                </span>
                            </summary>

                            <div class="min-h-max overflow-y-scroll hidden md:flex md:flex-row gap-2 md:flex-wrap">

                                @foreach ($latestFsrsByQuarter as $period => $fsr)
                                    @if ($fsr->id && $fsr->job_date_started)
                                        <div class="block items-center gap-1 text-nowrap">

                                            <a href="#fsr-{{ $fsr->id }}"
                                                class="text-gray-600 font-bold hover:text-blue-600 scroll-to-center">
                                                @if ($fsr->job_date_started)
                                                    {{ ' Q' . ceil(\Carbon\Carbon::parse($fsr->job_date_started)->month / 3) . '-' . \Carbon\Carbon::parse($fsr->job_date_started)->format('Y') }}
                                                    @if (!$loop->last)
                                                    |
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </a>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </details>

                        @endif


                    </div>
                
                </div>
            
            </div>

            <!-- Timeline Section -->
            <div class="pt-6  mx-auto" style="max-width: 800px; padding-left: 24px">
                <h1 class="text-2xl font-bold mb-10">Timeline View</h1>
                <ul class="relative border-l-4 border-sky-600" id="fsr-list">

                    @forelse ($sortedFsrs as $fsr)

                        <li id="fsr-{{ $fsr->id }}" class="mb-10 ml-6 fsr-item">
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

                                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                                        <span class="text-sm text-gray-700">FSR No.:</span>
                                        <div class="fsr-no text-xl text-gray-700 font-semibold"
                                            data-fsr-no="{{ $fsr->fsr_no }}">
                                            <a href="{{ route('filament.admin.resources.fsrs.view', ['record' => $fsr->id]) }}"
                                                wire:navigate>
                                                <span class="fsr-no-text">{{ $fsr->fsr_no }}</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="block text-lg font-normal leading-none text-slate-500">
                                        @if ($fsr->job_date_started)
                                            {{ \Carbon\Carbon::parse($fsr->job_date_started)->format('l - M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </div>

                                </div>
                                <hr>

                                <div class="flex flex-col">

                                    <details open class="bg-gray-100 px-4 py-2 rounded-md group ">
                                        <summary
                                            class="text-sm text-gray-700 mr-2 cursor-pointer flex justify-between items-center list-none ">

                                            <span>
                                                Attended To
                                            </span>

                                            <span
                                                class="transition-transform duration-300 ease-in-out group-open:rotate-180">
                                                <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                                    <path d="M6 9l6 6 6-6">
                                                    </path>

                                                </svg>
                                            </span>
                                        </summary>
                                        <div class="flex flex-wrap flex-row gap-1 mt-2">
                                            @if (is_array($fsr->attended_to))
                                                @foreach ($fsr->attended_to as $action)
                                                    <span
                                                        class="text-sm font-semibold text-center text-white inline-block bg-blue-600 rounded-md px-6 py-1 tracking-wide text-nowrap {{ $loop->last ? 'flex-none' : 'flex-1' }} ">
                                                        {{ $action ?? 'NA' }}
                                                    </span>
                                                    {{-- @if (!$loop->last)
                                                        @endif --}}
                                                @endforeach
                                            @else
                                                <span class="text-lg font-semibold text-gray-900 inline-block"></span>
                                            @endif
                                        </div>
                                    </details>

                                </div>

                                <div class="flex flex-col">
                                    @if ($fsr->concerns)
                                        <details class="bg-gray-100 px-4 py-2 rounded-md group">
                                            <summary
                                                class="text-sm text-gray-700 mr-2 cursor-pointer flex justify-between items-center list-none ">

                                                <span>
                                                    Concerns
                                                </span>

                                                <span class="transition group-open:rotate-180">
                                                    <svg fill="none" height="24"
                                                        shape-rendering="geometricPrecision" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                                        <path d="M6 9l6 6 6-6">
                                                        </path>

                                                    </svg>
                                                </span>
                                            </summary>

                                            <div class="flex gap-1 group-open:opacity-100 ">
                                                <span
                                                    class="text-sm font-light text-gray-900 inline-block px-4 py-2 rounded-md">
                                                    {{ $fsr->concerns ?? 'NA' }}
                                                </span>
                                            </div>
                                        </details>
                                    @else
                                        <span class="text-lg font-semibold text-gray-900 inline-block"></span>
                                    @endif

                                </div>

                                <div class="flex flex-col">
                                    @if ($fsr->service_rendered)
                                        <details class="bg-gray-100 px-4 py-2 rounded-md group">
                                            <summary
                                                class="text-sm text-gray-700 mr-2 cursor-pointer flex justify-between items-center list-none ">

                                                <span>
                                                    Service Rendered
                                                </span>

                                                <span class="transition group-open:rotate-180 open:rotate-180">
                                                    <svg fill="none" height="24"
                                                        shape-rendering="geometricPrecision" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                                        <path d="M6 9l6 6 6-6">
                                                        </path>

                                                    </svg>
                                                </span>
                                            </summary>

                                            <div class="flex gap-1 ">
                                                <span
                                                    class="text-sm font-light text-gray-900 inline-block  px-4 py-2 rounded-md">
                                                    {{ $fsr->service_rendered ?? 'NA' }}
                                                </span>
                                            </div>
                                        </details>
                                    @else
                                        <span class="text-lg font-semibold text-gray-900 inline-block"></span>
                                    @endif

                                </div>

                                <div class="flex flex-col">
                                    @if ($fsr->recommendation)
                                        <details class="bg-gray-100 px-4 py-2 rounded-md group">
                                            <summary
                                                class="text-sm text-gray-700 mr-2 cursor-pointer flex justify-between items-center list-none ">

                                                <span>
                                                    Recommendation
                                                </span>

                                                <span class="transition group-open:rotate-180 open:rotate-180">
                                                    <svg fill="none" height="24"
                                                        shape-rendering="geometricPrecision" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                                        <path d="M6 9l6 6 6-6">
                                                        </path>

                                                    </svg>
                                                </span>
                                            </summary>

                                            <div class="flex gap-1 ">
                                                <span
                                                    class="text-sm font-light text-gray-900 inline-block  px-4 py-2 rounded-md">
                                                    {{ $fsr->recommendation ?? 'NA' }}
                                                </span>
                                            </div>
                                        </details>
                                    @else
                                        <span class="text-lg font-semibold text-gray-900 inline-block"></span>
                                    @endif

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

<script>

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function filterFsrs() {
        let searchValue = document.getElementById('search').value.toLowerCase();
        let fsrItems = document.querySelectorAll('.fsr-item');
        let foundMatch = false;

        fsrItems.forEach(fsr => {
            let fsrNoElement = fsr.querySelector('.fsr-no-text');
            let fsrNo = fsrNoElement.textContent.toLowerCase();

            // Clear previous highlights
            fsrNoElement.innerHTML = fsrNoElement.textContent;

            if (fsrNo.includes(searchValue)) {
                let regex = new RegExp(`(${searchValue})`, 'gi');
                fsrNoElement.innerHTML = fsrNo.replace(regex, '<span class="bg-yellow-200">$1</span>');

                if (!foundMatch) {
                    // Scroll to the match and center it in the view
                    fsr.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    foundMatch = true;
                }
            }
        });
    }

    document.querySelectorAll('.scroll-to-center').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'center'
                });
            }
        });
    });

    const stickyDiv = document.getElementById('sticky-div');
window.addEventListener('scroll', () => {
    if (window.scrollY > 0) {
        stickyDiv.classList.remove('hidden'); // Remove the hidden class
        stickyDiv.classList.add('block'); // Add the block class to make it visible
    } else {
        stickyDiv.classList.remove('block'); // Remove the block class
        stickyDiv.classList.add('hidden'); // Add the hidden class to hide it again
    }
});
</script>
