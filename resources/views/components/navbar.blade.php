<div class="py-4 px-6 bg-white flex items-center shadow-sm sticky top-0 left-0 z-30">
    <a href="#" class="text-lg text-gray-600 sidebar-toggle">
        <i class="ri-menu-line"></i>
    </a>
    <ul class="ml-auto flex items-center">
        <li class="dropdown ml-3 relative">
            <button type="button" id="dropdownButton" class="dropdown-toggle flex items-center">
                <img src="https://placehold.co/30x30" alt=""
                    class="w-8 h-8 rounded-full block object-cover align-middle mr-2">
                <span class="text-md font-semibold text-textColor">
                    <span class="text-md font-semibold text-textColor">
                        {{ auth()->user()->name }}
                    </span>
                </span>
            </button>
            <ul id="dropdownMenu"
                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px] absolute top-full left-0">
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit"
                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script>
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    dropdownButton.addEventListener("click", () => {
        dropdownMenu.classList.toggle("hidden");
    });

    // Menutup dropdown jika klik di luar
    document.addEventListener("click", (event) => {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add("hidden");
        }
    });
</script>
