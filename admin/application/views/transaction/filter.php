
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
  <label class="control-label">Nama User/Pembeli</label>
  <input type="text" class="form-control" name="nama_pembeli" placeholder="Nama user/pembeli" value="<?=$this->input->get('nama_pembeli')?>">
  <p class="help-block">User yang melakukan transaksi.</p>
</div>

<div class="form-group">
  <label class="control-label">Nama Pemegang Polis</label>
  <input type="text" class="form-control" name="nama_kontak" placeholder="Nama pemegang polis" value="<?=$this->input->get('nama_kontak')?>">
  <p class="help-block">Filter berdasarkan nama pemegang polis.</p>
</div>

<div class="form-group">
  <label class="control-label">Nama Tertanggung</label>
  <input type="text" class="form-control" name="nama_tertanggung" placeholder="Nama tertanggung" value="<?=$this->input->get('nama_tertanggung')?>">
  <p class="help-block">Filter berdasarkan nama tertanggung.</p>
</div>

<div class="form-group">
  <label class="control-label">Status</label>
  <div>
    <label>
      <input type="radio" name="status" <?=(empty($status))?'checked="checked"':''?> value=""> Semua
    </label> &nbsp;
    <label>
      <input type="radio" name="status" <?=(!empty($status) and $status == 'paid')?'checked="checked"':''?> value="paid"> Paid
    </label> &nbsp;
    <label>
      <input type="radio" name="status" <?=(!empty($status) and $status == 'waiting_payment')?'checked="checked"':''?> value="waiting_payment"> Waiting Payment
    </label> &nbsp;
    <label>
      <input type="radio" name="status" <?=(!empty($status) and $status == 'failed')?'checked="checked"':''?> value="failed"> Failed
    </label>
  </div>
  <p class="help-block">Menampilkan polis berdasarkan status yang dipilih.</p>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Tanggal Transaksi</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="trxdate_dari" placeholder="Dari tanggal" value="<?=$this->input->get('trxdate_dari')?>">
        <div class="input-group-addon">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
      <p class="help-block">Transaksi yang dilakukan di rentang tanggal.</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">&nbsp;</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="trxdate_sampai" placeholder="Sampai tanggal" value="<?=$this->input->get('trxdate_sampai')?>">
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

