@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Tambah Data User" :paths="[
        ['name' => 'Home', 'url' => ''],
        ['name' => 'Data User', 'url' => ''],
        ['name' => 'Tambah Data User', 'url' => '']
    ]" />

    <div class="mb-6 bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <form action="user/store" method="POST" enctype="multipart/form-data" class="w-full">
            <div class="flex flex-col">
                <div class="w-full mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-700 py-2 px-4 rounded-md placeholder-gray-400"
                        placeholder="Masukan nama user">
                        
                    {{-- <p class="text-red-500 text-sm mt-1">{{ $message }}</p> --}}
                    
                </div>
                <div class="w-full mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="email" name="email"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-700 py-2 px-4 rounded-md placeholder-gray-400"
                        placeholder="Masukkan email (contoh: user@gmail.com)">
                    
                    {{-- <p class="text-red-500 text-sm mt-1">{{ $message }}</p> --}}
                    
                </div>
                <div class="w-full mb-4">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">Role <span
                            class="text-red-500">*</span></label>
                    <select
                        class="appearance-none block w-full border border-gray-300 focus:outline-none focus:border-gray-700 py-3 px-4 rounded-md  leading-tight"
                        id="role" name="role">
                        <option selected disabled>-- Pilih Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Employee">Employee</option>
                    </select>
                    
                    {{-- <p class="text-red-500 text-sm mt-1">{{ $message }}</p> --}}
                    
                </div>
                <div class="w-full mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password <span
                            class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-700 py-2 px-4 rounded-md placeholder-gray-400"
                        placeholder="Masukkan kata sandi yang kuat">
                    
                    {{-- <p class="text-red-500 text-sm mt-1">{{ $message }}</p> --}}
                    
                </div>
            </div>
            <div class="flex justify-end gap-x-2">
                <button type="submit" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-md"><i
                        class="ri-add-line"></i> Tambah User</button>
                <a href="/user" class="py-2 px-4 bg-gray-600 hover:bg-gray-700 text-white rounded-md">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection