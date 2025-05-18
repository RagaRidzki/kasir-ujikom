<section id="sidebar" class="fixed left-0 top-0 h-full bg-gray border-r border-r-gray-200 p-4 w-64 transition-all duration-300 overflow-hidden">
    <a href="/dashboard" class="flex items-center pb-4 border-b border-b-gray-200">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo"
            class="w-40 rounded object-cover transition-all duration-300">

    </a>
    <ul class="mt-4">
        <li class="mb-3 group {{ $isActive = Request::is('dashboard*') ? 'active' : '' }}">
            <a href="/dashboard"
                class="flex items-center py-2 px-4 text-text-secondary hover:bg-third hover:text-secondary rounded-md group-[.active]:bg-third group-[.active]:text-secondary">
                @if ($isActive)
                <i class="ri-dashboard-fill mr-3 text-xl"></i>
                @else
                <i class="ri-dashboard-line mr-3 text-xl"></i>
                @endif
                <span class="text-sm font-semibold">Dashboard</span>
            </a>
        </li>
        <li class="mb-3 group {{ $isActive = Request::is('product*') ? 'active' : '' }}">
            <a href="/product"
                class="flex items-center py-2 px-4 text-text-secondary hover:bg-third hover:text-secondary rounded-md group-[.active]:bg-third group-[.active]:text-secondary">
                @if ($isActive)
                <i class="ri-store-3-fill mr-3 text-xl"></i>
                @else
                <i class="ri-store-3-line mr-3 text-xl"></i>
                @endif
                <span class="text-sm font-semibold">Produk</span>
            </a>
        </li>
        <li class="mb-3 group {{ $isActive = Request::is('sale*') ? 'active' : '' }}">
            <a href="/sale"
                class="flex items-center py-2 px-4 text-text-secondary hover:bg-third hover:text-secondary rounded-md group-[.active]:bg-third group-[.active]:text-secondary">
                @if ($isActive)
                <i class="ri-shopping-bag-fill mr-3 text-xl"></i>
                @else
                <i class="ri-shopping-bag-line mr-3 text-xl"></i>
                @endif
                <span class="text-sm font-semibold">Penjualan</span>
            </a>
        </li>
        @if (auth()->user()->role === 'Admin')
        <li class="mb-3 group {{ $isActive = Request::is('user*') ? 'active' : '' }}">
            <a href="/user"
                class="flex items-center py-2 px-4 text-text-secondary hover:bg-third hover:text-secondary rounded-md group-[.active]:bg-third group-[.active]:text-secondary">
                @if ($isActive)
                <i class="ri-user-fill mr-3 text-xl"></i>
                @else
                <i class="ri-user-line mr-3 text-xl"></i>
                @endif
                <span class="text-sm font-semibold">User</span>
            </a>
        </li>
        @endif
    </ul>
</section>
<div class="fixed inset-0 bg-black/50 z-40 hidden sidebar-overlay"></div>