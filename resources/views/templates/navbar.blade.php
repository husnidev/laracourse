<header class="fixed top-0 left-64 right-0 h-16 bg-white border-b border-gray-200 z-30 flex items-center justify-between px-6">
    <div class="flex items-center space-x-4">
        <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-800">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h1 class="text-lg font-semibold text-gray-800"><?= $pageTitle ?? 'Dashboard' ?></h1>
    </div>

    <div class="flex items-center space-x-4">
        <div class="relative">
            <button id="userMenuBtn" class="flex items-center space-x-2 focus:outline-none">
                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-indigo-600 text-sm"></i>
                </div>
                <span class="text-sm font-medium text-gray-700"><?= $_SESSION['name'] ?? 'User' ?></span>
                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
            </button>

            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-user mr-2"></i>Profil
                </a>
                <hr class="my-1">
                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </div>
</header>

<main class="ml-64 pt-16 min-h-screen p-6">
