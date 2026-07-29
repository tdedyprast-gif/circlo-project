<div class="w-full max-w-4xl rounded-2xl border border-slate-200 bg-white p-5 shadow-xl dark:border-gray-700 dark:bg-gray-900">
    <div x-data="{
        step: 1,
        hasAssignment: false,
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
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-4 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600 dark:bg-gray-700 dark:text-gray-400'"
                    class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all">1</div>
                <div>
                    <div class="text-sm font-semibold text-slate-800 dark:text-white">Isi Materi</div>
                    <div class="text-xs text-slate-500 dark:text-gray-400">Informasi dasar materi</div>
                </div>
            </div>

            <div class="h-px flex-1 bg-slate-200 dark:bg-gray-700"></div>

            <div class="flex items-center gap-3">
                <div :class="step >= 2 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600 dark:bg-gray-700 dark:text-gray-400'"
                    class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all">2</div>
                <div>
                    <div class="text-sm font-semibold text-slate-800 dark:text-white">Penugasan</div>
                    <div class="text-xs text-slate-500 dark:text-gray-400">Opsional untuk task peserta</div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.materials.wizard.store') }}" method="POST" id="wizard-modal-form" class="space-y-5">
            @csrf

            <div x-show="step === 1" class="space-y-4">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-gray-700 dark:bg-gray-800/60">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Sesi Pertemuan</label>
                            <select name="course_session_id" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <option value="">-- Pilih Sesi --</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}">[{{ $session->course?->title ?? 'Course' }}] {{ $session->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Judul Materi</label>
                            <input type="text" name="material_title" required placeholder="Contoh: Pencahayaan Alami"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Urutan Tampil</label>
                        <input type="number" name="order" value="1" min="1" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Tipe Materi</label>
                        <select name="material_type" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="video">Video</option>
                            <option value="pdf">PDF</option>
                            <option value="text">Text</option>
                            <option value="quiz">Quiz</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">URL Konten</label>
                    <input type="url" name="content_url" placeholder="https://..." class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Isi Teks / Artikel</label>
                    <textarea name="body_text" rows="4" placeholder="Tuliskan konten / deskripsi materi di sini..." class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
                </div>

                <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800/60">
                    <div>
                        <div class="text-sm font-semibold text-slate-800 dark:text-white">Materi wajib dipelajari</div>
                        <div class="text-xs text-slate-500 dark:text-gray-400">Aktifkan jika peserta harus membuka materi ini.</div>
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-gray-200">
                        <input type="checkbox" name="is_required" value="1" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        Ya, wajib
                    </label>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="button" @click="nextStep()" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Lanjut ke Penugasan →
                    </button>
                </div>
            </div>

            <div x-show="step === 2" x-cloak class="space-y-4">
                <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800/60">
                    <div>
                        <div class="text-sm font-semibold text-slate-800 dark:text-white">Tambahkan Tugas di Sesi Ini?</div>
                        <div class="text-xs text-slate-500 dark:text-gray-400">Aktifkan jika peserta wajib mengumpulkan tugas.</div>
                    </div>
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" name="has_assignment" value="1" x-model="hasAssignment" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-emerald-600 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:after:translate-x-5 dark:bg-gray-700"></div>
                    </label>
                </div>

                <div x-show="hasAssignment" x-transition class="space-y-4 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-gray-700 dark:bg-gray-800/60">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Judul Tugas</label>
                        <input type="text" name="assignment_title" placeholder="Contoh: Upload Foto Produk" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Instruksi Pengerjaan</label>
                        <textarea name="assignment_description" rows="3" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Batas Waktu</label>
                            <input type="datetime-local" name="due_date" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700 dark:text-gray-200">Nilai Maksimal</label>
                            <input type="number" name="max_score" value="100" min="1" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="flex justify-between pt-2">
                    <button type="button" @click="step = 1" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                        ← Kembali
                    </button>
                    <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                        Simpan Materi & Tugas
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>