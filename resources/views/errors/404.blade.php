<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    @vite('resources/css/app.css') <!-- Use Vite for CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Add Google Font Merriweather -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <!-- Apply Merriweather font -->
            <h1 class="text-8xl font-bold text-gray-700 mb-6" style="font-family: 'Merriweather', serif;">404</h1>
            <img src="{{ asset('imgs/404.webp') }}" alt="404 Not Found" class="my-6 h-auto"> <!-- Center the image -->
            <p class="text-xl text-gray-600 my-6">Oh No! Toby ate this page!</p> <!-- Added margin y for spacing -->
            <a href="{{ url('/') }}" class="mt-6 px-4 py-2 bg-primary text-white rounded hover:bg-secondary transition">
                Go back to Home
            </a>
        </div>
    </div>
</body>

</html>