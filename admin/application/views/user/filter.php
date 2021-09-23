
<div class="alert alert-danger" style="display: none;"></div>

<div class="form-group">
  <label class="control-label">Nama pengguna</label>
  <input type="text" class="form-control" name="name" placeholder="Nama pengguna" value="<?=$this->input->get('name')?>">
  <p class="help-block">Filter berdasarkan nama pengguna.</p>
</div>

<div class="form-group">
  <label class="control-label">Email</label>
  <input type="text" class="form-control" name="email" placeholder="Email" value="<?=$this->input->get('email')?>">
  <p class="help-block">Filter berdasarkan alamat email.</p>
</div>

<div class="form-group">
  <label class="control-label">Pernah Beli?</label>
  <div>
    <label>
      <input type="radio" name="pernah_beli" value="0" <?=($this->input->get('pernah_beli') == '0' or $this->input->get('pernah_beli') == null)?'checked="checked"':''?>> Ya
    </label> &nbsp;
    <label>
      <input type="radio" name="pernah_beli" value="Yes" <?=($this->input->get('pernah_beli') == 'Yes')?'checked="checked"':''?>> Ya
    </label> &nbsp;
    <label>
      <input type="radio" name="pernah_beli" value="No" <?=($this->input->get('pernah_beli') == 'No')?'checked="checked"':''?>> Tidak
    </label>
  </div>
  <p class="help-block">Menampilkan pengguna yang beli produk.</p>
</div>


<?php /**
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Tanggal Daftar</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="periode_start" placeholder="Dari tanggal" value="">
        <div class="input-group-addon">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
      <p class="help-block">Pengguna yang daftar di rentang tanggal.</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">&nbsp;</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="periode_end" placeholder="Sampai tanggal" value="">
        <div class="input-group-addon">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
    </div>
  </div>
</div>
*/ ?>

<div class="form-group">
  <label class="control-label">Pernah Login?</label>
  <div>
    <label>
      <input type="radio" name="pernah_login" value="0" <?=($this->input->get('pernah_login') == '0' or $this->input->get('pernah_login') == null)?'checked="checked"':''?>> Semua
    </label> &nbsp;
    <label>
      <input type="radio" name="pernah_login" value="Yes" <?=($this->input->get('pernah_login') == 'Yes')?'checked="checked"':''?>> Ya
    </label> &nbsp;
    <label>
      <input type="radio" name="pernah_login" value="No" <?=($this->input->get('pernah_login') == 'No')?'checked="checked"':''?>> Tidak
    </label>
  </div>
  <p class="help-block">Menampilkan pengguna yang pernah login.</p>
</div>

<div class="form-group">
  <label class="control-label">Verifikasi Email?</label>
  <div>
    <label>
      <input type="radio" name="verifikasi_email" value="0" <?=($this->input->get('verifikasi_email') == 0 or $this->input->get('verifikasi_email') == null)?'checked="checked"':''?>> Semua
    </label> &nbsp;
    <label>
      <input type="radio" name="verifikasi_email" value="Yes" <?=($this->input->get('verifikasi_email') == 'Yes')?'checked="checked"':''?>> Ya
    </label> &nbsp;
    <label>
      <input type="radio" name="verifikasi_email" value="No" <?=($this->input->get('verifikasi_email') == 'No')?'checked="checked"':''?>> Tidak
    </label>
  </div>
  <p class="help-block">Menampilkan pengguna yang pernah login.</p>
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