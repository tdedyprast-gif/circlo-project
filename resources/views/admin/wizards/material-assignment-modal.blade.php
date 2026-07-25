<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Wizard Materi & Tugas</title>

    <!-- 1. Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 2. Alpine.js CDN (Wajib untuk interaktivitas tombol & step) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- 3. Mencegah elemen berkedip saat pertama kali diproses Alpine -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 dark:bg-gray-900">

    <div class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-slate-200 dark:border-gray-700 p-6">

        <!-- Inisialisasi Alpine.js -->
        <div x-data="{ 
            step: 1, 
            hasAssignment: false,
            // Fungsi validasi sederhana sebelum lanjut ke Step 2
            nextStep() {
                const session = document.querySelector('[name=course_session_id]').value;
                const title = document.querySelector('[name=material_title]').value;
                
                if (!session || !title) {
                    alert('Harap isi Sesi Pertemuan dan Judul Materi terlebih dahulu!');
                    return;
                }
                this.step = 2;
            }
        }" class="space-y-6">

            <!-- Stepper Indicator -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600 dark:bg-gray-700 dark:text-gray-400'"
                        class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all">1</div>
                    <span :class="step >= 1 ? 'text-blue-600 font-semibold dark:text-blue-400' : 'text-slate-400 dark:text-gray-500'" class="text-sm">Isi Materi</span>
                </div>
                <div class="flex-1 h-0.5 bg-slate-200 dark:bg-gray-700 mx-4"></div>
                <div class="flex items-center gap-3">
                    <div :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600 dark:bg-gray-700 dark:text-gray-400'"
                        class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all">2</div>
                    <span :class="step >= 2 ? 'text-blue-600 font-semibold dark:text-blue-400' : 'text-slate-400 dark:text-gray-500'" class="text-sm">Penugasan (Tugas)</span>
                </div>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admin.materials.wizard.store') }}" method="POST" id="wizard-modal-form">

                <!-- STEP 1: MATERIAL -->
                <div x-show="step === 1" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Sesi Pertemuan</label>
                        <select name="course_session_id" required class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-700">
                            <option value="">-- Pilih Sesi --</option>
                            @foreach($sessions as $session)
                            <option value="{{ $session->id }}">[{{ $session->course?->title ?? 'Course' }}] {{ $session->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Judul Materi *</label>
                            <input type="text" name="material_title" required placeholder="Contoh: Pencahayaan Alami"
                                class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Urutan Tampil *</label>
                            <input type="number" name="sort_order" value="1" required class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Tipe Materi *</label>
                        <select name="material_type" required class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                            <option value="video">Video (YouTube / Drive)</option>
                            <option value="pdf">PDF Document</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">URL Content (YouTube / PDF Drive)</label>
                        <input type="url" name="content" placeholder="https://..." class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Isi Teks / Artikel</label>
                        <textarea name="body_text" rows="3" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white"></textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="button" @click="nextStep()" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-blue-700 transition">
                            Lanjut ke Penugasan &rarr;
                        </button>
                    </div>
                </div>

                <!-- STEP 2: ASSIGNMENT -->
                <div x-show="step === 2" class="space-y-4" x-cloak>
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between dark:bg-gray-800/50 dark:border-gray-700">
                        <div>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-white">Tambahkan Tugas di Sesi Ini?</span>
                            <span class="text-xs text-slate-500 dark:text-gray-400">Aktifkan jika peserta wajib mengumpulkan tugas.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="has_assignment" value="1" x-model="hasAssignment" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 dark:bg-gray-700"></div>
                        </label>
                    </div>

                    <div x-show="hasAssignment" x-transition class="space-y-4 pt-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Judul Tugas</label>
                            <input type="text" name="assignment_title" placeholder="Contoh: Upload Foto Produk"
                                class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Instruksi Pengerjaan</label>
                            <textarea name="assignment_description" rows="2" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Batas Waktu (Due Date)</label>
                                <input type="datetime-local" name="due_date" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Nilai Maksimal</label>
                                <input type="number" name="max_score" value="100" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button" @click="step = 1" class="border border-slate-300 text-slate-700 dark:text-gray-300 dark:border-gray-600 px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-slate-50 dark:hover:bg-gray-700 transition">
                            &larr; Kembali
                        </button>
                        <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-medium text-sm hover:bg-emerald-700 transition">
                            Simpan Materi & Tugas
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</body>

</html>