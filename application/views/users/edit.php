<?php
// Pastikan variabel $user dikirim dari controller sebelum view ini dipanggil
$this->load->view('partials/header');

// Set mode dan form_action untuk digunakan di form.php
$mode = 'edit';
$form_action = site_url('users/update/' . $user->id);

// Kirim variabel ke view form
$this->load->view('users/form', [
    'mode' => $mode,
    'form_action' => $form_action,
    'user' => $user
]);

$this->load->view('partials/footer');
