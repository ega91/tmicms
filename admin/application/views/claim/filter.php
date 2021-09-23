

<div class="alert alert-danger" style="display: none;"></div>

<?php if (!empty($product)): ?>
  <div class="form-group">
    <label class="control-label">Produk</label>
    <select name="id_product" class="form-control">
      <option value="0">Pilih Produk</option>
      <?php foreach ($product as $key => $value) { if (!empty($value->can_be_bought)){
        echo '<option value="'. $value->id .'" ';
        if ($value->id == $this->input->get('id_product')) echo 'selected="selected" ';
        echo '>'. $value->name .'</option>';
      }} ?>
    </select>
    <p class="help-block">Filter berdasarkan produk yang dipilih.</p>
  </div>
<?php endif; ?>

<div class="form-group">
  <?php $typePengajuan = $this->input->get('type'); ?>
  <label class="control-label">Tipe Pengajuan</label>
  <div>
    <label>
      <input type="radio" name="type" <?=(empty($typePengajuan))?'checked="checked"':''?> value=""> Semua
    </label> &nbsp;
    <label>
      <input type="radio" name="type" <?=(!empty($typePengajuan) and $typePengajuan == 'pengobatan')?'checked="checked"':''?> value="pengobatan"> Pengobatan
    </label> &nbsp;
    <label>
      <input type="radio" name="type" <?=(!empty($typePengajuan) and $typePengajuan == 'cacat')?'checked="checked"':''?> value="cacat"> Cacat
    </label>
    <label> &nbsp;
      <input type="radio" name="type" <?=(!empty($typePengajuan) and $typePengajuan == 'meninggal')?'checked="checked"':''?> value="meninggal"> Meninggal
    </label>
  </div>
  <p class="help-block">Menampilkan pengajuan klaim berdasarkan status yang dipilih.</p>
</div>

<div class="form-group">
  <label class="control-label">Nama User</label>
  <input type="text" class="form-control" name="nama_user" placeholder="Nama user" value="<?=$this->input->get('nama_user')?>">
  <p class="help-block">Filter berdasarkan nama user yang mengajukan.</p>
</div>

<div class="form-group">
  <label class="control-label">Nama Pemegang Polis</label>
  <input type="text" class="form-control" name="nama_pembeli" placeholder="Nama pemegang polis" value="<?=$this->input->get('nama_pembeli')?>">
  <p class="help-block">Filter berdasarkan nama pemegang polis.</p>
</div>

<div class="form-group">
  <label class="control-label">Nama Tertanggung</label>
  <input type="text" class="form-control" name="nama_tertanggung" placeholder="Nama tertanggung" value="<?=$this->input->get('nama_user')?>">
  <p class="help-block">Filter berdasarkan nama tertanggung.</p>
</div>

<div class="form-group">
  <label class="control-label">Status</label>
  <div>
    <label>
      <input type="radio" name="status" <?=(empty($status))?'checked="checked"':''?> value=""> Semua
    </label> &nbsp;
    <label>
      <input type="radio" name="status" <?=(!empty($status) and $status == 'waiting')?'checked="checked"':''?> value="waiting"> Menunggu persetujuan
    </label> &nbsp;
    <label>
      <input type="radio" name="status" <?=(!empty($status) and $status == 'aproved')?'checked="checked"':''?> value="aproved"> Disetujui
    </label>
    <label> &nbsp;
      <input type="radio" name="status" <?=(!empty($status) and $status == 'declined')?'checked="checked"':''?> value="declined"> Ditolak
    </label>
  </div>
  <p class="help-block">Menampilkan pengajuan klaim berdasarkan status yang dipilih.</p>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Tanggal Pengajuan Klaim</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="tanggal_dari" placeholder="Dari tanggal" value="<?=$this->input->get('tanggal_dari')?>">
        <div class="input-group-addon">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
      <p class="help-block">User mengajukan klaim direntang tanggal.</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">&nbsp;</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="tanggal_sampai" placeholder="Sampai tanggal" value="<?=$this->input->get('tanggal_sampai')?>">
        <div class="input-group-addon">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="ln_solid"></div>
<div class="form-group">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</a>
      <button type="submit" class="btn btn-primary">Filter</button>
    </div>
  </div>
</div>

