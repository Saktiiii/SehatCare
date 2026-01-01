<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('midone') }}/dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Midone</title>

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
                    Sehat<span class="font-medium">care</span>
                </span>
            </a>

            <div class="my-auto">
                <img class="-intro-x w-1/2 -mt-16"
                     src="{{ asset('midone') }}/dist/images/illustration.svg">

                     <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        Masuk untuk melanjutkan<br>layanan kesehatan Anda.
                    </div>
                    
                    <div class="-intro-x mt-5 text-lg text-white">
                        Kelola semua pesanan dan layanan kesehatan Anda dengan mudah dan aman.
                    </div>
                    
            </div>
        </div>
        <!-- END LEFT -->

        <!-- LOGIN FORM -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent
                        px-5 sm:px-8 py-8 xl:p-0
                        rounded-md shadow-md xl:shadow-none
                        w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Sign In
                </h2>

                {{-- ALERT ERROR --}}
                @if ($errors->has('login_error'))
                    <div id="login-alert"
                         class="rounded-md flex items-center mt-4 px-4 py-3 bg-theme-6 text-white">
                        <i data-feather="alert-octagon" class="w-5 h-5 mr-2"></i>

                        <span>{{ $errors->first('login_error') }}</span>

                        <i id="close-alert"
                           data-feather="x"
                           class="w-4 h-4 ml-auto cursor-pointer"></i>
                    </div>
                @endif

                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="intro-x mt-6 text-gray-500 xl:hidden text-center">
                        A few more clicks to sign in to your account
                    </div>

                    <div class="intro-x mt-8">
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="intro-x login__input input input--lg border border-gray-300 block w-full"
                            placeholder="Email"
                            required
                        >

                        <input
                            type="password"
                            name="password"
                            class="intro-x login__input input input--lg border border-gray-300 block mt-4 w-full"
                            placeholder="Password"
                            required
                        >
                    </div>

                    <div class="intro-x flex text-gray-700 text-xs sm:text-sm mt-4">
                        <div class="flex items-center mr-auto">
                            <input type="checkbox" class="input border mr-2" id="remember-me">
                            <label for="remember-me" class="cursor-pointer">
                                Remember me
                            </label>
                        </div>
                        <a href="#">Forgot Password?</a>
                    </div>

                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button type="submit"
                                class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">
                            Login
                        </button>

                        <a href="{{ route('register') }}"
                           class="button button--lg w-full xl:w-32
                                  text-gray-700 border border-gray-300
                                  mt-3 xl:mt-0 inline-block text-center">
                            Sign Up
                        </a>
                    </div>
                </form>

                <div class="intro-x mt-10 xl:mt-24 text-gray-700 text-center xl:text-left">
                    By signing in, you agree to our <br>
                    <a class="text-theme-1" href="#">Terms and Conditions</a>
                    & <a class="text-theme-1" href="#">Privacy Policy</a>
                </div>

            </div>
        </div>
        <!-- END LOGIN FORM -->

    </div>
</div>

<!-- JS -->
<script src="{{ asset('midone') }}/dist/js/app.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const alertBox = document.getElementById('login-alert');
    const closeBtn = document.getElementById('close-alert');
    const loginForm = document.getElementById('login-form');

    // Klik X → tutup alert
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            alertBox.classList.add('hidden');
        });
    }

    // Submit login → alert hilang
    if (loginForm) {
        loginForm.addEventListener('submit', function () {
            if (alertBox) {
                alertBox.classList.add('hidden');
            }
        });
    }

});
</script>

</body>
</html>
