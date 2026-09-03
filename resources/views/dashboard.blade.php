@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

{{-- content --}}
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Selamat datang!</h2>
        @if(Auth::user()->role == 'admin')
        <p class="text-gray-500">Panel Administrator</p>
        @elseif(Auth::user()->role == 'teacher')
        <p class="text-gray-500">Panel Guru</p>
        @else
        <p class="text-gray-500">Panel Siswa</p>
        @endif
    </div>

    <?php if(Auth::user()->role == 'admin'): ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalStudents ?></p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-graduate text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Guru</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalTeachers ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Kursus</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalCourses ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pendaftaran</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalEnrollments ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Kursus Terpopuler</h3>
            <?php if (empty($topCourses)): ?>
                <p class="text-gray-500 text-center py-4">Belum ada kursus</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($topCourses as $course): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-700"><?= $course['title'] ?></span>
                        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full">
                            <?= $course['enrollment_count'] ?> siswa
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendaftaran Terbaru</h3>
            <?php if (empty($recentEnrollments)): ?>
                <p class="text-gray-500 text-center py-4">Belum ada pendaftaran</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($recentEnrollments as $enrollment): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-700"><?= $enrollment['name'] ?></p>
                            <p class="text-xs text-gray-500"><?= $enrollment['course_name'] ?></p>
                        </div>
                        <span class="text-xs text-gray-400"><?= date('d M Y H:i', strtotime($enrollment['enrolled_at'])) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php endif; ?>

    <?php if(Auth::user()->role == 'teacher'): ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Kursus</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalCourses ?></p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalStudents ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Kursus Aktif</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $publishedCourses ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Kursus Draft</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalCourses - $publishedCourses ?></p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Kursus Terpopuler</h3>
            <?php if (empty($topCourses)): ?>
                <p class="text-gray-500 text-center py-4">Belum ada kursus</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($topCourses as $course): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-700"><?= $course['title'] ?></span>
                        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full">
                            <?= $course['enrollment_count'] ?> siswa
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendaftaran Terbaru</h3>
            <?php if (empty($recentEnrollments)): ?>
                <p class="text-gray-500 text-center py-4">Belum ada pendaftaran</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($recentEnrollments as $enrollment): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-700"><?= $enrollment['name'] ?></p>
                            <p class="text-xs text-gray-500"><?= $enrollment['course_name'] ?></p>
                        </div>
                        <span class="text-xs text-gray-400"><?= getTimeAgo($enrollment['enrolled_at']) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    @if(Auth::user()->role == 'student')
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kursus Terbaru</h3>
        @if(count($recentCourses) <= 0)
            <div class="text-center py-8">
                <i class="fas fa-book-open text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Anda belum mengikuti kursus apapun</p>
                <a href="{{ route('browse-courses.index') }}" class="inline-block mt-3 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Jelajahi Kursus
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($recentCourses as $row): ?>
                <div class="border border-gray-200 rounded-lg p-4 card-hover">
                    <div class="h-32 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg mb-3 flex items-center justify-center">
                        <i class="fas fa-book text-white text-3xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-2"><?= $row->courses?->title ?></h4>
                    <div class="mb-2">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Progress</span>
                            <span><?= $row->progress ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full progress-bar" style="width: <?= $row->progress ?>%"></div>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full <?= $row->status == 'completed' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' ?>">
                        <?= ucfirst($row->status) ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
        @endif
    </div>
    @endif

</div>

@include('templates.footer')
