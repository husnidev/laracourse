@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('my-courses.index') }}" class="hover:text-indigo-600">Kursus Saya</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800"></span>
    </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800"><?= $enrollment->title ?></h2>
                        <p class="text-gray-500">Oleh <?= $enrollment->teacher_name ?> &middot; <?= $enrollment->category_name ?></p>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full <?= $enrollment->enrollment_status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' ?>">
                        <?= $enrollment->enrollment_status === 'completed' ? 'Selesai' : 'Berlangsung' ?>
                    </span>
                </div>
                <p class="text-gray-600 mb-4"><?= $enrollment->description ?? '-' ?></p>
                <div class="grid grid-cols-3 gap-4 text-center text-sm">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500">Level</p>
                        <p class="font-medium text-gray-800"><?= ucfirst($enrollment->level) ?></p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500">Durasi</p>
                        <p class="font-medium text-gray-800"><?= $enrollment->duration ?? '-' ?> jam</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500">Modul</p>
                        <p class="font-medium text-gray-800"><?= count($modules) ?></p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <?php foreach ($modules as $module_index => $module): ?>
                <?php
                    $module_completed = true;
                    foreach ($lessons as $l) {
                        if (!in_array($l->id, $completed_lesson_ids)) {
                            $module_completed = false;
                            break;
                        }
                    }
                ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800">
                                <span class="text-indigo-600">Modul <?= $module_index + 1 ?>:</span> <?= $module['title'] ?>
                            </h3>
                            <?php if ($module_completed && !empty($module['lessons'])): ?>
                            <span class="text-green-600 text-sm"><i class="fas fa-check-circle"></i> Selesai</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($module['description']): ?>
                        <p class="text-sm text-gray-500 mt-1"><?= $module['description'] ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($lessons)): ?>
                    <div class="divide-y divide-gray-200">
                        <?php foreach ($lessons as $lesson): ?>
                        <?php $is_completed = in_array($lesson['id'], $completed_lesson_ids); ?>
                        <div class="p-6 <?= $is_completed ? 'bg-green-50/30' : '' ?>">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <?php if ($is_completed): ?>
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                        <?php else: ?>
                                        <span class="text-gray-400"><i class="fas fa-circle"></i></span>
                                        <?php endif; ?>
                                        <h4 class="font-medium text-gray-800"><?= $lesson['title'] ?></h4>
                                    </div>

                                    <?php if ($lesson['video_url']): ?>
                                    <div class="mb-3">
                                        <?php
                                        $video_src = $lesson['video_url'];
                                        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $video_src, $m)) {
                                            $video_src = 'https://www.youtube.com/embed/' . $m[1];
                                        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $video_src, $m)) {
                                            $video_src = 'https://www.youtube.com/embed/' . $m[1];
                                        }
                                        ?>
                                        <iframe width="100%" height="315" src="<?= $video_src ?>" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="rounded-lg"></iframe>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($lesson['content']): ?>
                                    <div class="prose prose-sm max-w-none text-gray-600 mb-3">
                                        <?= nl2br($lesson['content']) ?>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($lesson['duration']): ?>
                                    <p class="text-sm text-gray-500 mb-3"><i class="fas fa-clock mr-1"></i> <?= $lesson['duration'] ?> menit</p>
                                    <?php endif; ?>

                                    <?php if (!empty($lesson->quizzes)): ?>
                                    <div class="mt-3">
                                        <?php foreach ($lesson->quizzes as $quiz): ?>
                                        <a href="/modules/quiz.php?id=<?= $quiz['id'] ?>" class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm mr-2 mb-2 hover:bg-green-200">
                                            <i class="fas fa-question-circle mr-1"></i>Quiz: <?= $quiz['title'] ?>
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>

                                    <?php if (!empty($lesson->assignments)): ?>
                                    <div class="mt-3">
                                        <?php foreach ($lesson->assignments as $assignment): ?>
                                        <a href="/modules/assignment.php?id=<?= $assignment['id'] ?>" class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm mr-2 mb-2 hover:bg-yellow-200">
                                            <i class="fas fa-tasks mr-1"></i>Tugas: <?= $assignment['title'] ?>
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($enrollment->enrollment_status === 'active'): ?>
                                <div class="ml-4">
                                    <?php if ($is_completed): ?>
                                    <span class="text-green-600 text-xl" title="Sudah Selesai">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                    <?php else: ?>
                                    <form method="POST" action="{{ route('my-courses.complete_lesson', ['lesson_id' => $lesson->id]) }}">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                        <button type="submit" class="text-gray-400 hover:text-green-600" title="Tandai Selesai">
                                            <i class="far fa-circle text-xl"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="p-6 text-center text-gray-500 text-sm">
                        Belum ada materi
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 sticky top-24">
                <h3 class="font-semibold text-gray-800 mb-4">Progress Kursus</h3>
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-500 mb-2">
                        <span>Selesai</span>
                        <span><?= $enrollment->enrollment_progress ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-indigo-600 h-3 rounded-full progress-bar" style="width: <?= $enrollment->enrollment_progress ?>%"></div>
                    </div>
                </div>

                <?php if ($enrollment->enrollment_status === 'completed'): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center mb-4">
                    <i class="fas fa-trophy text-green-500 text-3xl mb-2"></i>
                    <p class="text-green-700 font-medium">Kursus Selesai!</p>
                    <a href="/modules/my-certificates.php" class="text-green-600 text-sm hover:underline">Lihat Sertifikat</a>
                </div>
                <?php endif; ?>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Tanggal Mulai</span>
                        <span class="text-gray-800"><?= date('d M Y', strtotime($enrollment->enrolled_at)) ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Total Modul</span>
                        <span class="text-gray-800"><?= count($modules) ?></span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Status</span>
                        <span class="<?= $enrollment->enrollment_status === 'completed' ? 'text-green-600' : 'text-blue-600' ?>">
                            <?= $enrollment->enrollment_status === 'completed' ? 'Selesai' : 'Berlangsung' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
