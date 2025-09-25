<h2>Enroll Course</h2>
<form id="enroll-form">
    <div class="form-group">
        <label>Pilih Mata Kuliah:</label>
        <!-- JS akan mengisi daftar di sini -->
        <div id="course-list"></div>
    </div>
    <div class="mt-3">
        <strong>Total SKS: <span id="total-sks">0</span></strong>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>

<div class="card-header">
    <h3 class="card-title">Daftar Mata Kuliah yang Diambil</h3>
</div>
<div class="card-body">
    <?php if (!empty($enrolled_courses) && is_array($enrolled_courses)) : ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Semester</th>
                    <th>SKS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolled_courses as $course) : ?>
                    <tr>
                        <td><?= esc($course['nim']) ?></td>
                        <td><?= esc($course['nama_lengkap']) ?></td>
                        <td><?= esc($course['jurusan']) ?></td>
                        <td><?= esc($course['semester']) ?></td>
                        <td><?= json_decode($course['enrolled_courses'], true)['sks'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Anda belum terdaftar pada mata kuliah apa pun.</p>
    <?php endif; ?>
</div>