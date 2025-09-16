<?php
// App/Filters/Auth.php - FILTER UNTUK PROTEKSI HALAMAN
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Jika ada argument (role specific)
        if ($arguments) {
            $userRole = session()->get('role');

            // Cek role-based access
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/dashboard')->with('error', 'Akses tidak diizinkan!');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}
