<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\Token;
use App\models\User;
use Exception;

class SigninController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render('signin/index');
    }

    public function signin()
    {

        $email = $this->post('email');
        $password = $this->post('password');

        if (!$email || !$password)
            return $this->response(['message' => 'El usuario y contraseña son requeridos'], 400);

        $user = User::findByEmail($email);

        if (!$user || !$user->verifyPassword($password, $user->password) || !$user->status)
            return $this->response(['message' => 'El usuario o contraseña no son validos'], 400);

        $response = $this::generateJWT($user);
        return $this->response($response);
    }

    public function user()
    {
            $session = $_SERVER['HTTP_SESSION'] ?? '';
            if (!$session) return $this->response(['message' => "unauthorized - 401"], 401);
            $session = $this::isValidToken($session);
            if ($session instanceof Exception) return $this->response(['message' => $session->getMessage()], 401);
            $this->response($session);
    }

    public function recoverPassword()
    {
        $email = $this->post('email');
        if (!$email) return $this->response(['message' => 'El usuario y contraseña son requeridos'], 400);
        $user = User::findByEmail($email);
        if (!$user || !$user->status) return $this->response(['message' => 'El usuario o contraseña no son validos'], 400);


        $key = $this->generateToken($email);
        $expiration_date = $this->getExpitarionToken();
        $token = Token::where("email = '$email'");

        if ($token) $token->delete($token->id);

        $token = new Token;
        if (!$token->save($key, $email, $expiration_date)) return $this->response(['message', 'Parece que hubo un error - Intenta mas tarde'], 500);

        $url = $this->getUrlToResetPassword($key, $email);
        ob_start();
        $this->render('mails/forgot-password', ['url' => $url]);
        $mail = ob_get_clean();
        $this->sendMail('Restablecimiento de contraseña', $email, $mail);
        $this->response(['message' => 'Hemos enviado un correo electronico con las instrucciones para restablecer tu contraseña']);
    }

    public function getPasswordToken()
    {
        $key = $this->get('key');
        $email = $this->get('email');

        if (empty($email) || empty($key)) return $this->response(['message' => 'Token no es valido'], 403);

        $token = Token::where("token = '$key' AND email = '$email'");

        if (!$token || $token->expiration_date < date("Y-m-d H:i:s", strtotime('now'))) return $this->response(['message' => 'El token no es valido o ha expirado'], 403);

        $this->response(['token' => $token]);
    }

    public function changePassword()
    {
        $key = $this->post('key');
        $email = $this->post('email');

        if (empty($email) || empty($key)) return $this->response(['message' => 'El token no es valido o ha expirado'], 403);

        $token = Token::where("token = '$key' AND email = '$email'");
        if (!$token || $token->expiration_date < date("Y-m-d H:i:s", strtotime('now'))) return $this->response(['message' => 'El token no es valido o ha expirado'], 403);

        $password = $this->post('password');
        $confirm_password = $this->post('confirm_password');



        if ($password != $confirm_password) return $this->response(['message' => 'Las contraselas no coinciden, por favor verificalas'], 400);
        $user = User::findByEmail($email);
        if (!$user || !$user->status) return $this->response(['message' => 'El correo electronico no es valido'], 400);

        $token->delete($token->id);
        $user->UpdateOne($user->id, ['password' => $password]);
        $this->response(['message' => 'La contraseña ha sido restablecida correctamente']);
    }

    private function generateToken(string $email)
    {
        $key = md5((2418 * 2) . $email);
        $add_key = substr(md5(uniqid(rand(), 1)), 3, 10);
        return  $key . $add_key;
    }

    private function getExpitarionToken()
    {
        return date("Y-m-d H:i:s", strtotime('now') + 300);
    }

    private function getUrlToResetPassword(string $key, string $email)
    {
        return "http://" . $_SERVER['HTTP_HOST'] . "/reset-password?key=$key&email=$email";
    }
}
