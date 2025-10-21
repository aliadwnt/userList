<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->helper('jwt');
        $this->load->database();
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->UserModel->get_user_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            $token = generate_jwt(['id' => $user->id, 'email' => $user->email]);
            echo json_encode(['status' => true, 'token' => $token]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Login gagal']);
        }
    }
}
