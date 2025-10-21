<?php $this->load->view('partials/header'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Daftar User</h3>
  <a href="<?= site_url('users/create') ?>" class="btn btn-primary">Tambah User</a>
</div>

<?php if ($this->session->flashdata('message')): ?>
  <div class="alert alert-success"><?= $this->session->flashdata('message') ?></div>
<?php endif; ?>

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
        <td><?= html_escape($u->name) ?></td>
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

<?php $this->load->view('partials/footer'); ?>
