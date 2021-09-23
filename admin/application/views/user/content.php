<div class="table-header">
  <div class="pull-right">
    <a href="#" class="page-prev btn btn-default" disabled="true"><i class="fa fa-chevron-left"></i></a>

    <a href="#" class="page-disabled page-pagination btn btn-default" disabled="true">
      <?=($this->input->get('page') != null)?$this->input->get('page')+1:'1';?>
    </a>

    <a href="#" class="page-next btn btn-default" disabled="true"><i class="fa fa-chevron-right"></i></a>
    <a href="#" class="page-goto btn btn-default" disabled="true">Go To Page</a>
  </div>
  <a href="#" class="reload-table btn btn-default"><i class="fa fa-history"></i></a>
  <a href="#" class="page-filter btn btn-default" filter-source="<?=site_url('user/filteruser?'. http_build_query($this->input->get()))?>"><i class="fa fa-filter"></i> Filter</a>
</div>

<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>Belum ada pengguna.</h3>
    <a href="#" class="add-modal btn btn-primary btn-lg">Daftarkan Pengguna Baru</a>
	  </div>
  </div>
<?php else: ?>

  <table class="table">
    <thead>
      <tr>
        <th>User</th>
        <th>Terakhir Login</th>
        <th>Tanggal Daftar</th>
        <th>Pernah Beli</th>
      </tr>
    </thead>
    <tbody>
      <tr><td colspan="4" class="td-add-new"><a href="#" class="add-modal btn btn-default btn-add-modal btn-block"><i class="fa fa-plus"></i> Tambah Pengguna Baru</a></td></tr>
      <?php foreach ($data as $key => $value) { ?>
        <tr>
          <td>
          <div class="user-img-container" style="background-image: url(<?=(!empty($value->profile_picture_small))?$value->profile_picture_small:'/resources/user/thumb/user-placeholder.png'?>)"></div>
            <div class="book-info-container" style="padding-left: 57px;">
              <h3 class="td-title"><?php echo $value->full_name?></h3>
              <p><i class="fa fa-envelope-o"></i> <?=$value->email?>
              <?=(!empty($value->email_verified))?'<span class="email-verified"><i class="fa fa-check"></i></span>':''?></p>

              <div class="table-action-container">
                <a href="#" class="view-user" user-id="<?=$value->id?>"><i class="fa fa-eye"></i> View</a>
                <a href="#" class="edit-modal" data-source="<?=site_url('user/edituser/'. $value->id)?>"><i class="fa fa-pencil"></i> Edit</a>
                <a href="#" class="temp-change-pass" user-id="<?=$value->id?>"><i class="fa fa-exchange"></i> Temporary Change Password</a>
                <a href="<?=site_url('user/patchpolis/'. $value->id)?>">Patch Polis</a>
              </div>
            </div>
          </td>
          <td><?=(!empty($value->last_login_timestamp))?date('Y-m-d H:i:s', $value->last_login_timestamp):'Belum pernah login'?></td>
          <td><?=date('Y-m-d H:i:s', $value->registred_timestamp)?></td>
          <td><?=(!empty($value->polis_count))?'Ya':'Belum'?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>

