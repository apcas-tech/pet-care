@extends('bfc_animalclinic.layouts.layout')

@section('content')
<div class="container mx-auto p-6 text-center">
    <h1 class="text-3xl font-bold text-primary-dark dark:text-primary-light mb-4">Contact Us</h1>
    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
        Have questions? Feel free to reach out to us!
    </p>
    <div class="mt-6 text-left max-w-md mx-auto space-y-4 text-lg leading-relaxed bg-white/20 backdrop-blur-md p-4 rounded-lg shadow-lg border border-white/30">
        <p><i class="fa-solid fa-phone mr-1"></i> <a href="tel:+1234567890" class="hover:underline">+63 929 587 2743</a></p>
        <p><i class="fa-solid fa-envelope-open-text mr-1"></i> <a href="mailto:bfcanimalclinic@yahoo.com" class="hover:underline">bfcanimalclinic@yahoo.com</a></p>
        <p><i class="fa-solid fa-map-location-dot mr-1"></i> QGXP+GX7, National Rd, Orani, Bataan, 2112</p>
    </div>
    <div class="mt-6">
        <div>
            <iframe class="w-full max-w-md mx-auto rounded-lg shadow-lg" height="250" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d246986.52907174092!2d120.5376996029073!3d14.70328668874122!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33964024e6dec43b%3A0x19cc19f159de41a9!2sBfc%20Animal%20Clinic%20%26%20Grooming%20Center!5e0!3m2!1sen!2sph!4v1729055947286!5m2!1sen!2sph" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div>
            <iframe class="w-full max-w-md mx-auto rounded-lg shadow-lg" height="250" src="https://www.google.com/maps/embed?pb=!3m2!1sen!2sph!4v1729055106614!5m2!1sen!2sph!6m8!1m7!1sYCQuh_O9zLTKMqka0V3zLA!2m2!1d14.70328668874122!2d120.5376996029073!3f63.70823418525031!4f0.5511115360258998!5f2.877317152468198" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
@endsection