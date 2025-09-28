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

    // DEBUG: Check CSRF token
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;
    
    console.log('CSRF Token found:', csrfToken ? 'Yes' : 'No');
    console.log('CSRF Token value:', csrfToken);

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

    // Simplified function dengan lebih banyak debugging
    async function processCourses(action, courseCodes, totalSKS) {
        console.log('=== DEBUG PROCESS COURSES ===');
        console.log('Action:', action);
        console.log('Course Codes:', courseCodes);
        console.log('Total SKS:', totalSKS);
        
        if (courseCodes.length === 0) {
            console.log('No courses selected');
            return;
        }

        const button = action === 'enroll' ? enrollBtn : dropBtn;
        const originalText = button.innerHTML;
        
        // Loading state
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
        button.disabled = true;

        // Prepare data
        const requestData = {
            action: action,
            courses: courseCodes,
            total_sks: totalSKS
        };
        
        console.log('Request data:', requestData);

        try {
            // Menggunakan FormData sebagai fallback
            const formData = new FormData();
            formData.append('action', action);
            formData.append('courses', JSON.stringify(courseCodes));
            formData.append('total_sks', totalSKS);
            
            // Add CSRF token if available
            if (csrfToken) {
                formData.append('csrf_test_name', csrfToken);
            }

            console.log('Sending request to:', window.location.origin + '/student/enrollMultiple');

            // try method 1:  JSON
            let response = await fetch('/student/enrollMultiple', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    ...(csrfToken && {'X-CSRF-TOKEN': csrfToken})
                },
                body: JSON.stringify(requestData)
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);

            // If JSON fails, try FormData
            if (!response.ok) {
                console.log('JSON method failed, trying FormData...');
                response = await fetch('/student/enrollMultiple', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(csrfToken && {'X-CSRF-TOKEN': csrfToken})
                    },
                    body: formData
                });
            }

            const responseText = await response.text();
            console.log('Raw response:', responseText);
            
            let data;
            try {
                data = JSON.parse(responseText);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                throw new Error('Invalid JSON response: ' + responseText);
            }

            console.log('Parsed response:', data);

            if (data.success) {
                alert(`${data.message}`);
                updateUIAfterSuccess(action, courseCodes);
            } else {
                alert(`Error: ${data.message}`);
            }

        } catch (error) {
            console.error('=== FETCH ERROR ===');
            console.error('Error details:', error);
            console.error('Error message:', error.message);
            console.error('Error stack:', error.stack);
            alert(`🔗 Terjadi kesalahan: ${error.message}`);
        } finally {
            button.innerHTML = originalText;
            button.disabled = false;
            updateSummary();
        }
    }

    // Update UI after success
    function updateUIAfterSuccess(action, courseCodes) {
        courseCodes.forEach(courseCode => {
            const checkbox = document.querySelector(`input[value="${courseCode}"]`);
            if (checkbox) {
                const row = checkbox.closest('tr');
                const statusCell = row.querySelector('td:last-child');
                
                if (action === 'enroll') {
                    checkbox.dataset.enrolled = '1';
                    statusCell.innerHTML = '<span class="badge badge-success">Sudah Diambil</span>';
                } else if (action === 'drop') {
                    checkbox.dataset.enrolled = '0';
                    statusCell.innerHTML = '<span class="badge badge-secondary">Belum Diambil</span>';
                }
                
                checkbox.checked = false;
            }
        });
        
        if (selectAll) selectAll.checked = false;
        updateSummary();
    }

    // --- EVENT LISTENERS ---
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
    
    // Initial call
    updateSummary();
    
    // DEBUG: Log when script is loaded
    console.log('Courses.js loaded successfully');
    console.log('Found checkboxes:', checkboxes.length);
    console.log('Found buttons:', {
        enroll: !!enrollBtn,
        drop: !!dropBtn,
        reset: !!resetBtn
    });
});