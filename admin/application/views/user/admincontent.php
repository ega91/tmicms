<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>Belum ada pengguna.</h3>
    <a href="#" class="add-modal btn btn-primary btn-lg">Daftarkan Pengguna Baru</a>
	  </div>
  </div>
<?php else: ?>

  <div class="table-header">
    <div class="pull-right">
      <a href="#" class="page-prev btn btn-default" disabled="true"><i class="fa fa-chevron-left"></i></a>
      <a href="#" class="page-next btn btn-default" disabled="true"><i class="fa fa-chevron-right"></i></a>
      <a href="#" class="page-goto btn btn-default" disabled="true">Go To Page</a>
    </div>
    <a href="#" class="reload-table btn btn-default"><i class="fa fa-history"></i></a>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>User</th>
        <th>Role</th>
        <th>Terakhir Login</th>
        <th>Tanggal Daftar</th>
      </tr>
    </thead>
    <tbody>
      <tr><td colspan="4" class="td-add-new"><a href="#" class="add-modal btn btn-default btn-add-modal btn-block"><i class="fa fa-plus"></i> Tambah Admin Baru</a></td></tr>
      <?php foreach ($data as $key => $value) { ?>
        <tr>
          <td>
            <div class="book-info-container">
              <h3 class="td-title"><?php echo $value->full_name?></h3>
              <p><i class="fa fa-envelope-o"></i> <?=$value->email?>
              <?=(!empty($value->email_verified))?'<span class="email-verified"><i class="fa fa-check"></i></span>':''?></p>

              <div class="table-action-container">
                <a href="#" class="view-user" user-id="<?=$value->id?>"><i class="fa fa-eye"></i> View</a>
                <a href="#" class="edit-modal" data-source="<?=site_url('user/editadmin/'. $value->id)?>"><i class="fa fa-pencil"></i> Edit</a>
              </div>
            </div>
          </td>
          <td>
            <?php if (!empty($value->role_data->name)): ?>
              <?=$value->role_data->name?><br />
              <a href="#" role-id="<?=$value->role?>" class="btn btn-default btn-sm view-role">Lihat akses yang diizinkan</a>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td><?=(!empty($value->last_login_timestamp))?date('Y-m-d H:i:s', $value->last_login_timestamp):'Belum pernah login'?></td>
          <td><?=date('Y-m-d H:i:s', $value->registred_timestamp)?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>

