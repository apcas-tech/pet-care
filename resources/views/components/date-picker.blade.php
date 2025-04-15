<!-- resources/views/components/date-picker.blade.php -->
<div class="flex flex-col items-center mt-4 bg-zinc-50 dark:bg-zinc-800 shadow-xl rounded-lg p-4 max-w-md w-full mx-auto md:max-w-lg">
    <!-- Month and Year Display with Navigation -->
    <div class="flex justify-between items-center w-full mb-4">
        <button id="prevMonth" class="bg-white dark:bg-zinc-700 md:hover:bg-gray-300 dark:md:hover:bg-zinc-600 px-3 py-2 rounded-lg shadow-md text-gray-500 hover:text-gray-700 dark:text-gray-300 hover:dark:text-white focus:outline-none" disabled>
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <span id="monthYear" class="text-lg font-semibold text-gray-800 dark:text-gray-100"></span>
        <button id="nextMonth" class="bg-white dark:bg-zinc-700 md:hover:bg-gray-300 dark:md:hover:bg-zinc-600 px-3 py-2 rounded-lg shadow-md text-gray-500 hover:text-gray-700 dark:text-gray-300 hover:dark:text-white focus:outline-none">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Days of the Week -->
    <div class="grid grid-cols-7 gap-2 text-center text-gray-600 text-xs md:text-sm font-medium dark:text-gray-300">
        <div>Sun</div>
        <div>Mon</div>
        <div>Tue</div>
        <div>Wed</div>
        <div>Thu</div>
        <div>Fri</div>
        <div>Sat</div>
    </div>

    <!-- Dates Grid -->
    <div id="calendarDays" class="grid grid-cols-7 gap-2 mt-2">
        <!-- Days will be inserted here by JavaScript -->
    </div>

    <!-- Selected Date Display -->
    <div id="selectedDate" class="mt-4 text-gray-800 dark:text-gray-100 text-sm md:text-base">
        <p id="appointmentDate" class="font-semibold border-b-2 border-black dark:border-white">No date selected</p>
    </div>
</div>