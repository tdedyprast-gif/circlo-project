import React, { useState } from 'react';

export default function SessionLearningApp({ initialData, csrfToken }) {
  const [session, setSession] = useState(initialData);
  const [activeTab, setActiveTab] = useState('materials'); // 'materials' | 'assignments'
  const [activeMaterial, setActiveMaterial] = useState(initialData.materials[0] || null);
  const [selectedFile, setSelectedFile] = useState(null);
  const [taskNotes, setTaskNotes] = useState('');
  const [loading, setLoading] = useState(false);

  // Toggle Selesai Materi
  const handleToggleMaterial = async (materialId) => {
    setLoading(true);
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
        // Update local state React secara instan
        setSession((prev) => ({
          ...prev,
          materials: prev.materials.map((m) =>
            m.id === materialId ? { ...m, is_completed: data.is_completed } : m
          ),
        }));
        if (activeMaterial?.id === materialId) {
          setActiveMaterial((prev) => ({ ...prev, is_completed: data.is_completed }));
        }
      }
    } catch (err) {
      alert('Gagal memperbarui status materi.');
    } finally {
      setLoading(false);
    }
  };

  // Submit Upload Tugas
  const handleSubmitAssignment = async (e, assignmentId) => {
    e.preventDefault();
    if (!selectedFile) return alert('Silakan pilih berkas tugas terlebih dahulu.');

    const formData = new FormData();
    formData.append('file', selectedFile);
    formData.append('notes', taskNotes);
    formData.append('course_session_id', session.id);

    setLoading(true);
    try {
      const res = await fetch(`/api/student/assignments/${assignmentId}/submit`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData,
      });
      const data = await res.json();

      if (data.success) {
        alert('Tugas berhasil dikirim!');
        setSelectedFile(null);
        setTaskNotes('');
        // Refresh local assignment state
        setSession((prev) => ({
          ...prev,
          assignments: prev.assignments.map((a) =>
            a.id === assignmentId ? { ...a, submission: data.submission } : a
          ),
        }));
      }
    } catch (err) {
      alert('Gagal mengunggah tugas.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="bg-slate-50 dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-6">
      
      {/* Header Sesi */}
      <div className="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
          <h1 className="text-2xl font-extrabold text-[#141A45] dark:text-white">{session.title}</h1>
          <p className="text-sm text-slate-500 mt-1">
            {session.materials.length} Materi • {session.assignments.length} Tugas
          </p>
        </div>
        {session.is_completed && (
          <span className="px-4 py-1.5 bg-emerald-100 text-emerald-800 font-bold text-xs rounded-full border border-emerald-300">
            ✓ Sesi Selesai 100%
          </span>
        )}
      </div>

      {/* Navigation Tabs */}
      <div className="flex gap-3">
        <button
          onClick={() => setActiveTab('materials')}
          className={`px-5 py-2.5 rounded-xl text-sm font-bold transition-all ${
            activeTab === 'materials'
              ? 'bg-[#141A45] text-white shadow-md'
              : 'bg-white text-slate-600 border hover:bg-slate-100'
          }`}
        >
          📚 Materi ({session.materials.filter((m) => m.is_completed).length}/{session.materials.length})
        </button>
        {session.assignments.length > 0 && (
          <button
            onClick={() => setActiveTab('assignments')}
            className={`px-5 py-2.5 rounded-xl text-sm font-bold transition-all ${
              activeTab === 'assignments'
                ? 'bg-[#7C170D] text-white shadow-md'
                : 'bg-white text-slate-600 border hover:bg-slate-100'
            }`}
          >
            📝 Tugas ({session.assignments.filter((a) => a.submission).length}/{session.assignments.length})
          </button>
        )}
      </div>

      {/* CONTENT TAB: MATERI */}
      {activeTab === 'materials' && (
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Main Viewer */}
          <div className="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-4">
            {activeMaterial ? (
              <>
                <h2 className="text-xl font-bold text-[#141A45] dark:text-white">{activeMaterial.title}</h2>
                <div className="prose max-w-none text-slate-700 dark:text-slate-300">
                  {activeMaterial.body_text || activeMaterial.content}
                </div>

                <div className="pt-6 border-t flex justify-end">
                  <button
                    onClick={() => handleToggleMaterial(activeMaterial.id)}
                    disabled={loading}
                    className={`px-6 py-3 rounded-xl font-bold text-sm transition-all ${
                      activeMaterial.is_completed
                        ? 'bg-emerald-600 text-white hover:bg-emerald-700'
                        : 'bg-[#7C170D] text-white hover:bg-[#63120A]'
                    }`}
                  >
                    {activeMaterial.is_completed ? '✓ Sudah Dipelajari (Klik untuk Batal)' : 'Tandai Sudah Dipelajari'}
                  </button>
                </div>
              </>
            ) : (
              <p className="text-slate-400 text-center py-10">Pilih materi untuk mulai belajar.</p>
            )}
          </div>

          {/* List Sidebar */}
          <div className="space-y-2">
            {session.materials.map((m, idx) => (
              <button
                key={m.id}
                onClick={() => setActiveMaterial(m)}
                className={`w-full p-4 rounded-xl border text-left flex items-center justify-between transition-all ${
                  activeMaterial?.id === m.id
                    ? 'border-[#141A45] bg-[#ECE1D5]/40 font-bold'
                    : 'bg-white border-slate-200 hover:bg-slate-50'
                }`}
              >
                <div className="flex items-center gap-3">
                  <span
                    className={`w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold ${
                      m.is_completed ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-700'
                    }`}
                  >
                    {m.is_completed ? '✓' : idx + 1}
                  </span>
                  <span className="text-sm text-[#141A45]">{m.title}</span>
                </div>
              </button>
            ))}
          </div>
        </div>
      )}

      {/* CONTENT TAB: PENUGASAN (ASSIGNMENTS) */}
      {activeTab === 'assignments' && (
        <div className="space-y-6">
          {session.assignments.map((assignment) => (
            <div key={assignment.id} className="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-4">
              <div className="flex justify-between items-start">
                <div>
                  <h3 className="text-lg font-bold text-[#141A45] dark:text-white">{assignment.title}</h3>
                  <p className="text-sm text-slate-500 mt-1">{assignment.description}</p>
                </div>
                <div className="text-right">
                  <span className="text-xs bg-slate-100 text-slate-700 px-3 py-1 rounded-full font-semibold">
                    Batas: {assignment.due_date || 'Tidak ada deadline'}
                  </span>
                </div>
              </div>

              {/* Status Pengumpulan */}
              {assignment.submission ? (
                <div className="bg-emerald-50 border border-emerald-200 p-4 rounded-xl text-emerald-900 space-y-2">
                  <div className="flex items-center gap-2 font-bold text-sm">
                    <span>✓ Berkas Tugas Telah Dikirim</span>
                  </div>
                  <p className="text-xs text-emerald-700">Waktu Kirim: {assignment.submission.submitted_at}</p>
                  {assignment.submission.grade !== null && (
                    <div className="mt-2 pt-2 border-t border-emerald-200 font-bold text-sm">
                      Nilai: {assignment.submission.grade} / {assignment.max_score}
                      {assignment.submission.feedback && (
                        <p className="text-xs font-normal text-emerald-800 mt-1">Catatan Pengajar: {assignment.submission.feedback}</p>
                      )}
                    </div>
                  )}
                </div>
              ) : (
                <form onSubmit={(e) => handleSubmitAssignment(e, assignment.id)} className="space-y-4 pt-2">
                  <div>
                    <label className="block text-sm font-semibold text-[#141A45] mb-1">Unggah File Tugas</label>
                    <input
                      type="file"
                      onChange={(e) => setSelectedFile(e.target.files[0])}
                      required
                      className="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-[#141A45] file:text-white file:font-semibold hover:file:bg-[#0E1333]"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-semibold text-[#141A45] mb-1">Catatan Tambahan</label>
                    <textarea
                      value={taskNotes}
                      onChange={(e) => setTaskNotes(e.target.value)}
                      rows={2}
                      className="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-[#141A45] outline-none"
                      placeholder="Tambahkan catatan untuk dosen/pengajar (opsional)..."
                    />
                  </div>
                  <button
                    type="submit"
                    disabled={loading}
                    className="bg-[#7C170D] text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-[#63120A] transition-all"
                  >
                    Kirimkan Tugas
                  </button>
                </form>
              )}
            </div>
          ))}
        </div>
      )}
    </div>
  );
}