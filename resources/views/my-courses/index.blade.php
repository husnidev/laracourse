@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kursus Saya</h2>

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

    <?php if (empty($myCourses)): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
        <i class="fas fa-book-reader text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Anda belum mengikuti kursus apapun</p>
        <a href="{{ route('browse-courses.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Jelajahi Kursus
        </a>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($myCourses as $course): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
            <div class="h-40 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                <?php if ($course->thumbnail): ?>
                    <img src="{{ asset('storage/'.$course->thumbnail) }}" class="w-full h-full object-cover">
                <?php else: ?>
                    <i class="fas fa-book text-white text-4xl"></i>
                <?php endif; ?>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full"><?= $course->category_name ?? 'Umum' ?></span>
                    <span class="text-xs text-gray-500"><?= $course->module_count ?> modules</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2"><?= $course->title ?></h3>
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Progress</span>
                        <span><?= $course->progress ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full progress-bar" style="width: <?= $course->progress ?>%"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs <?= $course->enrollment_status === 'completed' ? 'text-green-600' : 'text-blue-600' ?>">
                        <?= $course->enrollment_status === 'completed' ? 'Selesai' : 'Sedang Berlangsung' ?>
                    </span>
                    <a href="/modules/course-detail.php?id=<?= $course->id ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Lanjutkan <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
@include('templates.footer')
