<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>No role set yet.</h3>
    <a href="#" class="add-modal btn btn-primary btn-lg">Add New Role</a>
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
        <th>Name</th>
        <th>Allowed Access</th>
      </tr>
    </thead>
    <tbody>
      <tr><td colspan="5" class="td-add-new"><a href="#" class="add-modal btn btn-default btn-add-modal btn-block"><i class="fa fa-plus"></i> Tambah Role Baru</a></td></tr>
      <?php foreach ($data as $key => $value) { ?>
        <tr>
          <td>
            <div class="book-info-container">
              <h3 class="td-title"><?php echo $value->name?></h3>
              <?=(!empty($value->description))?'<p>'.$value->description.'</p>':''?>

              <div class="table-action-container">
                <a href="#" class="view-role" role-id="<?=$value->id?>"><i class="fa fa-eye"></i> Lihat</a>
                <a href="#" class="edit-modal" data-source="<?=site_url('user/editrole/'. $value->id)?>"><i class="fa fa-pencil"></i> Edit</a>
                <a href="#" class="delete-modal" delete-uri="<?=site_url('user/deleterole/'. $value->id)?>"><i class="fa fa-trash"></i> Hapus</a>
              </div>
            </div>
          </td>
          <?php $allowedAccess = 0; foreach ($value as $key => $value) {
            if ($key != 'id' and $value == 1) $allowedAccess++;
          } ?>
          <td><?=($allowedAccess == 21)?'All features':$allowedAccess.' features'?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>

