<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <title>Login Page</title>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="flex flex-col md:flex-row w-full h-screen">
        <div class="hidden w-full md:flex md:w-1/2 items-center justify-center p-6 md:p-10">
            <dotlottie-player src="https://lottie.host/800214b0-0397-4470-be38-12c7206d4f6d/eeo75nTwGM.lottie"
                background="transparent" speed="1" style="max-width: 450px; width: 90%; height:auto;" loop autoplay>
            </dotlottie-player>
        </div>

        <div class="flex flex-col justify-between w-full h-full md:w-1/2 bg-white p-10 lg:p-20">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="w-40">
                {{-- <h1 class="text-xl font-semibold">Aplikasi Kasir</h1> --}}
            </div>
            <div class="flex flex-col w-full">
                <div class="mb-8">
                    <h1 class="mb-2 text-2xl font-semibold">Login</h1>
                    <p class="text-sm">Selamat Datang! Silakan masukkan data Anda.</p>
                </div>

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-4">
                        <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                        <input type="text" name="email" id="email"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-3 focus:ring-third transition"
                            placeholder="Masukkan email Anda">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="mb-2 block text-sm font-medium">Password</label>
                        <input type="password" name="password" id="password"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-3 focus:ring-third transition"
                            placeholder="Masukkan kata sandi Anda">
                    </div>


                    <button type="submit"
                        class="w-full py-3 text-white transition duration-300 bg-[#4A6CD1] rounded-lg cursor-pointer hover:bg-[#3A5BB5]">
                        Login
                    </button>

                </form>
            </div>
            <div class="w-full text-center">
                <h1>© 2025 Araijitech (Raga Ridzki). All Rights Reserved.</h1>
            </div>
        </div>
    </div>

    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Coba Lagi'
            });
        @endif
    </script>
</body>

</html>
