@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Siswa Terdaftar</h2>

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

    <?php if (count($students) <= 0): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
        <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Belum ada siswa terdaftar</p>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <input type="text" id="searchStudent" placeholder="Cari siswa..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>
        <table class="w-full" id="studentTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kursus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($students as $student): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800"><?= $student['name'] ?></p>
                                <p class="text-sm text-gray-500"><?= $student['email'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?= $student['course_title'] ?></td>
                    <td class="px-6 py-4">
                        <div class="w-24">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span><?= $student['progress'] ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: <?= $student['progress'] ?>%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full
                            <?= $student['enrollment_status'] === 'completed' ? 'bg-green-100 text-green-600' :
                                ($student['enrollment_status'] === 'active' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600') ?>">
                            <?= ucfirst($student['enrollment_status']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?= date('d M Y', strtotime($student['enrolled_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('searchStudent')?.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#studentTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

@include('templates.footer')
