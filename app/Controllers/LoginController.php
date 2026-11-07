<?php
namespace App\Controllers;
use App\Models\Login;
class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }
    public function loginProcess()
    {
        $model = model(Login::class);
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->findByEmail($email);

        // password_verify() against bcrypt hash; reject immediately if no user found
        if ($user && password_verify($password, $user->password)) {
            session()->set([
                'log'     => true,
                'user_id' => $user->id,
                'email'   => $user->email,
            ]);
            return redirect()->to('/');
        } else {
            return redirect()->to('/login');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}