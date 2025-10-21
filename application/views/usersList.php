<!--
File: application/views/users/index.php
Description: Daftar user (list)
-->
<?php $this->load->view('partials/header'); ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar User</h3>
    <a href="<?= site_url('users/create') ?>" class="btn btn-primary">Tambah User</a>
  </div>


  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Peran</th>
        <th>Terdaftar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($users)) : $i=1 + (isset($start) ? $start : 0); foreach($users as $u): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= html_escape($u->nama) ?></td>
          <td><?= html_escape($u->email) ?></td>
          <td><?= html_escape($u->role) ?></td>
          <td><?= date('Y-m-d', strtotime($u->created_at)) ?></td>
          <td>
            <a href="<?= site_url('users/view/'.$u->id) ?>" class="btn btn-sm btn-info">Lihat</a>
            <a href="<?= site_url('users/edit/'.$u->id) ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="#" onclick="if(confirm('Hapus user ini?')) window.location='<?= site_url('users/delete/'.$u->id) ?>'" class="btn btn-sm btn-danger">Hapus</a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center">Belum ada data user</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <?php if (isset($pagination)) echo $pagination; ?>
</div>
<?php $this->load->view('partials/footer'); ?>


<!--
File: application/views/users/form.php
Description: Partial form dipakai untuk create & edit
-->
<?php // $mode = 'create' or 'edit'; $user = (object) array or null ?>
<div class="container mt-4">
  <h3><?= ($mode==='edit') ? 'Edit User' : 'Tambah User' ?></h3>

  <?= validation_errors('<div class="alert alert-danger">','</div>') ?>

  <?= form_open($form_action) ?>

  <div class="form-group">
    <?= form_label('Nama', 'name') ?>
    <?= form_input(['name'=>'name','id'=>'name','class'=>'form-control','value'=>set_value('name', isset($user->name)?$user->name:'' )]) ?>
  </div>

  <div class="form-group">
    <?= form_label('Email', 'email') ?>
    <?= form_input(['name'=>'email','id'=>'email','class'=>'form-control','value'=>set_value('email', isset($user->email)?$user->email:'' )]) ?>
  </div>

  <?php if ($mode === 'create'): ?>
  <div class="form-group">
    <?= form_label('Password', 'password') ?>
    <?= form_password(['name'=>'password','id'=>'password','class'=>'form-control']) ?>
  </div>
  <?php endif; ?>

  <div class="form-group">
    <?= form_label('Role', 'role') ?>
    <?= form_dropdown('role', ['admin'=>'Admin','user'=>'User'], set_value('role', isset($user->role)?$user->role:'user'), ['class'=>'form-control','id'=>'role']) ?>
  </div>

  <button class="btn btn-success" type="submit"><?= ($mode==='edit') ? 'Simpan Perubahan' : 'Buat User' ?></button>
  <a href="<?= site_url('users') ?>" class="btn btn-secondary">Batal</a>

  <?= form_close() ?>
</div>


<!--
File: application/views/users/create.php
-->
<?php
$mode = 'create';
$form_action = 'users/create';
$this->load->view('users/form');
?>


<!--
File: application/views/users/edit.php
-->
<?php
$mode = 'edit';
$form_action = 'users/edit/'.$user->id;
$this->load->view('users/form');
?>


<!--
File: application/views/users/view.php
Description: Lihat detail user
-->
<?php $this->load->view('partials/header'); ?>
<div class="container mt-4">
  <h3>Detail User</h3>
  <table class="table table-bordered">
    <tr><th>ID</th><td><?= html_escape($user->id) ?></td></tr>
    <tr><th>Nama</th><td><?= html_escape($user->name) ?></td></tr>
    <tr><th>Email</th><td><?= html_escape($user->email) ?></td></tr>
    <tr><th>Role</th><td><?= html_escape($user->role) ?></td></tr>
    <tr><th>Terdaftar</th><td><?= date('Y-m-d H:i', strtotime($user->created_at)) ?></td></tr>
  </table>
  <a href="<?= site_url('users/edit/'.$user->id) ?>" class="btn btn-warning">Edit</a>
  <a href="<?= site_url('users') ?>" class="btn btn-secondary">Kembali</a>
</div>
<?php $this->load->view('partials/footer'); ?>


<!--
File: application/views/partials/header.php
Simple header dengan Bootstrap CDN
-->
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="<?= site_url() ?>">Aplikasi</a>
    </nav>


<!--
File: application/views/partials/footer.php
-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>


<!--