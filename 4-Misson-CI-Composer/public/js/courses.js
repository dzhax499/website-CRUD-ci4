document.addEventListener("DOMContentLoaded", () => {
    // Ambil semua elemen yang dibutuhkan
    const checkboxes = document.querySelectorAll(".course-checkbox");
    const selectAll = document.getElementById("select-all");
    
    // Elemen Summary
    const enrollSksEl = document.getElementById("enroll-sks");
    const enrollCoursesCountEl = document.getElementById("enroll-courses-count");
    const enrollCoursesListEl = document.getElementById("enroll-courses-list");
    const dropSksEl = document.getElementById("drop-sks");
    const dropCoursesCountEl = document.getElementById("drop-courses-count");
    const dropCoursesListEl = document.getElementById("drop-courses-list");
    
    // Tombol Aksi
    const enrollBtn = document.getElementById("submit-enrollment");
    const dropBtn = document.getElementById("submit-drop");
    const resetBtn = document.getElementById("reset-selection");

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const csrfHeader = 'X-CSRF-TOKEN';

    function updateSummary() {
        let enrollSks = 0;
        let dropSks = 0;
        let enrollCourses = [];
        let dropCourses = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                const sks = parseInt(cb.dataset.sks) || 0;
                const isEnrolled = cb.dataset.enrolled === '1';
                const courseInfo = {
                    code: cb.value,
                    name: cb.dataset.name,
                    sks: sks
                };

                if (isEnrolled) {
                    // Jika sudah diambil, berarti akan di-DROP
                    dropSks += sks;
                    dropCourses.push(courseInfo);
                } else {
                    // Jika belum, berarti akan di-ENROLL
                    enrollSks += sks;
                    enrollCourses.push(courseInfo);
                }
            }
        });

        // --- UPDATE TAMPILAN SUMMARY ---
        enrollSksEl.textContent = enrollSks;
        enrollCoursesCountEl.textContent = enrollCourses.length;
        
        if (enrollCourses.length > 0) {
            enrollCoursesListEl.innerHTML = enrollCourses.map(c => `<span class="badge badge-primary">${c.name} (${c.sks} SKS)</span>`).join(' ');
        } else {
            enrollCoursesListEl.innerHTML = '<span class="text-muted small">Belum ada mata kuliah dipilih untuk enroll</span>';
        }

        dropSksEl.textContent = dropSks;
        dropCoursesCountEl.textContent = dropCourses.length;

        if (dropCourses.length > 0) {
            dropCoursesListEl.innerHTML = dropCourses.map(c => `<span class="badge badge-danger">${c.name} (${c.sks} SKS)</span>`).join(' ');
        } else {
            dropCoursesListEl.innerHTML = '<span class="text-muted small">Belum ada mata kuliah dipilih untuk drop</span>';
        }

        // --- UPDATE STATUS TOMBOL ---
        enrollBtn.disabled = enrollCourses.length === 0;
        dropBtn.disabled = dropCourses.length === 0;
    }

    // MODIFIKASI: Mengganti processTransactions dengan processCourses yang langsung ke enrollMultiple
    // Fungsi ini menangani AJAX tanpa refresh halaman
    async function processCourses(action, courseCodes, totalSKS) {
        if (courseCodes.length === 0) return;

        const button = action === 'enroll' ? enrollBtn : dropBtn;
        const originalText = button.innerHTML;
        
        // TAMBAHAN: Loading state untuk UX yang lebih baik
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
        button.disabled = true;

        try {
            // PERBAIKAN: Menambahkan beberapa fallback untuk CSRF
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };
            
            // Coba berbagai cara untuk mengirim CSRF token
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
                headers['X-Requested-With'] = 'XMLHttpRequest'; // Menandai sebagai AJAX request
            }
            
            // MODIFIKASI: Menggunakan endpoint enrollMultiple dengan parameter action
            const response = await fetch('/student/enrollMultiple', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    action: action,  // TAMBAHAN: Mengirim action (enroll/drop)
                    courses: courseCodes,
                    total_sks: totalSKS
                }),
            });

            const data = await response.json();

            if (data.success) {
                // MODIFIKASI: Menggunakan alert yang lebih informatif
                alert(`✅ ${data.message}`);
                
                // TAMBAHAN: Update UI secara real-time tanpa refresh
                updateUIAfterSuccess(action, courseCodes);
            } else {
                alert(`❌ Error: ${data.message}`);
            }

        } catch (error) {
            console.error('Fetch Error:', error);
            alert('🔗 Terjadi kesalahan jaringan. Silakan coba lagi.');
        } finally {
            // PERBAIKAN: Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
            updateSummary(); // Update status tombol
        }
    }

    // TAMBAHAN: Fungsi untuk update UI setelah sukses tanpa refresh halaman
    function updateUIAfterSuccess(action, courseCodes) {
        courseCodes.forEach(courseCode => {
            const checkbox = document.querySelector(`input[value="${courseCode}"]`);
            if (checkbox) {
                const row = checkbox.closest('tr');
                const statusCell = row.querySelector('td:last-child');
                
                if (action === 'enroll') {
                    // Update dari "Belum Diambil" ke "Sudah Diambil"
                    checkbox.dataset.enrolled = '1';
                    statusCell.innerHTML = '<span class="badge badge-success">Sudah Diambil</span>';
                } else if (action === 'drop') {
                    // Update dari "Sudah Diambil" ke "Belum Diambil"
                    checkbox.dataset.enrolled = '0';
                    statusCell.innerHTML = '<span class="badge badge-secondary">Belum Diambil</span>';
                }
                
                // Uncheck checkbox setelah proses selesai
                checkbox.checked = false;
            }
        });
        
        // Reset select all jika ada
        if (selectAll) selectAll.checked = false;
        
        // Update summary
        updateSummary();
    }

    // --- EVENT LISTENERS (tidak berubah) ---
    checkboxes.forEach(cb => cb.addEventListener("change", updateSummary));
    
    if (selectAll) {
        selectAll.addEventListener("change", function () {
            checkboxes.forEach(cb => (cb.checked = this.checked));
            updateSummary();
        });
    }

    if (enrollBtn) {
        enrollBtn.addEventListener("click", () => {
            const coursesToEnroll = Array.from(checkboxes)
                .filter(cb => cb.checked && cb.dataset.enrolled === '0')
                .map(cb => cb.value);
            
            // MODIFIKASI: Menambahkan perhitungan total SKS untuk enroll
            const totalSKS = Array.from(checkboxes)
                .filter(cb => cb.checked && cb.dataset.enrolled === '0')
                .reduce((total, cb) => total + parseInt(cb.dataset.sks || 0), 0);
                
            processCourses('enroll', coursesToEnroll, totalSKS);
        });
    }

    if (dropBtn) {
        dropBtn.addEventListener("click", () => {
            const coursesToDrop = Array.from(checkboxes)
                .filter(cb => cb.checked && cb.dataset.enrolled === '1')
                .map(cb => cb.value);
            
            // TAMBAHAN: Menambahkan perhitungan total SKS untuk drop
            const totalSKS = Array.from(checkboxes)
                .filter(cb => cb.checked && cb.dataset.enrolled === '1')
                .reduce((total, cb) => total + parseInt(cb.dataset.sks || 0), 0);
                
            processCourses('drop', coursesToDrop, totalSKS);
        });
    }
    
    if (resetBtn) {
        resetBtn.addEventListener("click", () => {
            checkboxes.forEach(cb => (cb.checked = false));
            if (selectAll) selectAll.checked = false;
            updateSummary();
        });
    }
    
    // Panggil sekali saat halaman dimuat
    updateSummary();
});