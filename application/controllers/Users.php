<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    // 📋 Tampilkan daftar user
    public function index() {
        $data['users'] = $this->UserModel->get_all();
        $this->load->view('users/index', $data);
    }

    public function create() {
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('users/create');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role' => $this->input->post('role')
            ];
            $this->UserModel->insert($data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
            redirect('users');
        }
    }

    // ✏️ Form edit user
    public function edit($id) {
        $user = $this->UserModel->get($id);
        if (!$user) show_404();

        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $user;
            $this->load->view('users/edit', $data);
        } else {
            $updateData = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
            ];
            $this->UserModel->update($id, $updateData);
            $this->session->set_flashdata('success', 'User berhasil diupdate!');
            redirect('users');
        }
    }

    // 👁️ Lihat detail user
    public function view($id) {
        $user = $this->UserModel->get($id);
        if (!$user) show_404();

        $data['user'] = $user;
        $this->load->view('users/view', $data);
    }

    // ❌ Hapus user
    public function delete($id) {
        $user = $this->UserModel->get($id);
        if (!$user) show_404();

        $this->UserModel->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('users');
    }
}
