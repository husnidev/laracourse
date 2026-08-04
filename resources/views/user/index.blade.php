@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
        <button onclick="showModal('addUserModal')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Pengguna
        </button>
    </div>
    @if(session('success'))
        <div class="flash-message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="<?= $search ?>" placeholder="Cari nama atau email..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                <option value="">Semua Role</option>
                <option value="teacher" <?= Auth::user()->role === 'teacher' ? 'selected' : '' ?>>Guru/Dosen</option>
                <option value="student" <?= Auth::user()->role === 'student' ? 'selected' : '' ?>>Siswa</option>
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <?php if (empty($users)): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
        <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Tidak ada pengguna ditemukan</p>
    </div>
    <?php else: ?>
    <form id="bulkForm" method="POST" action="{{ route('users.bulkDelete') }}">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div id="bulkActions" class="hidden px-6 py-3 bg-indigo-50 border-b border-indigo-100 flex items-center justify-between">
                <span class="text-sm text-indigo-700"><span id="selectedCount">0</span> pengguna dipilih</span>
                <button type="submit" onclick="return confirm('Yakin ingin menghapus pengguna yang dipilih?')" class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-1"></i>Hapus Terpilih
                </button>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aktivitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <?php if ($user['id'] != Auth::id()): ?>
                            <input type="checkbox" name="ids[]" value="<?= $user['id'] ?>" class="user-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800"><?= $user['name'] ?></p>
                                    <p class="text-sm text-gray-500"><?= $user['email'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs px-2 py-1 rounded-full <?= $user['role'] === 'teacher' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' ?>">
                                <?= $user['role'] === 'teacher' ? 'Guru/Dosen' : 'Siswa' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?= $user['phone'] ?? '-' ?></td>
                        <td class="px-6 py-4">
                            <?php if ($user['id'] != Auth::id()): ?>
                            <select onchange="updateStatus(<?= $user['id'] ?>, this.value)" class="text-xs px-2 py-1 rounded-full border-0 cursor-pointer <?= $user['status'] === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                                <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Aktif</option>
                                <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                            <?php else: ?>
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php if ($user['role'] === 'student'): ?>
                                <?= $user['enrollment_count'] ?> kursus
                            <?php else: ?>
                                <?= $user['course_count'] ?> kursus
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <?php if  ($user['id'] != Auth::id()): ?>
                                <a href="/users/<?= $user['id'] ?>/delete" class="text-red-600 hover:text-red-800" data-confirm="Yakin ingin menghapus pengguna ini?">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>

    <div class="mt-6">
        <?= $users->links() ?>
    </div>
    <?php endif; ?>
</div>

<div id="addUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Pengguna</h3>
        </div>
        <form method="POST" action="{{ route('users.store') }}" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="student">Siswa</option>
                        <option value="teacher">Guru/Dosen</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" onclick="hideModal('addUserModal')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    function updateBulkActions() {
        const checked = document.querySelectorAll('.user-checkbox:checked').length;
        if (selectedCount) selectedCount.textContent = checked;
        if (bulkActions) bulkActions.classList.toggle('hidden', checked === 0);
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.user-checkbox').forEach(function(cb) {
                cb.checked = selectAll.checked;
            });
            updateBulkActions();
        });
    }

    document.querySelectorAll('.user-checkbox').forEach(function(cb) {
        cb.addEventListener('change', updateBulkActions);
    });
});

function updateStatus(userId, status) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/users/' + userId + '/update_status';
    form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
        '<input type="hidden" name="user_id" value="' + userId + '">' +
        '<input type="hidden" name="status" value="' + status + '">';
    document.body.appendChild(form);
    form.submit();
}
</script>

@include('templates.footer')
