// Scope, Array, Object
// Data Mahasiswa
const students = [
  { id: 1, name: 'Dzakir Tsabit', nim: '241511071' },
  { id: 2, name: 'John Doe', nim: '241511072' }
];

// Data Mata Kuliah
const courses_manual = [
  { id: 1, name: 'Pemrograman Web', sks: 3 },
  { id: 2, name: 'Basis Data', sks: 3 },
  { id: 3, name: 'Struktur Data', sks: 2 }
];

//  DOM Selector & Manipulation

document.addEventListener('DOMContentLoaded', () => {
  // 1. Memilih elemen kontainer di HTML
  const courseList = document.getElementById('course-list');

   // 2. Looping data mata kuliah dari array courses
  const totalSks = document.getElementById('total-sks');

  // Event Handling
  const enrollForm = document.getElementById('enroll-form');
  const courseCheckboxes = document.querySelectorAll('input[name="courses"]');

  // Menghitung total SKS
  const updateTotalSks = () => {
    let total = 0;
    courseCheckboxes.forEach(checkbox => {
      if (checkbox.checked) {
        total += parseInt(checkbox.dataset.sks);
      }
    });
    if (totalSks) {
        totalSks.textContent = total;
    }
  };

  courseCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateTotalSks);
  });

  // Validasi form
  if (enrollForm) {
      enrollForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const selectedCourses = [];
        courseCheckboxes.forEach(checkbox => {
          if (checkbox.checked) {
            selectedCourses.push(parseInt(checkbox.value));
          }
        });

        if (selectedCourses.length === 0) {
          alert('Silakan pilih mata kuliah terlebih dahulu.');
          return;
        }

        // Cek double enroll
        const studentId = 1; // Contoh
        const hasEnrolled = selectedCourses.some(courseId => {
            return enrollments.some(enroll => enroll.studentId === studentId && enroll.courseId === courseId);
        });

        if (hasEnrolled) {
            alert('Anda sudah terdaftar di salah satu mata kuliah yang dipilih.');
            return; 
        }


        // Simpan data
        selectedCourses.forEach(courseId => {
          enrollments.push({ studentId: studentId, courseId: courseId });
        });

        alert('Pendaftaran berhasil!');
        enrollForm.reset();
        updateTotalSks();
        console.log(enrollments);
      });
  }

  // Common Use Cases
  // Menu aktif
    const navLinks = document.querySelectorAll('.nav-link');
    const currentUrl = window.location.href;

    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
        }
    });

    // Validasi form dengan border merah
    const validateInput = (input) => {
        if (input.value.trim() === '') {
            input.classList.add('is-invalid');
            return false;
        } else {
            input.classList.remove('is-invalid');
            return true;
        }
    };

    const studentForm = document.getElementById('student-form');
    if (studentForm) {
        studentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const nameInput = document.getElementById('student-name');
            if (validateInput(nameInput)) {
                // Proses data
                alert('Data mahasiswa berhasil ditambahkan!');
                studentForm.reset();
            }
        });
    }


    // Konfirmasi hapus
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const courseName = e.target.dataset.courseName;
            const courseSks = e.target.dataset.courseSks;
            const confirmation = confirm(`Apakah Anda yakin ingin menghapus mata kuliah ${courseName} (${courseSks} SKS)?`);
            if (confirmation) {
                // Proses hapus
                alert('Mata kuliah berhasil dihapus!');
            }
        });
    });

    // SetTimeout (Async)
  console.log('Proses 1');
  setTimeout(() => {
    console.log('Proses 2 (setelah 2 detik)');
  }, 2000);
  console.log('Proses 3');
});



