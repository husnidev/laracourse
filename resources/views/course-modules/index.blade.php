@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('courses.index') }}" class="hover:text-indigo-600">Kursus</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800"><?= $course['title'] ?></span>
    </div>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><?= $course['title'] ?></h2>
            <p class="text-gray-500"><?= count($modules) ?> modules</p>
        </div>
        <div class="flex space-x-2">
            <button onclick="showModal('editCourseModal')" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                <i class="fas fa-edit mr-2"></i>Edit Kursus
            </button>
            <button onclick="showModal('addModuleModal')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Module
            </button>
        </div>
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

    <?php if (empty($modules)): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
        <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada module dalam kursus ini</p>
        <button onclick="showModal('addModuleModal')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Tambah Module Pertama
        </button>
    </div>
    <?php else: ?>
    <div class="space-y-4">
        <?php foreach ($modules as $module): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-gray-800"><?= $module['title'] ?></h3>
                        <p class="text-sm text-gray-500"><?= $module['description'] ?? '-' ?></p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="showModal('editModuleModal<?= $module['id'] ?>')" class="text-yellow-600 hover:text-yellow-800" title="Edit Module">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="showModal('addLessonModal<?= $module['id'] ?>')" class="text-indigo-600 hover:text-indigo-800" title="Tambah Lesson">
                            <i class="fas fa-plus"></i>
                        </button>
                        <form method="POST" action="{{ route('manage-courses.destroy', $module['id']) }}" class="inline" data-confirm="Yakin ingin menghapus module ini?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus Module">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <?php if (!empty($lessons)): ?>
            <div class="divide-y divide-gray-200">
                <?php foreach ($lessons as $lesson): ?>
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-alt text-indigo-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800"><?= $lesson['title'] ?></p>
                                <p class="text-xs text-gray-500">
                                    <?php if ($lesson['video_url']): ?>
                                        <span class="mr-2"><i class="fas fa-video"></i> Video</span>
                                    <?php endif; ?>
                                    <?php if ($lesson['duration']): ?>
                                        <span class="mr-2"><i class="fas fa-clock"></i> <?= $lesson['duration'] ?> menit</span>
                                    <?php endif; ?>
                                    <span><i class="fas fa-question-circle"></i> <?= $lesson['quiz_count'] ?> Quiz</span>
                                    <span><i class="fas fa-tasks"></i> <?= $lesson['assignment_count'] ?> Tugas</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="showModal('editLessonModal<?= $lesson['id'] ?>')" class="text-yellow-600 hover:text-yellow-800" title="Edit Lesson">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="showModal('addQuizModal<?= $lesson['id'] ?>')" class="text-green-600 hover:text-green-800" title="Tambah Quiz">
                                <i class="fas fa-question-circle"></i>
                            </button>
                            <button onclick="showModal('addAssignmentModal<?= $lesson['id'] ?>')" class="text-yellow-600 hover:text-yellow-800" title="Tambah Tugas">
                                <i class="fas fa-tasks"></i>
                            </button>
                            <form method="POST" action="{{ route('manage-courses.delete_lesson') }}" class="inline" data-confirm="Yakin ingin menghapus lesson ini?">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php if (!empty($lesson->quizzes)): ?>
                    <div class="mt-3 ml-11 space-y-1">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Daftar Quiz:</p>
                        <?php foreach ($lesson->quizzes as $quiz): ?>
                        <div class="flex items-center justify-between bg-green-50 rounded-lg px-3 py-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-question-circle text-green-600 text-sm"></i>
                                <span class="text-sm text-gray-700"><?= $quiz['title'] ?></span>
                                <span class="text-xs <?= $quiz['publish'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?> px-2 py-0.5 rounded-full">
                                    <?= $quiz['publish'] ? 'Published' : 'Draft' ?>
                                </span>
                                <span class="text-xs text-gray-400"><?= $quiz['question_count'] ?> soal</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="/modules/manage-quiz.php?id=<?= $quiz['id'] ?>" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium" title="Kelola Soal">
                                    <i class="fas fa-cog"></i>
                                </a>
                                <button onclick="showModal('editQuizModal<?= $quiz['id'] ?>')" class="text-yellow-600 hover:text-yellow-800 text-xs" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action={{ route('manage-courses.delete_quiz') }} class="inline" data-confirm="Yakin ingin menghapus quiz ini? Semua soal akan terhapus!">
                                    @method('DELETE')
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    
                    {{-- <div class="mt-3 ml-11 space-y-1">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Daftar Tugas:</p>
                        <?php foreach ($lesson['assignments'] as $assignment): ?>
                        <div class="flex items-center justify-between bg-yellow-50 rounded-lg px-3 py-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-tasks text-yellow-600 text-sm"></i>
                                <span class="text-sm text-gray-700"><?= $assignment['title'] ?></span>
                                <span class="text-xs text-gray-400"><?= $assignment['submit_count'] ?> pengumpulan</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">
                                    Skor: <?= $assignment['max_score'] ?>
                                    <?php if ($assignment['due_date']): ?>
                                        &middot; Deadline: <?= date('d M Y', strtotime($assignment['due_date'])) ?>
                                    <?php endif; ?>
                                </span>
                                <button onclick="showModal('editAssignmentModal<?= $assignment['id'] ?>')" class="text-yellow-600 hover:text-yellow-800 text-xs" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" class="inline" data-confirm="Yakin ingin menghapus tugas ini? Semua pengumpulan akan terhapus!">
                                    <input type="hidden" name="action" value="delete_assignment">
                                    <input type="hidden" name="assignment_id" value="<?= $assignment['id'] ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div> --}}
                    
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="px-6 py-4 text-center text-gray-500 text-sm">
                Belum ada lesson
            </div>
            <?php endif; ?>
        </div>

        <!-- Add Lesson Modal -->
        <div id="addLessonModal<?= $module['id'] ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Tambah Lesson</h3>
                </div>
                <form method="POST" action="{{ route('manage-courses.create_lesson') }}" class="p-6">
                   @csrf
                    <input type="hidden" name="module_id" value="<?= $module['id'] ?>">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Lesson</label>
                            <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL Video</label>
                            <input type="text" name="video_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="YouTube/Vimeo URL">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>
                            <input type="number" name="duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konten Materi</label>
                            <textarea name="content" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" onclick="hideModal('addLessonModal<?= $module['id'] ?>')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Batal
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Module Modal -->
        <div id="editModuleModal<?= $module['id'] ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Module</h3>
                </div>
                <form method="POST" class="p-6" action="{{ route('manage-courses.update', $module['id']) }}" > 
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Module</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($module['title']) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"><?= htmlspecialchars($module['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" onclick="hideModal('editModuleModal<?= $module['id'] ?>')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Batal
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Lesson Modals -->
        <?php foreach ($lessons as $lesson): ?>
        <div id="editLessonModal<?= $lesson['id'] ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Lesson</h3>
                </div>
                <form method="POST" action="{{ route('manage-courses.update_lesson') }}" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Lesson</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($lesson['title']) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL Video</label>
                            <input type="text" name="video_url" value="<?= htmlspecialchars($lesson['video_url'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="YouTube/Vimeo URL">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>
                            <input type="number" name="duration" value="<?= $lesson['duration'] ?? '' ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konten Materi</label>
                            <textarea name="content" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"><?= htmlspecialchars($lesson['content'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" onclick="hideModal('editLessonModal<?= $lesson['id'] ?>')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Batal
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>

        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Edit Course Modal -->
<div id="editCourseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Edit Kursus</h3>
        </div>
        <form method="POST" action={{ route('courses.update', $course->id) }} enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kursus</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $course['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"><?= htmlspecialchars($course['description'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                    <select name="level" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="beginner" <?= $course['level'] === 'beginner' ? 'selected' : '' ?>>Pemula</option>
                        <option value="intermediate" <?= $course['level'] === 'intermediate' ? 'selected' : '' ?>>Menengah</option>
                        <option value="advanced" <?= $course['level'] === 'advanced' ? 'selected' : '' ?>>Lanjutan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (jam)</label>
                    <input type="number" name="duration" value="<?= $course['duration'] ?? '' ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="<?= $course['price'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="draft" <?= $course['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= $course['status'] === 'published' ? 'selected' : '' ?>>Publish</option>
                        <option value="archived" <?= $course['status'] === 'archived' ? 'selected' : '' ?>>Arsip</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    <?php if ($course['thumbnail']): ?>
                    <div class="mb-2"><img src="/assets/images/uploads/<?= $course['thumbnail'] ?>" class="w-20 h-20 object-cover rounded-lg"></div>
                    <?php endif; ?>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" onclick="hideModal('editCourseModal')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Update Kursus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Module Modal -->
<div id="addModuleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Module</h3>
        </div>
        <form action="{{ route('manage-courses.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="action" value="add_module">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Module</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" onclick="hideModal('addModuleModal')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<?php
// Generate modals for each lesson's quiz and assignment
foreach ($modules as $module) {
    foreach ($lessons as $lesson) {
        // Add Quiz Modal
        echo '<div id="addQuizModal' . $lesson['id'] . '" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">';
        echo '<div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">';
        echo '<div class="p-6 border-b border-gray-200"><h3 class="text-lg font-semibold text-gray-800">Tambah Quiz</h3></div>';
        echo '<form method="POST" class="p-6" action="'.route("manage-courses.create_quiz").'">';
        echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
        echo '<input type="hidden" name="lesson_id" value="' . $lesson['id'] . '">';
        echo '<div class="space-y-4">';
        echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Judul Quiz</label>';
        echo '<input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>';
        echo '<input type="number" name="duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Total Skor</label>';
        echo '<input type="number" name="total_score" value="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        echo '</div>';
        echo '<div class="mt-6 flex justify-end space-x-2">';
        echo '<button type="button" onclick="hideModal(\'addQuizModal' . $lesson['id'] . '\')" class="px-4 py-2 text-gray-600">Batal</button>';
        echo '<button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Simpan</button>';
        echo '</div></form></div></div>';
        
        // Add Assignment Modal
        echo '<div id="addAssignmentModal' . $lesson['id'] . '" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">';
        echo '<div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">';
        echo '<div class="p-6 border-b border-gray-200"><h3 class="text-lg font-semibold text-gray-800">Tambah Tugas</h3></div>';
        echo '<form method="POST" class="p-6">';
        echo '<input type="hidden" name="action" value="add_assignment">';
        echo '<input type="hidden" name="lesson_id" value="' . $lesson['id'] . '">';
        echo '<div class="space-y-4">';
        echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>';
        echo '<input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>';
        echo '<textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea></div>';
        echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu</label>';
        echo '<input type="datetime-local" name="due_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Skor Maksimal</label>';
        echo '<input type="number" name="max_score" value="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        echo '</div>';
        echo '<div class="mt-6 flex justify-end space-x-2">';
        echo '<button type="button" onclick="hideModal(\'addAssignmentModal' . $lesson['id'] . '\')" class="px-4 py-2 text-gray-600">Batal</button>';
        echo '<button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Simpan</button>';
        echo '</div></form></div></div>';
        
        // Edit Quiz Modals
        foreach ($lesson->quizzes as $quiz) {
            $due_val = $quiz['due_date'] ? date('Y-m-d\TH:i', strtotime($quiz['due_date'])) : '';
            echo '<div id="editQuizModal' . $quiz['id'] . '" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">';
            echo '<div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">';
            echo '<div class="p-6 border-b border-gray-200"><h3 class="text-lg font-semibold text-gray-800">Edit Quiz</h3></div>';
            echo '<form method="POST" action="' . route('manage-courses.update_quiz').'" class="p-6">';
            echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
            echo '<input type="hidden" name="_method" value="PUT">';
            echo '<input type="hidden" name="quiz_id" value="' . $quiz['id'] . '">';
            echo '<div class="space-y-4">';
            echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Judul Quiz</label>';
            echo '<input type="text" name="title" value="' . htmlspecialchars($quiz['title']) . '" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
            echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>';
            echo '<input type="number" name="duration" value="' . $quiz['duration'] . '" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
            echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Total Skor</label>';
            echo '<input type="number" name="total_score" value="' . $quiz['total_score'] . '" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
            echo '</div>';
            echo '<div class="mt-6 flex justify-end space-x-2">';
            echo '<button type="button" onclick="hideModal(\'editQuizModal' . $quiz['id'] . '\')" class="px-4 py-2 text-gray-600">Batal</button>';
            echo '<button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Update</button>';
            echo '</div></form></div></div>';
        }
        
        // Edit Assignment Modals
        // foreach ($lesson['assignments'] as $assignment) {
        //     $due_val = $assignment['due_date'] ? date('Y-m-d\TH:i', strtotime($assignment['due_date'])) : '';
        //     echo '<div id="editAssignmentModal' . $assignment['id'] . '" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">';
        //     echo '<div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">';
        //     echo '<div class="p-6 border-b border-gray-200"><h3 class="text-lg font-semibold text-gray-800">Edit Tugas</h3></div>';
        //     echo '<form method="POST" class="p-6">';
        //     echo '<input type="hidden" name="action" value="edit_assignment">';
        //     echo '<input type="hidden" name="assignment_id" value="' . $assignment['id'] . '">';
        //     echo '<div class="space-y-4">';
        //     echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>';
        //     echo '<input type="text" name="title" value="' . htmlspecialchars($assignment['title']) . '" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        //     echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>';
        //     echo '<textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">' . htmlspecialchars($assignment['description']) . '</textarea></div>';
        //     echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu</label>';
        //     echo '<input type="datetime-local" name="due_date" value="' . $due_val . '" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        //     echo '<div><label class="block text-sm font-medium text-gray-700 mb-1">Skor Maksimal</label>';
        //     echo '<input type="number" name="max_score" value="' . $assignment['max_score'] . '" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>';
        //     echo '</div>';
        //     echo '<div class="mt-6 flex justify-end space-x-2">';
        //     echo '<button type="button" onclick="hideModal(\'editAssignmentModal' . $assignment['id'] . '\')" class="px-4 py-2 text-gray-600">Batal</button>';
        //     echo '<button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Update</button>';
        //     echo '</div></form></div></div>';
        // }
    }
}
?>
@include('templates.footer')
