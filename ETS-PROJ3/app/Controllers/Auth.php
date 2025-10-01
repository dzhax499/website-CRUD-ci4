namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController {
    public function login() {
        return view('auth/login');
    }

    public function doLogin() {
        $userModel = new UserModel();
        $user = $userModel->where('username', $this->request->getPost('username'))->first();

        if($user && password_verify($this->request->getPost('password'), $user['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'userId'     => $user['id'],
                'role'       => $user['role'],
                'nama'       => $user['nama']
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid login');
        }
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}
