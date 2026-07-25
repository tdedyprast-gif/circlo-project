import React, { useState } from 'react';

export default function MaterialGridCards({ initialData, csrfToken }) {
  const [session, setSession] = useState(initialData);
  const [loadingId, setLoadingId] = useState(null);

  // Fallback gambar berdasarkan tipe materi jika gambar tidak ada
  const getDefaultThumbnail = (type) => {
    switch (type) {
      case 'video':
        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';
      case 'pdf':
        return 'https://images.unsplash.com/photo-1568667256549-094345857637?w=600&auto=format&fit=crop&q=80';
      default:
        return 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600&auto=format&fit=crop&q=80';
    }
  };

  // Helper potong deskripsi singkat (truncate)
  const getExcerpt = (text, maxLength = 90) => {
    if (!text) return 'Tidak ada deskripsi singkat untuk materi ini.';
    const cleanText = text.replace(/(<([^>]+)>)/gi, ''); // Hapus tag HTML jika ada
    return cleanText.length > maxLength ? cleanText.substring(0, maxLength) + '...' : cleanText;
  };

  // Toggle Selesai Baca
  const handleToggleProgress = async (materialId) => {
    setLoadingId(materialId);
    try {
      const res = await fetch(`/api/student/materials/${materialId}/toggle`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ course_session_id: session.id }),
      });
      const data = await res.json();

      if (data.success) {
        setSession((prev) => ({
          ...prev,
          materials: prev.materials.map((m) =>
            m.id === materialId ? { ...m, is_completed: data.is_completed } : m
          ),
        }));
      }
    } catch (err) {
      alert('Gagal memperbarui status materi.');
    } finally {
      setLoadingId(null);
    }
  };

  return (
    <div className="space-y-6">
      
      {/* Header Dashboard Sesi */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 p-6 bg-[#141A45] rounded-2xl text-white shadow-xl">
        <div>
          <span className="text-xs uppercase tracking-widest text-[#ECE1D5] font-semibold">Sesi Aktif Hari Ini</span>
          <h1 className="text-2xl font-extrabold mt-1">{session.title}</h1>
          <p className="text-xs text-slate-300 mt-1">
            {session.materials.filter((m) => m.is_completed).length} dari {session.materials.length} Materi Selesai Dipelajari
          </p>
        </div>

        {/* Progress Bar Sesi */}
        <div className="w-full md:w-64 bg-[#0E1333] p-3 rounded-xl border border-white/10 space-y-2">
          <div className="flex justify-between text-xs font-bold">
            <span className="text-[#ECE1D5]">Progres Sesi</span>
            <span>
              {Math.round(
                (session.materials.filter((m) => m.is_completed).length / (session.materials.length || 1)) * 100
              )}
              %
            </span>
          </div>
          <div className="w-full bg-slate-700 h-2 rounded-full overflow-hidden">
            <div
              className="bg-[#7C170D] h-full transition-all duration-500 rounded-full"
              style={{
                width: `${
                  (session.materials.filter((m) => m.is_completed).length / (session.materials.length || 1)) * 100
                }%`,
              }}
            ></div>
          </div>
        </div>
      </div>

      {/* GRID CARDS MATERI */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {session.materials.map((materi) => {
          const isDone = materi.is_completed;
          const thumbnail = materi.thumbnail_url || getDefaultThumbnail(materi.type);

          return (
            <div
              key={materi.id}
              className={`group bg-white dark:bg-slate-800 rounded-2xl border overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between ${
                isDone
                  ? 'border-emerald-300 dark:border-emerald-800'
                  : 'border-slate-200 dark:border-slate-700 hover:border-[#141A45]'
              }`}
            >
              <div>
                {/* Image Container & Badges */}
                <div className="relative h-44 overflow-hidden bg-slate-100 dark:bg-slate-900">
                  <img
                    src={thumbnail}
                    alt={materi.title}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                  
                  {/* Overlay Gradient */}
                  <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                  {/* Badge Tipe Materi (Kiri Atas) */}
                  <div className="absolute top-3 left-3">
                    <span className="px-3 py-1 bg-[#141A45]/90 backdrop-blur-md text-white font-bold text-[10px] uppercase tracking-wider rounded-lg shadow-md border border-white/10">
                      {materi.type === 'video' ? '🎬 Video' : materi.type === 'pdf' ? '📄 PDF Document' : '📝 Artikel'}
                    </span>
                  </div>

                  {/* Badge Status Selesai (Kanan Atas) */}
                  <div className="absolute top-3 right-3">
                    {isDone ? (
                      <span className="px-2.5 py-1 bg-emerald-500 text-white font-bold text-xs rounded-lg shadow-md flex items-center gap-1">
                        ✓ Selesai
                      </span>
                    ) : (
                      <span className="px-2.5 py-1 bg-white/90 backdrop-blur-md text-[#141A45] font-bold text-xs rounded-lg shadow-md">
                        Belum Dibaca
                      </span>
                    )}
                  </div>

                  {/* Judul Tampil di Atas Gambar Singkat */}
                  <div className="absolute bottom-3 left-3 right-3">
                    <h3 className="text-base font-bold text-white line-clamp-1 drop-shadow-sm">
                      {materi.title}
                    </h3>
                  </div>
                </div>

                {/* Body Content Card */}
                <div className="p-5 space-y-3">
                  <p className="text-xs text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed">
                    {getExcerpt(materi.body_text || materi.content)}
                  </p>

                  {/* Indikator Tugas Sesi Terkait */}
                  {session.has_assignment && (
                    <div className="p-2.5 bg-[#ECE1D5]/40 rounded-xl border border-[#ECE1D5] flex items-center justify-between text-xs text-[#141A45]">
                      <span className="font-semibold flex items-center gap-1.5">
                        <svg className="w-4 h-4 text-[#7C170D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Tugas Sesi Tersedia
                      </span>
                      <span className="text-[10px] font-bold bg-[#7C170D] text-white px-2 py-0.5 rounded">
                        Wajib
                      </span>
                    </div>
                  )}
                </div>
              </div>

              {/* Card Footer / Action Buttons */}
              <div className="p-5 pt-0 flex items-center gap-2">
                <button
                  type="button"
                  onClick={() => handleToggleProgress(materi.id)}
                  disabled={loadingId === materi.id}
                  className={`flex-1 py-2.5 px-4 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-1.5 ${
                    isDone
                      ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200'
                      : 'bg-[#7C170D] text-white hover:bg-[#63120A] shadow-md shadow-[#7C170D]/20 active:scale-[0.98]'
                  }`}
                >
                  {loadingId === materi.id ? (
                    <span>Memproses...</span>
                  ) : isDone ? (
                    <>
                      <span>✓ Selesai Pelajari</span>
                    </>
                  ) : (
                    <>
                      <span>Pelajari & Mark Selesai</span>
                    </>
                  )}
                </button>
              </div>

            </div>
          );
        })}
      </div>
    </div>
  );
}