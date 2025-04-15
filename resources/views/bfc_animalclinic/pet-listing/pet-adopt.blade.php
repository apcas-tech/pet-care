@extends('bfc_animalclinic.layouts.layout')

@section('content')

<!-- Top Bar -->
<div class="w-full bg-primary px-4 py-2 text-white flex items-center">
    <a href="{{ route('home.page') }}" class="text-2xl font-bold"><i class="fa-solid fa-angle-left fa-sm"></i></a>
    <h1 class="flex-1 text-center text-xl font-semibold">Fetch a Friend</h1>
</div>

<div class="flex flex-col items-center justify-center">
    <div class="p-4 flex items-center justify-between w-full">
        <div class="relative w-auto max-w-md">
            <input type="text" id="search-bar" placeholder="Search for pets..." class="p-2 rounded-full text-black border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button id="clear-search" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fa-solid fa-times"></i> <!-- Font Awesome X icon -->
            </button>
        </div>

        <!-- Filter Dropdown Button -->
        <div class="relative z-50">
            <button id="filterBtn" class="text-white p-2 rounded-md shadow-md flex items-center gap-2">
                <i class="fa-solid fa-filter"></i>
            </button>

            <!-- Dropdown Content -->
            <div id="dropdownMenu"
                class="hidden absolute top-full left-0 -translate-x-full mt-2 bg-white text-black font-semibold border border-gray-200 shadow-lg rounded-md w-auto">
                <ul class="divide-y divide-gray-200">
                    <li class="p-2 flex items-center gap-3 hover:bg-gray-100 cursor-pointer">
                        All
                    </li>
                    <li class="p-2 flex items-center gap-3 hover:bg-gray-100 cursor-pointer">
                        <i class="fa-solid fa-dog"></i>
                        Dog
                    </li>
                    <li class="p-2 flex items-center gap-3 hover:bg-gray-100 cursor-pointer">
                        <i class="fa-solid fa-cat"></i>
                        Cat
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-6 p-6 my-6 justify-center">

        @foreach($adoptablePets as $pet)
        <div class="relative product-card w-[300px] rounded-md shadow-xl overflow-hidden cursor-pointer snap-start shrink-0 py-8 px-6 bg-[#001D3A] flex flex-col items-center justify-center gap-3 transition-all duration-300 group">
            <!-- Pet Image -->
            <div class="img w-[180px] aspect-square bg-gray-100 z-40 rounded-md">
                <img src="{{ $pet->profile_pic ? asset('storage/'.$pet->profile_pic) : asset('imgs/default_pet.webp') }}"
                    alt="{{ $pet->name }}" class="w-full h-full object-cover rounded-md">
            </div>

            <!-- Pet Name -->
            <div class="para uppercase text-center leading-none z-40">
                <p class="text-white font-semibold text-xs font-serif">Meet</p>
                <p class="font-bold text-xl tracking-wider text-white">{{ $pet->name }}</p>
            </div>

            <!-- Pet Breed -->
            <div class="btm-container z-40 flex flex-row justify-between items-end gap-10">
                <div class="flex flex-col items-start gap-1">
                    <div class="inline-flex gap-3 items-center justify-center">
                        <div class="p-1 bg-white flex items-center justify-center rounded-full">
                            <i class="fa-solid fa-paw text-gray-800"></i>
                        </div>
                        <p class="font-semibold text-m text-white">{{ $pet->breed }}</p>
                    </div>
                </div>

                <!-- View More Button -->
                <div class="btn">
                    <a href="{{ route('pet.details', $pet->id) }}" class="uppercase font-bold text-xs p-2 whitespace-nowrap rounded-full bg-yellow-400 text-black">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="pagination w-full flex justify-center mt-4">
        {{ $adoptablePets->links('pagination::tailwind') }}
    </div>
</div>

<script>
    const filterBtn = document.getElementById('filterBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const searchBar = document.getElementById("search-bar");
    const clearButton = document.getElementById("clear-search");
    const petCards = document.querySelectorAll(".product-card");

    // Filter Dropdown Toggle
    filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        dropdownMenu.classList.add('hidden');
    });

    // Search and Filter Logic
    function filterPets() {
        const searchTerm = searchBar.value.toLowerCase();
        const selectedFilter = document.querySelector("#dropdownMenu .selected")?.textContent.trim().toLowerCase() || "all";

        petCards.forEach(card => {
            const petName = card.querySelector(".para p.font-bold").textContent.toLowerCase();
            const petType = card.querySelector(".fa-dog") ? "dog" : "cat"; // Identify pet type by icon presence

            const matchesSearch = petName.includes(searchTerm);
            const matchesFilter = selectedFilter === "all" || selectedFilter === petType;

            card.style.display = matchesSearch && matchesFilter ? "" : "none";
        });
    }

    // Search functionality
    searchBar.addEventListener("input", filterPets);

    // Clear search functionality
    clearButton.addEventListener("click", () => {
        searchBar.value = "";
        filterPets();
    });

    // Filter functionality
    document.querySelectorAll("#dropdownMenu li").forEach(item => {
        item.addEventListener("click", function() {
            document.querySelectorAll("#dropdownMenu li").forEach(li => li.classList.remove("selected"));
            this.classList.add("selected");
            filterPets();
        });
    });
</script>

@endsection