@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <?php if(session('success')):?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Berhasil! </strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    <?php endif ?>
      <?php if(session('error')):?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error! </strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    <?php endif ?>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Kursus Saya</h2>
        <a href="{{ route('courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Kursus
        </a>
    </div>
    <?php if (empty($courses)): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
        <i class="fas fa-book-open text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada kursus yang dibuat</p>
        <a href="{{ route('courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Buat Kursus Pertama
        </a>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($courses as $course): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800"><?= $course['title'] ?></div>
                        <div class="text-sm text-gray-500"><?= $course['price'] ?></div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?= $course['category_name'] ?? '-' ?></td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full
                            <?= $course['level'] === 'beginner' ? 'bg-green-100 text-green-600' :
                                ($course['level'] === 'intermediate' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') ?>">
                            <?= ucfirst($course['level']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?= $course['enrollment_count'] ?></td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full
                            <?= $course['status'] === 'published' ? 'bg-green-100 text-green-600' :
                                ($course['status'] === 'draft' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600') ?>">
                            <?= ucfirst($course['status']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="/modules/courses.php?action=manage&id=<?= $course['id'] ?>" class="text-indigo-600 hover:text-indigo-800" title="Kelola">
                                <i class="fas fa-cog"></i>
                            </a>
                            <a href="{{ route('courses.edit', $course['id']) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('courses.destroy', $course['id']) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600" data-confirm="Yakin ingin menghapus kategori ini?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

@include('templates.footer')
