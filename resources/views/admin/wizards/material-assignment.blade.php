<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Konfigurasi Warna Kustom Tailwind -->
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            red: '#7C170D',
            navy: '#141A45',
            cream: '#ECE1D5',
            'red-hover': '#63120A',
            'navy-hover': '#0E1333',
            'cream-light': '#F7F3EE',
          }
        }
      }
    }
  }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-brand-cream/60">
    <div x-data="{ step: 1, hasAssignment: false }" class="space-y-6">

        <!-- Stepper Indicator -->
        <div class="relative flex items-center justify-between pb-6 border-b border-brand-cream">
            
            <!-- Step 1 Indicator -->
            <button type="button" @click="step = 1" class="flex items-center gap-3 group focus:outline-none text-left">
                <div :class="step >= 1 ? 'bg-brand-red text-white shadow-md shadow-brand-red/20 ring-4 ring-brand-red/10' : 'bg-brand-cream/60 text-brand-navy'" 
                     class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm transition-all duration-300">
                     1
                </div>
                <div>
                    <span class="block text-xs uppercase tracking-wider font-medium text-slate-400">Langkah 1</span>
                    <span :class="step >= 1 ? 'text-brand-navy font-bold dark:text-white' : 'text-slate-400 font-medium'" class="text-sm transition-colors">Isi Materi</span>
                </div>
            </button>

            <!-- Line Separator -->
            <div class="flex-1 h-0.5 bg-brand-cream mx-6 rounded-full overflow-hidden">
                <div class="h-full bg-brand-red transition-all duration-500 ease-out" :style="`width: ${step === 2 ? '100%' : '0%'}`"></div>
            </div>

            <!-- Step 2 Indicator -->
            <button type="button" @click="step = 2" class="flex items-center gap-3 group focus:outline-none text-left">
                <div :class="step >= 2 ? 'bg-brand-red text-white shadow-md shadow-brand-red/20 ring-4 ring-brand-red/10' : 'bg-brand-cream/60 text-brand-navy'" 
                     class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm transition-all duration-300">
                     2
                </div>
                <div>
                    <span class="block text-xs uppercase tracking-wider font-medium text-slate-400">Langkah 2</span>
                    <span :class="step >= 2 ? 'text-brand-navy font-bold dark:text-white' : 'text-slate-400 font-medium'" class="text-sm transition-colors">Penugasan</span>
                </div>
            </button>
        </div>

        <!-- Form Body -->
        <form action="{{ route('admin.materials.wizard.store') }}" method="POST" id="wizard-modal-form">
            @csrf

            <!-- STEP 1: MATERIAL -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5">
                
                <div>
                    <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Sesi Pertemuan <span class="text-brand-red">*</span></label>
                    <select name="course_session_id" required 
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy focus:bg-brand-navy focus:text-white focus:placeholder-slate-400 focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                        <option value="" class="bg-white text-brand-navy dark:bg-gray-800 dark:text-white">-- Pilih Sesi --</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}" class="bg-white text-brand-navy dark:bg-gray-800 dark:text-white">[{{ $session->course?->title ?? 'Course' }}] {{ $session->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Judul Materi <span class="text-brand-red">*</span></label>
                        <input type="text" name="material_title" required placeholder="Contoh: Pencahayaan Alami" 
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy placeholder-slate-400 focus:bg-brand-navy focus:text-white focus:placeholder-slate-300 focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Urutan Tampil <span class="text-brand-red">*</span></label>
                        <input type="number" name="sort_order" value="1" required 
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy focus:bg-brand-navy focus:text-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Tipe Materi <span class="text-brand-red">*</span></label>
                    <select name="material_type" required 
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy focus:bg-brand-navy focus:text-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                        @foreach($materialTypes as $type)
                            <option value="{{ $type->value }}" class="bg-white text-brand-navy dark:bg-gray-800 dark:text-white">{{ $type->getLabel() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">URL Content (YouTube / PDF Drive)</label>
                    <input type="url" name="content" placeholder="https://..." 
                           class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy placeholder-slate-400 focus:bg-brand-navy focus:text-white focus:placeholder-slate-300 focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Isi Teks / Artikel</label>
                    <textarea name="body_text" rows="3" placeholder="Tuliskan materi teks atau catatan di sini..." 
                              class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy placeholder-slate-400 focus:bg-brand-navy focus:text-white focus:placeholder-slate-300 focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy"></textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" @click="step = 2" class="inline-flex items-center gap-2 bg-brand-red text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-brand-red-hover active:scale-[0.98] transition-all shadow-md shadow-brand-red/20">
                        <span>Lanjut ke Penugasan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </div>

            <!-- STEP 2: ASSIGNMENT -->
            <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5">
                
                <!-- Toggle Box -->
                <div class="p-4 bg-brand-cream-light border border-brand-cream/80 rounded-2xl flex items-center justify-between dark:bg-gray-800/60 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-brand-navy/10 text-brand-navy rounded-xl dark:bg-gray-700 dark:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-brand-navy dark:text-white">Tambahkan Tugas di Sesi Ini?</span>
                            <span class="text-xs text-slate-500 dark:text-gray-400">Aktifkan jika peserta wajib mengumpulkan tugas.</span>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="has_assignment" value="1" x-model="hasAssignment" class="sr-only peer">
                        <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-red dark:bg-gray-700"></div>
                    </label>
                </div>

                <!-- Toggle Content -->
                <div x-show="hasAssignment" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4 pt-1">
                    <div>
                        <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Judul Tugas</label>
                        <input type="text" name="assignment_title" placeholder="Contoh: Upload Foto Produk" 
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy placeholder-slate-400 focus:bg-brand-navy focus:text-white focus:placeholder-slate-300 focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Instruksi Pengerjaan</label>
                        <textarea name="assignment_description" rows="3" placeholder="Tulis instruksi lengkap pengerjaan tugas di sini..." 
                                  class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy placeholder-slate-400 focus:bg-brand-navy focus:text-white focus:placeholder-slate-300 focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Batas Waktu (Due Date)</label>
                            <input type="datetime-local" name="due_date" 
                                   class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy focus:bg-brand-navy focus:text-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-brand-navy dark:text-gray-200 mb-1.5">Nilai Maksimal</label>
                            <input type="number" name="max_score" value="100" 
                                   class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm text-brand-navy focus:bg-brand-navy focus:text-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/30 transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:bg-brand-navy">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-gray-800">
                    <button type="button" @click="step = 1" class="inline-flex items-center gap-2 border border-brand-cream text-brand-navy px-5 py-3 rounded-xl font-semibold text-sm hover:bg-brand-cream-light transition-all dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Kembali</span>
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-navy text-white px-7 py-3 rounded-xl font-semibold text-sm hover:bg-brand-navy-hover active:scale-[0.98] transition-all shadow-lg shadow-brand-navy/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Materi & Tugas</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>