@include('templates.header')
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
        <a href="/courses" class="hover:text-indigo-600">Kursus</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="/manage-courses?id=<?= $quiz['course_id'] ?>" class="hover:text-indigo-600"><?= $quiz['course_title'] ?></a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Quiz</span>
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

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><?= $quiz['title'] ?></h2>
            <p class="text-gray-500">Materi: <?= $quiz['lesson_title'] ?> &middot; <?= count($questions) ?> soal &middot; Skor: <?= $quiz['total_score'] ?></p>
        </div>
        <div class="flex items-center space-x-3">
            <form method="POST" class="flex items-center space-x-2">
                <input type="hidden" name="action" value="publish_quiz">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="publish" value="1" <?= $quiz['publish'] ? 'checked' : '' ?> class="sr-only peer" onchange="this.form.submit()">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                </label>
                <span class="text-sm <?= $quiz['publish'] ? 'text-green-600' : 'text-gray-500' ?>">
                    <?= $quiz['publish'] ? 'Published' : 'Draft' ?>
                </span>
            </form>
            <a href="/modules/quiz.php?id=<?= $quiz['id'] ?>" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm">
                <i class="fas fa-eye mr-1"></i>Preview
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <?php if (count($questions) <= 0): ?>
            <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
                <i class="fas fa-question-circle text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4">Belum ada soal</p>
                <p class="text-sm text-gray-400">Klik tombol "Tambah Soal" di sebelah kanan untuk menambahkan soal pertama</p>
            </div>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($questions as $index => $question): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                                    <?= $index + 1 ?>
                                </span>
                                <div>
                                    <p class="font-medium text-gray-800"><?= $question['question'] ?></p>
                                    <p class="text-xs text-gray-500">
                                        <?= $question['type'] === 'multiple_choice' ? 'Pilihan Ganda' : 
                                            ($question['type'] === 'true_false' ? 'Benar/Salah' : 'Essay') ?>
                                        &middot; <?= $question['score'] ?> poin
                                    </p>
                                </div>
                            </div>
                            <form method="POST" class="inline" data-confirm="Yakin ingin menghapus soal ini?">
                                <input type="hidden" name="action" value="delete_question">
                                <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <?php if (!empty($question['options'])): ?>
                    <div class="px-6 py-4 space-y-2">
                        <?php foreach ($question['options'] as $option): ?>
                        <div class="flex items-center space-x-3 p-2 rounded-lg <?= $option['is_correct'] ? 'bg-green-50 border border-green-200' : 'bg-gray-50' ?>">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center <?= $option['is_correct'] ? 'bg-green-500 text-white' : 'bg-gray-300' ?>">
                                <?php if ($option['is_correct']): ?>
                                    <i class="fas fa-check text-xs"></i>
                                <?php else: ?>
                                    <span class="text-xs text-gray-600"><?= strtoupper(substr($option['option_text'], 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <span class="text-gray-700"><?= $option['option_text'] ?></span>
                            <?php if ($option['is_correct']): ?>
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Jawaban Benar</span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 sticky top-24">
                <h3 class="font-semibold text-gray-800 mb-4">Tambah Soal</h3>
                <form method="POST" action="{{ route('manage-quiz.store') }}" id="addQuestionForm">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="quiz_id" value="<?= $quiz->id ?>">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                            <textarea name="question" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Tulis pertanyaan di sini..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Soal</label>
                            <select name="type" id="questionType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" onchange="toggleOptions()">
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="true_false">Benar / Salah</option>
                                <option value="essay">Essay</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poin</label>
                            <input type="number" name="score" value="10" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        </div>
                        
                        <div id="optionsContainer">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Jawaban</label>
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="0" checked class="text-indigo-600 focus:ring-indigo-500">
                                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi A">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="1" class="text-indigo-600 focus:ring-indigo-500">
                                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi B">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="2" class="text-indigo-600 focus:ring-indigo-500">
                                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi C">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="3" class="text-indigo-600 focus:ring-indigo-500">
                                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi D">
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Pilih radio button untuk menandai jawaban yang benar</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-plus mr-2"></i>Tambah Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

function toggleOptions() {
    const type = document.getElementById('questionType').value;
    const container = document.getElementById('optionsContainer');
    if (type === 'essay') {
        container.style.display = 'none';
    } else if (type === 'true_false') {
        container.style.display = 'block';
        container.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Jawaban</label>
            <div class="space-y-2">
                <div class="flex items-center space-x-2">
                    <input type="radio" name="correct_option" value="0" checked class="text-indigo-600 focus:ring-indigo-500">
                    <input type="text" name="options[]" value="Benar" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50" readonly>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="correct_option" value="1" class="text-indigo-600 focus:ring-indigo-500">
                    <input type="text" name="options[]" value="Salah" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50" readonly>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-1">Pilih radio button untuk menandai jawaban yang benar</p>
        `;
    } else {
        container.style.display = 'block';
        container.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Jawaban</label>
            <div class="space-y-2">
                <div class="flex items-center space-x-2">
                    <input type="radio" name="correct_option" value="0" checked class="text-indigo-600 focus:ring-indigo-500">
                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi A">
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="correct_option" value="1" class="text-indigo-600 focus:ring-indigo-500">
                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi B">
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="correct_option" value="2" class="text-indigo-600 focus:ring-indigo-500">
                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi C">
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="correct_option" value="3" class="text-indigo-600 focus:ring-indigo-500">
                    <input type="text" name="options[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Opsi D">
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-1">Pilih radio button untuk menandai jawaban yang benar</p>
        `;
    }
}
</script>

@include('templates.footer')
