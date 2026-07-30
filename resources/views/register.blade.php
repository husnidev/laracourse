<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - E-Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Akun</h1>
                <p class="text-gray-500 mt-1">Buat akun E-Learning baru</p>
            </div>
            @if(session('success'))
                <div class="flash-message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            <form method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                </div>
                @error('name')
                <div class="flash-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $message }}</div>
                @enderror
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Masukkan email" value="{{ old('email') }}">
                </div>
                @error('email')
                <div class="flash-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $message }}</div>
                @enderror
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Masukkan nomor telepon" value="{{ old('phone') }}">
                </div>
                @error('phone')
                <div class="flash-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $message }}</div>
                @enderror
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Sebagai</label>
                    <select name="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="student">Siswa</option>
                        <option value="teacher">Guru/Dosen</option>
                    </select>
                </div>
                @error('role')
                <div class="flash-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $message }}</div>
                @enderror
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                        placeholder="Minimal 6 karakter">
                </div>
                @error('password')
                <div class="flash-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $message }}</div>
                @enderror
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="confirm_password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                        placeholder="Ulangi password">
                </div>
                @error('confirm password')
                <div class="flash-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $message }}</div>
                @enderror
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                    <i class="fas fa-user-plus mr-2"></i>Daftar
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-500 text-sm">Sudah punya akun?
                    <a href="/login" class="text-indigo-600 hover:text-indigo-700 font-medium">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
