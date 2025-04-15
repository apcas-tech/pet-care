@php
// Check if the metric box is for PhilSMS Balance
$isPhilSMS = $title === 'PhilSMS Balance';

// Convert value to a float for comparison if it's PhilSMS Balance
$numericValue = $isPhilSMS ? floatval(str_replace(['₱',','], '', $value)) : null;

// Determine text color
$textColor = '';
if ($isPhilSMS) {
if ($numericValue <= 3.00) {
    $textColor='text-red-500' ;
    } elseif ($numericValue <=10.00) {
    $textColor='text-orange-500' ;
    } else {
    $textColor='text-gray-900' ;
    }
    }
    @endphp

    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
    <i class="{{ $iconClass }} text-3xl mr-4"></i>
    <div>
        <h2 class="text-lg font-semibold">{{ $title }}</h2>
        <p class="text-2xl {{ $isPhilSMS ? $textColor : 'text-gray-900' }}">
            {{ $value }}
        </p>
    </div>
    </div>