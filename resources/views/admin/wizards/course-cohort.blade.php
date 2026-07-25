<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wizard Course & Cohort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-100 min-h-screen py-10">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-8" x-data="{ step: 1 }">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Tambah Course & Kelompok Belajar</h1>
            <p class="text-sm text-slate-500">Lengkapi informasi kelas master dan kelompok peserta (Cohort).</p>
        </div>

        <!-- Stepper Indicator -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div :class="step >= 1 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-600'"
                    class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm transition-all">1</div>
                <span :class="step >= 1 ? 'text-indigo-600 font-semibold' : 'text-slate-400'" class="text-sm">Master Course</span>
            </div>
            <div class="flex-1 h-0.5 bg-slate-200 mx-4"></div>
            <div class="flex items-center gap-3">
                <div :class="step >= 2 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-600'"
                    class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm transition-all">2</div>
                <span :class="step >= 2 ? 'text-indigo-600 font-semibold' : 'text-slate-400'" class="text-sm">Cohort (Kelompok)</span>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.courses.wizard.store') }}" method="POST">
            @csrf

            <!-- STEP 1: COURSE -->
            <div x-show="step === 1" class="space-y-5">
                <h2 class="text-lg font-semibold text-slate-700 border-b pb-2">Informasi Course</h2>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Grant / Program Sponsor</label>
                    <select name="grant_id" required class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Grant / Program --</option>
                        @foreach($grants as $grant)
                        <option value="{{ $grant->id }}" {{ old('grant_id') == $grant->id ? 'selected' : '' }}>
                            {{ $grant->full_title }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Course</label>
                    <input type="text" name="course_title" required placeholder=""
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Course</label>
                    <textarea name="course_description" rows="3" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status Publikasi</label>
                    <select name="course_status" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" @click="step = 2" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-700 transition">
                        Lanjut ke Cohort &rarr;
                    </button>
                </div>
            </div>

            <!-- STEP 2: COHORT -->
            <div x-show="step === 2" class="space-y-5" x-cloak>
                <h2 class="text-lg font-semibold text-slate-700 border-b pb-2">Informasi Cohort / Kelompok Target</h2>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kelompok (Cohort)</label>
                    <input type="text" name="cohort_name" required placeholder="Contoh: Kelompok UMKM Kecamatan Kebonagung"
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kapasitas Maksimal Peserta</label>
                    <input type="number" name="max_capacity" placeholder="30" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Fasilitator / Pendamping</label>
                    <select name="facilitator_id" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Fasilitator (Opsional) --</option>
                        @foreach($facilitators as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Tambahan Cohort</label>
                    <textarea name="cohort_description" rows="2" class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div class="flex justify-between pt-4">
                    <button type="button" @click="step = 1" class="border border-slate-300 text-slate-700 px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-slate-50 transition">
                        &larr; Kembali
                    </button>
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-medium text-sm hover:bg-emerald-700 transition">
                        Simpan Semuanya
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>