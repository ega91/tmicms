
<input type="hidden" name="id" value="<?=(!empty($data->id))?$data->id:0?>">

<div class="alert alert-danger" style="display: none;"></div>


<div class="form-group">
  <label class="control-label">Name</label>
  <input type="text" class="form-control" name="name" placeholder="Name" value="<?=(!empty($data->name))?$data->name:''?>">
</div>

<div class="form-group">
  <label class="control-label">Description</label>
  <textarea class="form-control" name="description" placeholder="Description"><?=(!empty($data->description))?$data->description:''?></textarea>
</div>
<div class="form-group role-allowd-list">

  <h3>Izinkan Akses ke</h3>

  <a href="#" class="btn btn-default check-all-role">Check All</a>
  <a href="#" class="btn btn-default uncheck-all-role">Uncheck All</a>

  <div class="form-group">
    <label><input type="checkbox" name="broadcast" <?=(!empty($data->broadcast))?'checked="checked"':''?>> Mengirim pesan broadcast</label>
    <label><input type="checkbox" name="message" <?=(!empty($data->message))?'checked="checked"':''?>> Mengirim pesan layanan pelanggan</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_product" <?=(!empty($data->view_product))?'checked="checked"':''?>> Melihat produk</label>
    <label><input type="checkbox" name="edit_product" <?=(!empty($data->edit_product))?'checked="checked"':''?>> Edit/Tambah/Hapus produk</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_slideshow" <?=(!empty($data->view_slideshow))?'checked="checked"':''?>> Melihat promo slideshow</label>
    <label><input type="checkbox" name="edit_slideshow" <?=(!empty($data->edit_slideshow))?'checked="checked"':''?>> Edit/Tambah/Hapus promo slideshow</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_voucher" <?=(!empty($data->view_voucher))?'checked="checked"':''?>> Melihat kode voucher</label>
    <label><input type="checkbox" name="edit_voucher" <?=(!empty($data->edit_voucher))?'checked="checked"':''?>> Edit kode voucher</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_article" <?=(!empty($data->view_article))?'checked="checked"':''?>> Melihat artikel</label>
    <label><input type="checkbox" name="edit_article" <?=(!empty($data->edit_article))?'checked="checked"':''?>> Edit/Tambah/Hapus artikel</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_polis" <?=(!empty($data->view_polis))?'checked="checked"':''?>> Melihat polis</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_trx" <?=(!empty($data->view_trx))?'checked="checked"':''?>> Melihat data transaksi</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_berminat" <?=(!empty($data->view_berminat))?'checked="checked"':''?>> Melihat data berminat</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_claim" <?=(!empty($data->view_claim))?'checked="checked"':''?>> Melihat pengajuan klaim</label>
    <label><input type="checkbox" name="approve_claim" <?=(!empty($data->approve_claim))?'checked="checked"':''?>> Menerima/Menolak pengajuan klaim</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_user" <?=(!empty($data->view_user))?'checked="checked"':''?>> Melihat pengguna aplikasi</label>
    <label><input type="checkbox" name="edit_user" <?=(!empty($data->edit_user))?'checked="checked"':''?>> Edit/Tambah/Hapus pengguna</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_media" <?=(!empty($data->view_media))?'checked="checked"':''?>> Melihat media galeri</label>
    <label><input type="checkbox" name="edit_media" <?=(!empty($data->edit_media))?'checked="checked"':''?>> Edit/Tambah/Hapus media galeri</label>
  </div>

  <div class="form-group">
    <label><input type="checkbox" name="view_admin" <?=(!empty($data->view_admin))?'checked="checked"':''?>> Melihat admin</label>
    <label><input type="checkbox" name="edit_admin" <?=(!empty($data->edit_admin))?'checked="checked"':''?>> Edit/Tambah/Hapus admin</label>
  </div>
</div>



<div class="ln_solid"></div>
<div class="form-group">
  <div class="row">
    <div class="col-md-12">
      <?php if ( !empty($data) ): ?>
        <div class="pull-right">
          <a href="#" class="red-color delete-event" event-id="<?php echo $data->id?>"><i class="fa fa-trash"></i> Delete</a>
        </div>
      <?php endif; ?>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

