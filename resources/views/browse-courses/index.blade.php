@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Jelajahi Kursus</h2>

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

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="<?= $search ?>" placeholder="Cari kursus..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->id ?>" <?= $category_filter == $cat->id ? 'selected' : '' ?>><?= $cat->name ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <?php if (empty($courses)): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
        <i class="fas fa-book-open text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Tidak ada kursus yang ditemukan</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($courses as $course): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
            <div class="h-40 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                <?php if ($course->thumbnail): ?>
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover">
                <?php else: ?>
                    <i class="fas fa-book text-white text-4xl"></i>
                <?php endif; ?>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full"><?= $course->category_name ?? 'Umum' ?></span>
                    <span class="text-xs text-gray-500"><?= $course->enrollment_count ?> siswa</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2"><?= $course->title ?></h3>
                <p class="text-sm text-gray-500 mb-3 line-clamp-2"><?= $course->description ?? '-' ?></p>
                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                    <span><i class="fas fa-user mr-1"></i> <?= $course->teacher_name ?></span>
                    <span><i class="fas fa-signal mr-1"></i> <?= ucfirst($course->level) ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-indigo-600"><?= number_format($course->price, 0, ',', '.') ?></span>
                    <?php if (in_array($course->id, $enrolled_ids)): ?>
                        <span class="text-green-600 text-sm"><i class="fas fa-check-circle mr-1"></i>Terdaftar</span>
                    <?php else: ?>
                        <form method="POST">
                            <input type="hidden" name="enroll" value="1">
                            <input type="hidden" name="course_id" value="<?= $course->id ?>">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                                Daftar
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

@include('templates.footer')
