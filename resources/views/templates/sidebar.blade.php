<aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white border-r border-gray-200 z-40 transform transition-transform duration-300">
    <div class="p-4 border-b border-gray-200">
        <a href="/" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white text-sm"></i>
            </div>
            <span class="text-xl font-bold text-gray-800">E-Learning</span>
        </a>
    </div>

    <nav class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="/modules/dashboard.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- @if(Auth::user()->role == 'admin' || auth()->user()->role == 'teacher') --}}
            <li>
                <a href="/modules/courses.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'courses.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-book"></i>
                    <span>Semua Kursus</span>
                </a>
            </li>
            <li>
                <a href="/modules/categories.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>
            <li>
                <a href="/modules/students.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'students.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-users"></i>
                    <span>Siswa</span>
                </a>
            </li>
            {{-- @endif --}}

            {{-- @if(Auth::user()->role == 'student') --}}
            <li>
                <a href="/modules/browse-courses.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'browse-courses.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-search"></i>
                    <span>Jelajahi Kursus</span>
                </a>
            </li>
            <li>
                <a href="/modules/my-courses.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'my-courses.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-book-reader"></i>
                    <span>Kursus Saya</span>
                </a>
            </li>
            <li>
                <a href="/modules/my-certificates.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'my-certificates.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-certificate"></i>
                    <span>Sertifikat</span>
                </a>
            </li>
            {{-- @endif --}}

            {{-- @if(Auth::user()->role == 'admin') --}}
            <li class="pt-4 pb-1">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3">Admin</span>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' ?>">
                    <i class="fas fa-user-cog"></i>
                    <span>Pengguna</span>
                </a>
            </li>
            {{-- @endif --}}
        </ul>
    </nav>
</aside>
