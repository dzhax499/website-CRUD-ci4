<!-- App/Views/home/v_home.php -->
<div class="welcome-section">
    <h2>Selamat Datang di Sistem Akademik</h2>
    <p>Sistem informasi untuk mengelola data mahasiswa dan akademik.</p>

    <div class="features">
        <div class="feature-card">
            <h4>Data Mahasiswa</h4>
            <p>Kelola data mahasiswa dengan mudah</p>
            <a href="<?= base_url('mahasiswa') ?>" class="btn">Lihat Data</a>
        </div>

        <div class="feature-card">
            <h4>Manajemen User</h4>
            <p>Sistem login dan manajemen pengguna</p>
            <a href="<?= base_url('auth/login') ?>" class="btn">Login</a>
        </div>
    </div>
</div>

<style>
    .welcome-section {
        text-align: center;
        padding: 20px;
    }

    .features {
        display: flex;
        justify-content: space-around;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .feature-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin: 10px;
        min-width: 250px;
        max-width: 300px;
    }

    .btn {
        background: #007bff;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        display: inline-block;
        margin-top: 10px;
    }

    .btn:hover {
        background: #0056b3;
    }
</style>