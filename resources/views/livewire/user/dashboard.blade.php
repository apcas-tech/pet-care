<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="w-full flex flex-col items-center justify-center my-6 md:my-8">
        <h1 class="text-2xl md:text-3xl font-semibold">Fur Sure</h1>
        <h3>Your one-stop care for pets</h3>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 p-4 gap-4">
        <button class="flex flex-col items-center justify-center py-4 px-6 gap-2 bg-white hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-neutral-500 shadow-md rounded-lg">
            <x-fas-book-bookmark class="-rotate-45 w-10 h-10" />
            {{ __('Paw Care') }}
        </button>

        <button class="flex flex-col items-center justify-center py-4 px-8 gap-2 bg-white hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-neutral-500 shadow-md rounded-lg">
            <x-iconsax-bul-pet class="rotate-45 w-10 h-10" />
            {{ __('Fur Pal') }}
        </button>

        <button class="flex flex-col items-center justify-center py-4 px-6 gap-2 bg-white hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-neutral-500 shadow-md rounded-lg">
            <x-gmdi-phone-iphone-tt class="-rotate-45 w-10 h-10" />
            {{ __('Contacts') }}
        </button>

        <button class="flex flex-col items-center justify-center py-4 px-8 gap-2 bg-white hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-neutral-500 shadow-md rounded-lg">
            <div class="relative w-10 h-10">
                <x-fas-user class="w-10 h-10" />
                <x-iconsax-bol-pet class="text-gray-400 w-8 h-8 absolute bottom-0 -right-2" />
            </div>

            {{ __('Pawfile') }}
        </button>
    </div>
</div>