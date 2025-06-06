@extends('layouts.main')

@section('content')
    <div class="p-6">
        <x-breadcrumb title="Tambah Data User" :paths="[
            ['name' => 'Home', 'url' => ''],
            ['name' => 'Data User', 'url' => ''],
            ['name' => 'Tambah Data User', 'url' => ''],
        ]" />

        <div class="mb-6 bg-white border border-gray-200 p-6 rounded-xl">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                @method('POST')
                <div class="flex flex-col">
                    <div class="w-full mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Nama <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name"
                            class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition placeholder-gray-400"
                            placeholder="Masukan nama user">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="email" name="email"
                            class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition placeholder-gray-400"
                            placeholder="Masukkan email (contoh: user@gmail.com)">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full mb-4">
                        <label for="role" class="block text-gray-700 font-semibold mb-2">Role <span
                                class="text-red-500">*</span></label>
                        <select
                            class="appearance-none block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition placeholder-gray-400"
                            id="role" name="role">
                            <option selected disabled>-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Employee">Employee</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full mb-4">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" id="password" name="password"
                            class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition placeholder-gray-400"
                            placeholder="Masukkan kata sandi yang kuat">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-x-2">
                    <button type="submit" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-md"><i
                            class="ri-add-line"></i> Tambah User</button>
                    <a href="/user" class="py-2 px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-md">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
