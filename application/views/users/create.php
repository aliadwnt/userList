<?php
$this->load->view('partials/header');

// Set variabel untuk form
$mode = 'create';
$form_action = site_url('users/create'); // gunakan 'store' atau 'create' sesuai method controllermu

// Kirim variabel ke form.php
$this->load->view('users/form', [
    'mode' => $mode,
    'form_action' => $form_action,
    'user' => null // belum ada data karena ini tambah user baru
]);

$this->load->view('partials/footer');
