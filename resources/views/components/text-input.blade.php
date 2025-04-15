@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 text-gray-900 bg-transparent dark:text-white dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:bg-gray-200 dark:focus:bg-gray-700 rounded-md shadow-sm']) }}>