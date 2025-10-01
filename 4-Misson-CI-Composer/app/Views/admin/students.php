<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Mahasiswa</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" onclick="$('#addStudentModal').modal('show')">
                <i class="fas fa-plus"></i> Tambah Mahasiswa
            </button>
        </div>
    </div>
    <div class="card-body">
        <div id="alert-container"></div>

        <div class="table-responsive">
            <table id="studentsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="10%">NIM</th>
                        <th width="20%">Nama Lengkap</th>
                        <th width="15%">Username</th>
                        <th width="20%">Email</th>
                        <th width="15%">Jurusan</th>
                        <th width="8%" class="text-center">Semester</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                    <!-- Data will be loaded via AJAX -->
                    <tr>
                        <td colspan="7" class="text-center">
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add Student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i> Tambah Mahasiswa Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addStudentForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_nim">NIM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="add_nim" name="nim" placeholder="Contoh: 2101234567">
                                <small class="text-danger error-text" id="error_nim"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="add_nama_lengkap" name="nama_lengkap" placeholder="Nama lengkap">
                                <small class="text-danger error-text" id="error_nama_lengkap"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="add_username" name="username" placeholder="Username login">
                                <small class="text-danger error-text" id="error_username"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="add_email" name="email" placeholder="email@example.com">
                                <small class="text-danger error-text" id="error_email"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="add_password" name="password" placeholder="Minimal 6 karakter">
                                <small class="text-danger error-text" id="error_password"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_confirm_password">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="add_confirm_password" name="confirm_password" placeholder="Ulangi password">
                                <small class="text-danger error-text" id="error_confirm_password"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_jurusan">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-control" id="add_jurusan" name="jurusan">
                                    <option value="">-- Pilih Jurusan --</option>
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                    <option value="Teknik Elektro">Teknik Elektro</option>
                                    <option value="Teknik Mesin">Teknik Mesin</option>
                                    <option value="Teknik Sipil">Teknik Sipil</option>
                                    <option value="Manajemen">Manajemen</option>
                                    <option value="Akuntansi">Akuntansi</option>
                                </select>
                                <small class="text-danger error-text" id="error_jurusan"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_semester">Semester <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="add_semester" name="semester" min="1" max="14" placeholder="1-14">
                                <small class="text-danger error-text" id="error_semester"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSaveStudent">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Student -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Edit Data Mahasiswa
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editStudentForm">
                <input type="hidden" id="edit_nim" name="nim">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIM</label>
                                <input type="text" class="form-control" id="edit_nim_display" disabled>
                                <small class="form-text text-muted">NIM tidak dapat diubah</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap">
                                <small class="text-danger error-text" id="error_edit_nama_lengkap"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username" name="username">
                                <small class="text-danger error-text" id="error_edit_username"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email">
                                <small class="text-danger error-text" id="error_edit_email"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_password">Password Baru</label>
                                <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah">
                                <small class="text-danger error-text" id="error_edit_password"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_confirm_password">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
                                <small class="text-danger error-text" id="error_edit_confirm_password"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_jurusan">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_jurusan" name="jurusan">
                                    <option value="">-- Pilih Jurusan --</option>
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                    <option value="Teknik Elektro">Teknik Elektro</option>
                                    <option value="Teknik Mesin">Teknik Mesin</option>
                                    <option value="Teknik Sipil">Teknik Sipil</option>
                                    <option value="Manajemen">Manajemen</option>
                                    <option value="Akuntansi">Akuntansi</option>
                                </select>
                                <small class="text-danger error-text" id="error_edit_jurusan"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_semester">Semester <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_semester" name="semester" min="1" max="14">
                                <small class="text-danger error-text" id="error_edit_semester"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning" id="btnUpdateStudent">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus mahasiswa:</p>
                <p class="font-weight-bold" id="deleteStudentName"></p>
                <p class="text-danger">
                    <i class="fas fa-info-circle"></i>
                    Data mahasiswa akan dinonaktifkan dan tidak dapat diakses lagi.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        // Load students on page load
        loadStudents();

        // Add Student Form Submit
        $('#addStudentForm').submit(function(e) {
            e.preventDefault();
            clearErrors();

            const btn = $('#btnSaveStudent');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            $.ajax({
                url: '<?= base_url('admin/storeStudentAjax') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#addStudentModal').modal('hide');
                        $('#addStudentForm')[0].reset();
                        showAlert('success', response.message);
                        loadStudents();
                    } else {
                        if (response.errors) {
                            displayErrors(response.errors);
                        } else {
                            showAlert('danger', response.message);
                        }
                    }
                    btn.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    showAlert('danger', 'Terjadi kesalahan sistem');
                    btn.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                }
            });
        });
        // Edit Student Form Submit
        $('#editStudentForm').submit(function(e) {
            e.preventDefault();
            clearErrors('edit_');

            const nim = $('#edit_nim').val();
            const btn = $('#btnUpdateStudent');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengupdate...');

            $.ajax({
                url: '<?= base_url('admin/updateStudentAjax/') ?>' + nim,
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editStudentModal').modal('hide');
                        showAlert('success', response.message);
                        loadStudents();
                    } else {
                        if (response.errors) {
                            displayErrors(response.errors, 'edit_');
                        } else {
                            showAlert('danger', response.message);
                        }
                    }
                    btn.prop('disabled', false).html('<i class="fas fa-save"></i> Update');
                },
                error: function() {
                    showAlert('danger', 'Terjadi kesalahan sistem');
                },
            });
        });

        // Delete Confirmation
        let deleteNim = '';
        $(document).on('click', '.btn-delete', function() {
            deleteNim = $(this).data('nim');
            const nama = $(this).data('nama');
            $('#deleteStudentName').text(nama + ' (' + deleteNim + ')');
            $('#deleteModal').modal('show');
        });

        $('#btnConfirmDelete').click(function() {
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');

            $.ajax({
                url: '<?= base_url('admin/deleteStudentAjax/') ?>' + deleteNim,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    if (response.success) {
                        showAlert('success', response.message);
                        loadStudents();
                    } else {
                        showAlert('danger', response.message);
                    }
                },
                error: function() {
                    showAlert('danger', 'Terjadi kesalahan sistem');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-trash"></i> Hapus');
                }
            });
        });

        // Edit button click - load student data
        $(document).on('click', '.btn-edit', function() {
            const nim = $(this).data('nim');
            clearErrors('edit_');

            $.ajax({
                url: '<?= base_url('admin/getStudentAjax/') ?>' + nim,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const student = response.data;
                        $('#edit_nim').val(student.nim);
                        $('#edit_nim_display').val(student.nim);
                        $('#edit_nama_lengkap').val(student.nama_lengkap);
                        $('#edit_username').val(student.username);
                        $('#edit_email').val(student.email);
                        $('#edit_jurusan').val(student.jurusan);
                        $('#edit_semester').val(student.semester);
                        $('#edit_password').val('');
                        $('#edit_confirm_password').val('');
                        $('#editStudentModal').modal('show');
                    } else {
                        showAlert('danger', response.message);
                    }
                }
            });
        });

        // Reset form when modal is closed
        $('#addStudentModal').on('hidden.bs.modal', function() {
            $('#addStudentForm')[0].reset();
            clearErrors();
        });

        $('#editStudentModal').on('hidden.bs.modal', function() {
            clearErrors('edit_');
        });
    });

    // Load Students Function
    function loadStudents() {
        $.ajax({
            url: '<?= base_url('admin/getStudentsAjax') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderStudentsTable(response.data);
                } else {
                    $('#studentsTableBody').html('<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>');
                }
            },
            error: function() {
                $('#studentsTableBody').html('<tr><td colspan="7" class="text-center text-danger">Terjadi kesalahan sistem</td></tr>');
            }
        });
    }

    // Render Students Table
    function renderStudentsTable(students) {
        let html = '';

        if (students.length === 0) {
            html = '<tr><td colspan="7" class="text-center"><i class="fas fa-info-circle"></i> Tidak ada data mahasiswa</td></tr>';
        } else {
            students.forEach(function(student) {
                html += '<tr>';
                html += '<td>' + escapeHtml(student.nim) + '</td>';
                html += '<td>' + escapeHtml(student.nama_lengkap) + '</td>';
                html += '<td>' + escapeHtml(student.username) + '</td>';
                html += '<td>' + escapeHtml(student.email) + '</td>';
                html += '<td>' + escapeHtml(student.jurusan) + '</td>';
                html += '<td class="text-center">' + escapeHtml(student.semester) + '</td>';
                html += '<td class="text-center">';
                html += '<div class="btn-group" role="group">';
                html += '<a href="<?= base_url('admin/viewStudent/') ?>' + student.nim + '" class="btn btn-info btn-sm" title="Lihat Detail">';
                html += '<i class="fas fa-eye"></i>';
                html += '</a>';
                html += '<button type="button" class="btn btn-warning btn-sm btn-edit" data-nim="' + student.nim + '" title="Edit">';
                html += '<i class="fas fa-edit"></i>';
                html += '</button>';
                html += '<button type="button" class="btn btn-danger btn-sm btn-delete" data-nim="' + student.nim + '" data-nama="' + escapeHtml(student.nama_lengkap) + '" title="Hapus">';
                html += '<i class="fas fa-trash"></i>';
                html += '</button>';
                html += '</div>';
                html += '</td>';
                html += '</tr>';
            });
        }

        $('#studentsTableBody').html(html);
    }

    // Display Errors Function
    function displayErrors(errors, prefix = '') {
        for (let field in errors) {
            $('#error_' + prefix + field).text(errors[field]);
            $('#' + prefix + field).addClass('is-invalid');
        }
    }

    // Clear Errors Function
    function clearErrors(prefix = '') {
        $('.error-text').text('');
        $('input, select').removeClass('is-invalid');
    }

    // Show Alert Function
    function showAlert(type, message) {
        const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            ${message}
        </div>
    `;
        $('#alert-container').html(alertHtml);

        // Auto hide after 5 seconds
        setTimeout(function() {
            $('#alert-container .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);

        // Scroll to top
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');
    }

    // Escape HTML Function
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }
</script>

<style>
    .error-text {
        display: block;
        font-size: 0.875rem;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .btn-group .btn {
        margin: 0 2px;
    }
</style>