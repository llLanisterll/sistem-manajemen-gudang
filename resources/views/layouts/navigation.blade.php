<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="bg-blue-600 text-white p-1.5 rounded-lg font-bold shadow-md shadow-blue-500/30">WMS</div>
                        <span class="font-bold text-gray-700 text-lg">GudangPro</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    {{-- MENU UNTUK ADMIN --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.pending')" :active="request()->routeIs('admin.users.pending')">
                            {{ __('Approval User') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Categories') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            {{ __('Products') }}
                        </x-nav-link>

                    {{-- MENU UNTUK WAREHOUSE MANAGER --}}
                    @elseif(Auth::user()->role === 'manager')
                        <x-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('manager.transactions.index')" :active="request()->routeIs('manager.transactions.*')">
                            {{ __('Transactions') }}
                        </x-nav-link>
                        <x-nav-link :href="route('manager.restock.index')" :active="request()->routeIs('manager.restock.*')">
                            {{ __('Restock Order') }}
                        </x-nav-link>

                    {{-- MENU UNTUK STAFF GUDANG --}}
                    @elseif(Auth::user()->role === 'staff')
                        <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('staff.transactions.index')" :active="request()->routeIs('staff.transactions.*')">
                            {{ __('Transactions') }}
                        </x-nav-link>

                    {{-- MENU UNTUK SUPPLIER --}}
                    @elseif(Auth::user()->role === 'supplier')
                        <x-nav-link :href="route('supplier.dashboard')" :active="request()->routeIs('supplier.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('supplier.restock.index')" :active="request()->routeIs('supplier.restock.*')">
                            {{ __('Pesanan Masuk') }}
                        </x-nav-link>

                    {{-- MENU DEFAULT --}}
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-full text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150 gap-2">
                            {{-- Indikator Role --}}
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Info Role di Dropdown --}}
                        <div class="px-4 py-2 border-b text-xs text-gray-400">
                            Logged in as <span class="uppercase font-bold text-blue-600">{{ Auth::user()->role }}</span>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-600 hover:text-red-800 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b">
        <div class="pt-2 pb-3 space-y-1">

            {{-- MOBILE MENU ADMIN --}}
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">{{ __('Dashboard Admin') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.pending')" :active="request()->routeIs('admin.users.pending')">{{ __('Approval User') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">{{ __('Categories') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">{{ __('Products') }}</x-responsive-nav-link>

            {{-- MOBILE MENU MANAGER --}}
            @elseif(Auth::user()->role === 'manager')
                <x-responsive-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')">{{ __('Dashboard Manager') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.transactions.index')" :active="request()->routeIs('manager.transactions.*')">{{ __('Transactions') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.restock.index')" :active="request()->routeIs('manager.restock.*')">{{ __('Restock Order') }}</x-responsive-nav-link>

            {{-- MOBILE MENU STAFF --}}
            @elseif(Auth::user()->role === 'staff')
                <x-responsive-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">{{ __('Dashboard Staff') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('staff.transactions.index')" :active="request()->routeIs('staff.transactions.*')">{{ __('Transactions') }}</x-responsive-nav-link>

            {{-- MOBILE MENU SUPPLIER --}}
            @elseif(Auth::user()->role === 'supplier')
                <x-responsive-nav-link :href="route('supplier.dashboard')" :active="request()->routeIs('supplier.dashboard')">{{ __('Dashboard Supplier') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('supplier.restock.index')" :active="request()->routeIs('supplier.restock.*')">{{ __('Pesanan Masuk') }}</x-responsive-nav-link>

            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                <div class="text-xs text-blue-600 font-bold uppercase mt-1">{{ Auth::user()->role }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
