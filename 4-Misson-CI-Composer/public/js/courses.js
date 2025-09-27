// public/js/courses.js
document.addEventListener("DOMContentLoaded", () => {
    const checkboxes = document.querySelectorAll(".course-checkbox");
    const selectAll = document.getElementById("select-all");
    const totalSksEl = document.getElementById("total-sks");
    const totalCoursesEl = document.getElementById("total-courses");
    const selectedCoursesList = document.getElementById("selected-courses-list");
    const submitBtn = document.getElementById("submit-enrollment");

    function updateSummary() {
        let totalSks = 0;
        let selectedCourses = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                const sks = parseInt(cb.dataset.sks) || 0;
                totalSks += sks;
                selectedCourses.push({
                    code: cb.value,
                    name: cb.dataset.name,
                    sks: sks
                });
            }
        });

        totalSksEl.textContent = totalSks;
        totalCoursesEl.textContent = selectedCourses.length;

        if (selectedCourses.length > 0) {
            selectedCoursesList.innerHTML = selectedCourses
                .map(c => `<span class="badge bg-primary me-1">${c.code} (${c.sks} SKS)</span>`)
                .join(" ");
            submitBtn.disabled = false;
        } else {
            selectedCoursesList.innerHTML = "<span class='text-muted'>Belum ada mata kuliah dipilih</span>";
            submitBtn.disabled = true;
        }
    }

    checkboxes.forEach(cb => cb.addEventListener("change", updateSummary));

    if (selectAll) {
        selectAll.addEventListener("change", function () {
            checkboxes.forEach(cb => (cb.checked = this.checked));
            updateSummary();
        });
    }

    // Initial update
    updateSummary();
});
