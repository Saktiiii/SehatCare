<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('midone') }}/dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SehatCare</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('midone') }}/dist/css/app.css">
</head>

<body class="login">

<div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">

        <!-- LEFT INFO -->
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="/" class="-intro-x flex items-center pt-5">
                <img class="w-6" src="{{ asset('midone') }}/dist/images/logo.svg">
                <span class="text-white text-lg ml-3">
                    Sehat<span class="font-medium">Care</span>
                </span>
            </a>

            <div class="my-auto">
                <img class="-intro-x w-1/2 -mt-16"
                     src="{{ asset('midone') }}/dist/images/illustration.svg">

                     <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        Beberapa langkah lagi untuk<br>membuat akun Anda.
                    </div>
                    
                    <div class="-intro-x mt-5 text-lg text-white">
                        Layanan kesehatan terpercaya dalam satu platform.
                    </div>
                    
            </div>
        </div>
        <!-- END LEFT -->

        <!-- REGISTER FORM -->
        <div class="min-h-screen flex items-center py-10">
            <div
                class="mx-auto xl:ml-20 bg-white xl:bg-transparent
                       px-5 sm:px-8 py-8 xl:p-0
                       rounded-md shadow-md xl:shadow-none
                       w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Sign Up
                </h2>

                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">
                    Create your SehatCare account
                </div>

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="intro-x mt-8">

                        <input
                            type="text"
                            name="name"
                            class="intro-x login__input input input--lg border border-gray-300 block w-full"
                            placeholder="Full Name"
                            required
                        >

                        <input
                            type="email"
                            name="email"
                            class="intro-x login__input input input--lg border border-gray-300 block mt-4 w-full"
                            placeholder="Email"
                            required
                        >

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="intro-x login__input input input--lg border border-gray-300 block mt-4 w-full"
                            placeholder="Password"
                            required
                        >

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="intro-x login__input input input--lg border border-gray-300 block mt-4 w-full"
                            placeholder="Confirm Password"
                            required
                        >

                        <!-- Error message -->
                        <div
                            id="passwordError"
                            class="text-red-500 text-sm mt-2 hidden">
                            Password dan Konfirmasi Password tidak sama
                        </div>

                    </div>

                    <div class="intro-x flex items-center text-gray-700 mt-4 text-xs sm:text-sm">
                        <input type="checkbox" class="input border mr-2" required>
                        <span>I agree to the</span>
                        <a class="text-theme-1 ml-1" href="#">Privacy Policy</a>
                    </div>

                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button
                            type="submit"
                            class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">
                            Register
                        </button>

                        <a
                            href="{{ route('login') }}"
                            class="button button--lg w-full xl:w-32 text-gray-700 border border-gray-300 mt-3 xl:mt-0 inline-block text-center">
                            Sign In
                        </a>
                    </div>
                </form>

            </div>
        </div>
        <!-- END REGISTER FORM -->

    </div>
</div>

<script src="{{ asset('midone') }}/dist/js/app.js"></script>

<!-- FULL JS VALIDATION -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form     = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const confirm  = document.getElementById('password_confirmation');
    const errorMsg = document.getElementById('passwordError');

    function validatePassword() {
        if (confirm.value !== password.value) {
            confirm.classList.add('border-red-500');
            errorMsg.classList.remove('hidden');
            return false;
        } else {
            confirm.classList.remove('border-red-500');
            errorMsg.classList.add('hidden');
            return true;
        }
    }

    // Live check
    password.addEventListener('input', validatePassword);
    confirm.addEventListener('input', validatePassword);

    // Stop submit if invalid
    form.addEventListener('submit', function (e) {
        if (!validatePassword()) {
            e.preventDefault();
            confirm.focus();
        }
    });

});
</script>

</body>
</html>
