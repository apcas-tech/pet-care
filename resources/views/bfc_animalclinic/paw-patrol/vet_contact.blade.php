@extends('bfc_animalclinic.layouts.layout')

@section('content')
<div class="w-full bg-primary px-4 py-2 text-white flex items-center">
    <a href="{{ route('home.page') }}" class="text-2xl font-bold"><i class="fa-solid fa-angle-left fa-sm"></i></a>
    <h1 class="flex-1 text-center text-xl font-semibold">Paw Patrol</h1>
</div>

<div class="container mx-auto my-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-gray-100">Vet Contacts</h1>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($vetContacts as $vetContact)
        <div class="p-4 border rounded shadow-md flex justify-between bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $vetContact->name }}</h2>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ substr($vetContact->phone_number, 0, 4) . '-' . substr($vetContact->phone_number, 4, 3) . '-' . substr($vetContact->phone_number, 7) }}
                </p>
            </div>
            <button
                class="px-4 py-2 rounded-md focus:outline-none"
                onclick="copyToClipboard('{{ $vetContact->phone_number }}')">
                <i class="fa-regular fa-clone"></i>
            </button>
        </div>
        @empty
        <p class="text-center text-gray-500 dark:text-gray-400 col-span-full">No vet contacts available.</p>
        @endforelse
    </div>
</div>

<script>
    function copyToClipboard(number) {
        navigator.clipboard.writeText(number).then(() => {
            alert('Phone number copied to clipboard!');
        }).catch(err => {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endsection