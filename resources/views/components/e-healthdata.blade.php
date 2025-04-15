@props(['pet'])

{{-- Health Records --}}
<div class="w-full mt-4 p-4 bg-white dark:bg-gray-900 rounded-lg shadow-md">
    <div id="toggle-health" class="text-lg font-semibold text-center cursor-pointer flex justify-between items-center">
        Health Records
        <i id="health-icon" class="fa-solid fa-chevron-down ml-2"></i>
    </div>
    <div id="health-list" class="mt-4 hidden">
        @if($pet->prescriptions->isEmpty())
        <p class="text-sm text-gray-400 text-center">No health records available.</p>
        @else
        @php
        // Separate the latest health record
        $latestRecord = $pet->prescriptions->sortByDesc('record_date')->first();
        $remainingRecords = $pet->prescriptions->where('id', '!=', $latestRecord->id)->sortBy('record_date');
        $healthRecords = collect([$latestRecord])->merge($remainingRecords);
        @endphp

        <ol class="relative border-l border-gray-700">
            @foreach($healthRecords as $index => $prescription)
            <li class="mb-4 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -left-3 text-white ring-8 ring-white dark:ring-gray-900 bg-secondary-dark dark:bg-secondary-light">
                    <i class="fa-solid fa-file-prescription fa-rotate-by" style="--fa-rotate-angle: -30deg;"></i>
                </span>
                <div class="p-2 rounded-lg shadow">
                    <h3 class="mb-1 text-lg font-semibold flex items-center justify-between">
                        {{ $prescription->tx_given }}
                        @if($index === 0)
                        <span class="ml-2 bg-red-500 text-xs px-2 py-1 text-white rounded">Latest</span>
                        @endif
                    </h3>
                    <time class="block mb-2 text-sm font-normal text-gray-400">
                        <strong>Administered: </strong>{{ \Carbon\Carbon::parse($prescription->record_date)->format('F d, Y') }}
                    </time>
                    <p class="text-sm text-gray-400 break-all">
                        <strong>Description:</strong> {{ $prescription->description ?? 'No description available' }}
                    </p>
                    <p class="text-sm text-gray-400"><strong>Attending Vet: </strong>Dr. {{ optional($prescription->veterinarian)->Fname ?? 'Unknown' }} {{ optional($prescription->veterinarian)->Lname ?? '' }}</p>
                </div>
            </li>
            @endforeach
        </ol>
        @endif
    </div>
</div>

{{-- Vaccination Records --}}
<div class="w-full mt-4 p-4 bg-white dark:bg-gray-900 rounded-lg shadow-md">
    <div id="toggle-vaccine" class="text-lg font-semibold text-center cursor-pointer flex justify-between items-center">
        Vaccination Records
        <i id="vaccine-icon" class="fa-solid fa-chevron-down ml-2"></i>
    </div>
    <div id="vaccination-list" class="mt-4 hidden">
        @if($pet->vaccinations->isEmpty())
        <p class="text-sm text-gray-400 text-center">No vaccinations recorded.</p>
        @else
        @php
        // Separate the latest vaccination (most recent one)
        $latestVaccine = $pet->vaccinations->sortByDesc('date_administered')->first();
        $remainingVaccines = $pet->vaccinations->where('id', '!=', $latestVaccine->id)->sortBy('date_administered');
        $vaccines = collect([$latestVaccine])->merge($remainingVaccines);
        @endphp

        <ol class="relative border-l border-gray-700">
            @foreach($vaccines as $index => $vaccine)
            <li class="mb-4 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-gray-900 dark:bg-blue-900">
                    <i class="fa-solid fa-shield-virus"></i>
                </span>
                <div class="p-2 rounded-lg shadow">
                    <h3 class="mb-1 text-lg font-semibold text-white flex items-center">
                        {{ $vaccine->vaccine_name }}
                        @if($index === 0)
                        <span class="ml-2 bg-blue-500 text-xs px-2 py-1 text-white rounded">Latest</span>
                        @endif
                    </h3>
                    <time class="block mb-2 text-sm font-normal text-gray-400">
                        <strong>Administered: </strong>{{ \Carbon\Carbon::parse($vaccine->date_administered)->format('F d, Y') }}
                    </time>
                    <p class="text-sm text-gray-400">
                        <strong>Next Due: </strong>{{ \Carbon\Carbon::parse($vaccine->next_due_date)->format('F d, Y') }}
                    </p>
                    <p class="text-sm text-gray-400">
                        <strong>Attending Vet: </strong>Dr. {{ optional($vaccine->veterinarian)->Fname ?? 'Unknown' }} {{ optional($vaccine->veterinarian)->Lname ?? '' }}
                    </p>
                </div>
            </li>
            @endforeach
        </ol>
        @endif
    </div>
</div>