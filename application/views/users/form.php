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
