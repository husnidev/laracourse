@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Kategori Kursus</h2>
        <button onclick="showModal('addCategoryModal')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Berhasil! </strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(empty($categories))
        <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
            <i class="fas fa-tags text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Belum ada kategori</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categories as $cat)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 card-hover">
            <div class="flex justify-between items-start mb-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tag text-indigo-600"></i>
                </div>
                <div class="flex space-x-2">
                    <button onclick="document.getElementById('editCat<?= $cat['id'] ?>').classList.toggle('hidden')" class="text-gray-400 hover:text-indigo-600">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('categories.destroy', $cat['id']) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600" data-confirm="Yakin ingin menghapus kategori ini?">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1"><?= $cat['name'] ?></h3>
            <p class="text-sm text-gray-500 mb-3"><?= $cat['description'] ?? '-' ?></p>
            <p class="text-xs text-gray-400"><?= $cat['course_count'] ?> kursus</p>

            <div id="editCat<?= $cat['id'] ?>" class="hidden mt-4 pt-4 border-t border-gray-200">
                <form method="POST" action="{{ route('categories.update', $cat['id']) }}">
                    @csrf
                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                    <input type="text" name="name" value="<?= $cat['name'] ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-2 text-sm">
                    <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-2 text-sm"><?= $cat['description'] ?></textarea>
                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm hover:bg-indigo-700">Update</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Kategori</h3>
        </div>
        <form method="POST" class="p-6">
            <input type="hidden" name="action" value="store">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" onclick="hideModal('addCategoryModal')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@include('templates.footer')
