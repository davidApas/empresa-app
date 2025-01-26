<aside class="relative bg-sky-900 h-screen w-64 hidden sm:block shadow-xl" style="box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);">
    <div class="p-6">
        <a href="{{ route('dashboard') }}" class="text-white text-3xl font-semibold uppercase hover:text-gray-300 transition-all duration-300 ease-in-out">
            <div class="flex justify-center mb-3">
                <img src="{{ asset('storage/imagenes/ciberplas_logo.webp') }}" alt="Inicio" class="w-32"/>
            </div>
        </a>
        <!-- <div class="mt-3 text-center text-lg">
            <span class="text-white">Ciberplas</span>
        </div> -->
        <div class="pb-3 text-center border-b border-b-gray-600 mt-2">
            <span class="text-white font-bold text-xl">TUCUMÁN</span>
        </div>
    </div>

    <nav x-data="menuState()" class="text-white text-lg font-semibold pt-4">
       
        {{-- Personas --}}
        <a href="{{ route('persona') }}" 
           class="nav-item flex items-center py-3 px-4 hover:bg-sky-800 rounded-md transition-colors {{ request()->routeIs('persona') ? 'bg-sky-900' : '' }}">
            <span class="mdi mdi-account-group mr-4 text-2xl"></span> Personas
        </a>
        {{-- Pagos --}}
        <a href="{{ route('pago') }}" 
           class="nav-item flex items-center py-3 px-4 hover:bg-sky-800 rounded-md transition-colors {{ request()->routeIs('pago') ? 'bg-sky-900' : '' }}">
            <span class="mdi mdi-cash mr-4 text-2xl"></span> Pagos
        </a>
        {{-- Adelantos --}}
        <a href="{{ route('adelanto') }}" 
           class="nav-item flex items-center py-3 px-4 hover:bg-sky-800 rounded-md transition-colors {{ request()->routeIs('adelanto') ? 'bg-sky-900' : '' }}">
            <span class="mdi mdi-calculator mr-4 text-2xl"></span> Adelantos
        </a>
        {{-- MIS DATOS --}}
        <a href="{{ route('profile.show') }}" 
           class="nav-item flex items-center py-3 px-4 hover:bg-sky-800 rounded-md transition-colors {{ request()->routeIs('profile.show') ? 'bg-sky-900' : '' }}">
            <span class="mdi mdi-card-account-details mr-4 text-2xl"></span> Mis Datos
        </a>
    </nav>
    
    <script>
        function menuState() {
            return {
                mostrar: JSON.parse(localStorage.getItem('menuExpedientes')) || false,
                toggle() {
                    this.mostrar = !this.mostrar;
                    localStorage.setItem('menuExpedientes', JSON.stringify(this.mostrar));
                },
            };
        }
    </script>
</aside>

<!-- Main content wrapper -->
<div class="w-full flex flex-col h-screen overflow-hidden">
    <!-- Desktop Header -->
    <header class="w-full flex items-center bg-sky-900 shadow-lg shadow-gray-500 text-white py-4 px-6 hidden sm:flex rounded-b-lg">
        <div class="w-1/2">
            <span class="text-4xl font-semibold">Servicio de Carga de Datos Interno</span>
        </div>

        <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
            <div class="self-center mr-4">{{ Auth::user()->apellido }} {{ Auth::user()->nombre }}</div>
            <button @click="isOpen = !isOpen" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition duration-300 ease-in-out">
                <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->apellido }} {{ Auth::user()->nombre }}" />
            </button>
            <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
            <div x-show="isOpen" class="absolute w-48 bg-white rounded-lg shadow-lg py-2 mt-16">
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-orange-700 hover:font-bold">Mi Perfil</a>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-orange-700 hover:font-bold" @click.prevent="$root.submit();">
                        {{ __('Cerrar Sesión') }}
                    </a>
                </form>
            </div>
        </div>
    </header>

    <!-- Mobile Header & Nav -->
    <header x-data="{ isOpen: false }" class="w-full bg-gray-700 py-5 px-6 sm:hidden">
        <div class="flex items-center justify-between">
            <a href="#" class="text-white text-3xl font-semibold uppercase hover:text-gray-300 transition-all duration-300 ease-in-out">
                <div class="flex gap-4">
                    <img style="width: 80px" src="{{ asset('storage/imagenes/ciberplas_logo.webp') }}" alt="Inicio"/>
                    <div style="font-size: 16px" class="self-center">Ciberplas</div>
                </div>
            </a>
            <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                <span x-show="!isOpen" class="mdi mdi-menu"></span>
                <span x-show="isOpen" class="mdi mdi-menu-open"></span>
            </button>
        </div>

        <div class="border-t border-t-gray-600 pt-3">
            <span class="text-orange-200">{{ $header ?? '' }}</span>
        </div>

        <!-- Dropdown Nav -->
        <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4 space-y-4">
            {{-- ROL EMPLEADO --}}
            {{-- MIS DATOS --}}
            <a href="{{ route('dashboard') }}" class="flex items-center text-white py-2 pl-4 hover:bg-sky-800 rounded-md">
                <i class="fas fa-tachometer-alt mr-3 text-xl"></i> Mis Datos
            </a>

        </nav>
    </header>

    <div class="w-full flex-grow overflow-x-hidden flex flex-col">
        <main class="w-full bg-gray-300 flex-grow p-6 rounded-lg shadow-md">
            <div class="py-3">
                <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="w-full bg-white text-right p-4">
            <span class="text-sm text-gray-600">Departamento Programadores. &copy;{{ date('Y') }}</span>
        </footer>
    </div>
</div>