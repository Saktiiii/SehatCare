<div>
    <div class="border-b border-theme-24 -mt-10 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 pt-3 md:pt-0 mb-10">
        <div class="top-bar-boxed flex items-center">
            <!-- BEGIN: Logo -->
            <a href="{{ route('dashboard') }}" class="-intro-x hidden md:flex items-center">
                <img alt="SehatCare" class="w-8" src="{{ asset('midone/dist/images/logo.svg') }}">
                <span class="text-white text-lg ml-3">Sehat<span class="font-medium">Care</span></span>
            </a>
            <!-- END: Logo -->

            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb breadcrumb--light mr-auto">
                <a href="{{ route('dashboard') }}">Application</a>
                <i data-feather="chevron-right" class="breadcrumb__icon"></i>
                <a href="" class="breadcrumb--active">@yield('breadcrumb', 'Dashboard')</a>
            </div>
            <!-- END: Breadcrumb -->

            <!-- BEGIN: Search (Opsional – bisa dihapus jika tidak dipakai) -->
            <div class="intro-x relative mr-3 sm:mr-6">
                <div class="search hidden sm:block">
                    <input type="text" class="search__input input placeholder-theme-13" placeholder="Cari...">
                    <i data-feather="search" class="search__icon"></i>
                </div>
                <a class="notification notification--light sm:hidden" href="">
                    <i data-feather="search" class="notification__icon"></i>
                </a>
            </div>
            <!-- END: Search -->

            <!-- BEGIN: Notifications (Bisa dikembangkan nanti dengan data real) -->
            <div class="intro-x dropdown relative mr-4 sm:mr-6">
                <div class="dropdown-toggle notification notification--light notification--bullet cursor-pointer">
                    <i data-feather="bell" class="notification__icon"></i>
                </div>
                <div class="notification-content dropdown-box mt-8 absolute top-0 right-0 z-10 -mr-10 sm:mr-0">
                    <div class="notification-content__box dropdown-box__content box">
                        <div class="notification-content__title">Notifikasi</div>
                        <div class="text-center py-8 text-gray-600">
                            Belum ada notifikasi
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Notifications -->

            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-10 h-10 relative">
                    <div class="dropdown-toggle w-10 h-10 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110 border-2" >
                            <img alt="{{ auth()->user()->name }}" src="{{ asset('midone') }}/dist/images/profile-9.jpg">
                    </div>

                <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                    <div class="dropdown-box__content box bg-theme-38 text-white">
                        <!-- Info User -->
                        <div class="p-4 border-b border-theme-40">
                            <div class="font-medium text-lg">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-theme-41 capitalize">
                                {{ auth()->user()->role ?? 'user' }}
                            </div>
                        </div>

                        <!-- Menu -->
                        <div class="p-2">
                            <!-- Profile – semua role -->
                            {{-- <a href="{{ route('profile.show') }}"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md">
                                <i data-feather="user" class="w-4 h-4 mr-2"></i> Profil Saya
                            </a> --}}

                            <!-- Khusus Nakes / Admin -->
                            @role(['admin', 'nakes', 'petugas'])
                            <a href="{{ route('nakes.profile.show') }}"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md">
                                <i data-feather="shield" class="w-4 h-4 mr-2"></i> Profil Nakes
                            </a>
                            @endrole

                            {{-- <!-- Ganti Password – semua role -->
                            <a href="{{ route('password.request') }}"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md">
                                <i data-feather="lock" class="w-4 h-4 mr-2"></i> Ganti Password
                            </a> --}}

                            <!-- Bantuan -->
                            <a href="#"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md">
                                <i data-feather="help-circle" class="w-4 h-4 mr-2"></i> Bantuan
                            </a>
                        </div>

                        <!-- Logout -->
                        <div class="p-2 border-t border-theme-40">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md">
                                <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    </div>
</div>