<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel'); // Pastikan nama file dan class model-nya UserModel
        $this->load->helper(['jwt', 'url']);
        $this->output->set_content_type('application/json');
    }

    public function login() {
        $data = json_decode($this->input->raw_input_stream, true);
        if (empty($data['email']) || empty($data['password'])) {
            return $this->_response(['error' => 'Email dan password wajib diisi'], 400);
        }

        $user = $this->UserModel->get_user_by_email($data['email']);

        if ($user && password_verify($data['password'], $user->password)) {
            $token = generate_jwt(['id' => $user->id, 'email' => $user->email]);
            return $this->_response(['token' => $token]);
        } else {
            return $this->_response(['error' => 'Email atau password salah'], 401);
        }
    }

    public function create() {
        $auth = $this->_authorize();
        if (!$auth) return;

        $data = json_decode($this->input->raw_input_stream, true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->_response(['error' => 'Email dan password wajib diisi'], 400);
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->UserModel->insert($data);

        return $this->_response(['message' => 'User berhasil dibuat']);
    }

    // ====================== READ ALL ==========================
    public function index() {
        $auth = $this->_authorize();
        if (!$auth) return;

        $users = $this->UserModel->get_all();
        return $this->_response($users);
    }

    // ====================== READ ONE ==========================
    public function show($id = null) {
        $auth = $this->_authorize();
        if (!$auth) return;

        if (!$id) return $this->_response(['error' => 'ID tidak diberikan'], 400);

        $user = $this->UserModel->get($id);
        if ($user) {
            return $this->_response($user);
        } else {
            return $this->_response(['error' => 'User tidak ditemukan'], 404);
        }
    }

    // ====================== UPDATE ==========================
    public function update($id = null) {
        $auth = $this->_authorize();
        if (!$auth) return;

        if (!$id) return $this->_response(['error' => 'ID tidak diberikan'], 400);

        $data = json_decode($this->input->raw_input_stream, true);
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $this->UserModel->update($id, $data);
        return $this->_response(['message' => 'User berhasil diupdate']);
    }

    // ====================== DELETE ==========================
    public function delete($id = null) {
        $auth = $this->_authorize();
        if (!$auth) return;

        if (!$id) return $this->_response(['error' => 'ID tidak diberikan'], 400);

        $this->UserModel->delete($id);
        return $this->_response(['message' => 'User berhasil dihapus']);
    }

    // ====================== JWT VALIDATION ==========================
    private function _authorize() {
        $authHeader = $this->input->get_request_header('Authorization');
        if (!$authHeader) {
            return $this->_response(['error' => 'Token tidak ditemukan'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);
        $decoded = verify_jwt($token);

        if (!$decoded) {
            return $this->_response(['error' => 'Token tidak valid atau expired'], 401);
        }

        return $decoded;
    }

    // private function _authorize()array {
    //     $authHeader = $this->input->get_request_header('Authorization');
    //     if (!$authHeader)
    // }

    // ====================== Response Helper ==========================
    private function _response($data, $code = 200) {
        $this->output
            ->set_status_header($code)
            ->set_output(json_encode($data));
    }
}
