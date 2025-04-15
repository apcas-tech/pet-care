<div class="dropdown relative inline-flex">
    <button type="button" data-target="dropdown-with-header" class="dropdown-toggle inline-flex justify-center items-center p-2 text-sm rounded-full cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-indigo-700">
        <div class="block mt-1">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.3331 5.83333C13.3331 7.67428 11.8407 9.16667 9.99976 9.16667C8.15881 9.16667 6.66642 7.67428 6.66642 5.83333C6.66642 3.99238 8.15881 2.5 9.99976 2.5C11.8407 2.5 13.3331 3.99238 13.3331 5.83333Z" stroke="black" stroke-width="1.6" />
                <path d="M9.99976 11.6667C7.62619 11.6667 5.54235 12.752 4.36109 14.3865C3.73609 15.2513 3.42359 15.6837 3.88775 16.5918C4.35192 17.5 5.12342 17.5 6.66642 17.5H13.3331C14.8761 17.5 15.6476 17.5 16.1118 16.5918C16.5759 15.6837 16.2634 15.2513 15.6384 14.3865C14.4572 12.752 12.3733 11.6667 9.99976 11.6667Z" stroke="black" stroke-width="1.6" />
            </svg>
        </div>
    </button>
    <div id="dropdown-with-header" class="dropdown-menu hidden rounded-xl shadow-lg bg-white absolute top-full w-72 mt-2 divide-y divide-gray-200" aria-labelledby="dropdown-with-header">
        <div class="px-4 py-3 flex gap-3 ">
            <div class="block">
                <div class="text-indigo-600 font-normal mb-1">Burat</div>
                <div class="text-sm text-gray-500 font-medium truncate">sample@gmail.com</div>
            </div>
        </div>
        <ul class="py-2">
            <li>
                <a class="block px-6 py-2 hover:text-indigo-600 text-gray-900 font-medium" href="#"> Settings </a>
            </li>
        </ul>
        <div class="py-2">
            <a class="block px-6 py-2 text-red-500 font-medium" href="#"> Log Out </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdownMenu = document.getElementById('dropdown-with-header');

        dropdownToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close the dropdown when clicking outside of it
        document.addEventListener('click', function(event) {
            if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>