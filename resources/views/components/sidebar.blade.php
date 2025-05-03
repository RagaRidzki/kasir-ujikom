<section
    class="fixed left-0 top-0 w-64 h-full bg-white shadow-sm p-4">
    <a href="/dashboard" class="flex items-center pb-4 border-b border-b-gray-300">
        <img src="{{ asset('assets/images/wikrama-logo.png') }}" alt="logo" class="w-8 h-8 rounded object-cover">
        <span class="text-md font-bold text-textColor ml-1">APLIKASI KASIR</span>
    </a>
    <ul class="mt-4">
        <li class="mb-1 group {{ Request::is('dashboard*') ? 'active' : '' }}">
            <a href="/dashboard"
                class="flex items-center py-2 px-4 text-textColor hover:bg-blue-100 hover:text-hoverText rounded-md group-[.active]:bg-blue-100 group-[.active]:text-hoverText">
                <i class="ri-home-2-line mr-3 text-lg"></i>
                <span class="text-md font-semibold">Dashboard</span>
            </a>
        </li>
        <li class="mb-1 group {{ Request::is('product*') ? 'active' : '' }}">
            <a href="/product"
                class="flex items-center py-2 px-4 text-textColor hover:bg-blue-100 hover:text-hoverText rounded-md group-[.active]:bg-blue-100 group-[.active]:text-hoverText">
                <i class="ri-store-2-line mr-3 text-lg"></i>
                <span class="text-md font-semibold">Produk</span>
            </a>
        </li>
        <li class="mb-1 group {{ Request::is('sale*') ? 'active' : '' }}">
            <a href="/sale"
                class="flex items-center py-2 px-4 text-textColor hover:bg-blue-100 hover:text-hoverText rounded-md group-[.active]:bg-blue-100 group-[.active]:text-hoverText">
                <i class="ri-shopping-bag-line mr-3 text-lg"></i>
                <span class="text-md font-semibold">Penjualan</span>
            </a>
        </li>
        @if (auth()->user()->role === 'Admin')
        <li class="mb-1 group {{ Request::is('user*') ? 'active' : '' }}">
            <a href="/user"
            class="flex items-center py-2 px-4 text-textColor hover:bg-blue-100 hover:text-hoverText rounded-md group-[.active]:bg-blue-100 group-[.active]:text-hoverText">
            <i class="ri-user-line mr-3 text-lg"></i>
            <span class="text-md font-semibold">User</span>
        </a></li>
        @endif
    </ul>
</section>
<div class="fixed top-0 left-0 w-full h-full z-40 hidden sidebar-overlay"></div>
