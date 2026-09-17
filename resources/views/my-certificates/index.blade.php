@include('templates.header', ['pageTitle' => 'My Certificates'])
@include('templates.navbar')
@include('templates.sidebar')

<div class="fade-in">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Sertifikat Saya</h2>

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

    <?php if (empty($certificates)): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
        <i class="fas fa-certificate text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Anda belum memiliki sertifikat</p>
        <p class="text-sm text-gray-400 mb-4">Selesaikan kursus untuk mendapatkan sertifikat</p>
        <a href="{{ route('browse-courses.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Jelajahi Kursus
        </a>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($certificates as $cert): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
            <div class="h-32 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                <i class="fas fa-award text-white text-5xl"></i>
            </div>
            <div class="p-5">
                <h3 class="font-semibold text-gray-800 mb-2"><?= $cert->course_title ?></h3>
                <p class="text-sm text-gray-500 mb-3"><?= $cert->category_name ?? 'Umum' ?> &middot; <?= $cert->teacher_name ?></p>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">No. Sertifikat</span>
                        <span class="font-mono text-gray-800 text-xs"><?= $cert->certificate_no ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Terbit</span>
                        <span class="text-gray-800"><?= date('d M Y', strtotime($cert->issue_date)) ?></span>
                    </div>
                </div>

                <div class="mt-4 flex space-x-2">
                    <a href="/my-certificates?cert_id=<?= $cert->id ?>" class="flex-1 text-center bg-indigo-600 text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                        <i class="fas fa-eye mr-1"></i>Lihat
                    </a>
                    <a href="/my-certificates/<?= $cert->id ?>/download" class="flex-1 text-center bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                        <i class="fas fa-download mr-1"></i>Download PDF
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php if($cert_detail) : ?>
<div id="certModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Sertifikat Penyelesaian</h3>
            <div class="flex items-center space-x-3">
                <a href="{{ route('my-certificates.download', ['cert_id' => $cert_detail->id]) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                    <i class="fas fa-download mr-1"></i>Download PDF
                </a>
                <button onclick="hideModal('certModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-8">
            <div class="border-4 border-double border-yellow-400 rounded-xl p-8 text-center bg-yellow-50">
                <div class="mb-4">
                    <i class="fas fa-award text-yellow-500 text-5xl"></i>
                </div>
                <h2 class="text-sm uppercase tracking-widest text-gray-500 mb-2">Sertifikat Penyelesaian</h2>
                <p class="text-xs text-gray-400 mb-6">Diberikan kepada</p>
                <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= $cert_detail->student_name ?></h3>
                <p class="text-sm text-gray-500 mb-4">telah berhasil menyelesaikan kursus</p>
                <h4 class="text-xl font-semibold text-indigo-600 mb-6"><?= $cert_detail->course_title ?></h4>

                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-6">
                    <div>
                        <p class="text-gray-400">Kategori</p>
                        <p class="font-medium"><?= $cert_detail->category_name ?? '-' ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400">Instruktur</p>
                        <p class="font-medium"><?= $cert_detail->teacher_name ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400">No. Sertifikat</p>
                        <p class="font-mono font-medium text-xs"><?= $cert_detail->certificate_no ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400">Tanggal Terbit</p>
                        <p class="font-medium"><?= date('d F Y', strtotime($cert_detail->issue_date)) ?></p>
                    </div>
                </div>

                <div class="border-t border-yellow-300 pt-4">
                    <p class="text-xs text-gray-400">E-Learning Platform</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>showModal('certModal');</script>
<?php endif; ?>

@include('templates.footer')