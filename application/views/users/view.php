// application/views/users/view.php
<?php $this->load->view('partials/header'); ?>
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
<?php $this->load->view('partials/footer'); ?>
