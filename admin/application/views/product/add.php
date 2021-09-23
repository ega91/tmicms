
<input type="hidden" name="id" value="<?php echo (!empty($data))?$data->id:0?>">
<input type="hidden" name="policy" id="policy" value="<?=(!empty($data->policy))?str_replace('"', "'", $data->policy):''?>">
<input type="hidden" name="ketentuan_umum" id="ketentuan_umum" value="<?=(!empty($data->ketentuan_umum))?str_replace('"', "'", $data->ketentuan_umum):''?>">

<div id="form-hidden-input"></div>

<div class="alert alert-danger" style="display: none;"></div>

<div class="form-group">
  <div class="row">
    <label class="control-label col-sm-12">Foto Produk</label>
    <div class="col-sm-12">
      <div class="slide-img img-chooser <?=(!empty($data->image->image_medium))?'has-image':''?>" style="<?=(!empty($data->image->image_medium))?'background-image: url('. $data->image->image_blured .');':''?> <?=(!empty($data->image->image_medium))?'background-image: url('. $data->image->image_medium .');':''?>"></div>
      <div class="img-fake-cnt">
        <input type="file" name="image" class="img-fake">
      </div>
    </div>
  </div>
</div>

<div class="form-group">
  <label class="control-label">Nama Produk</label>
  <input type="text" class="form-control" name="name" placeholder="Nama produk" value="<?=(!empty($data->name))?$data->name:''?>">
  <p class="help-block">Nama Produk.</p>
</div>

<div class="form-group">
  <label class="control-label">Kode Produk</label>
  <input type="text" class="form-control" name="product_code" placeholder="Kode Produk" value="<?=(!empty($data->product_code))?$data->product_code:''?>">
</div>

<div class="form-group">
  <label class="control-label">Deskripsi Singkat</label>
  <textarea class="form-control" name="descriptions" placeholder="Deskripsi singkat..."><?=(!empty($data->descriptions))?$data->descriptions:''?></textarea>
  <p class="help-block">Keterangan singkat produk yang akan tampil dibawah nama produk.</p>
</div>

<div class="form-group">
  <label class="control-label">Informasi Produk</label>
  <?php 
  if (empty($data->info)){
    if (empty($data)) $data = new StdClass();
    $data->info = Array();
    $data->info[0] = new StdClass();
    $data->info[0]->title = '';
    $data->info[0]->info = '';
  } ?>
  <div id="info-product-cnt">
    <?php if ( !empty($data->info) ){ foreach ($data->info as $key => $value) { ?>
      <div class="info-product-item">
        <div class="product-info-cnt">
          <div class="product-info-head">
            <?php if ( $key > 0 ): ?>
              <div class="pull-right">
                <a href="#" class="product-info-delete"><i class="fa fa-close"></i></a>
              </div>
            <?php endif; ?>
            <a class="product-info-handle"><i class="fa fa-navicon"></i> Drag disini untuk mengurutkan.</a>
          </div>
          <div class="form-group">
            <input type="hidden" name="info_id[]" class="info_id" value="<?=(!empty($value->id))?$value->id:''?>">
            <input type="text" class="form-control info-product-title" name="info_title[]" placeholder="Judul Informasi" value="<?=(!empty($value->title))?$value->title:''?>">
            <input type="hidden" name="info_desc[]" class="input-product-info">
          </div>
          <div class="form-control the-editable info-product-info" placeholder="Informasi Produk"><?=(!empty($value->info))?$value->info:''?></div>
        </div>
      </div>
    <?php }} ?>
  </div>
  <p class="help-block">Informasi lengkap mengenai produk.</p>
  <button type="button" class="btn btn-add-modal btn-block btn-default add-info-product"><i class="fa fa-plus"></i> Tambah Informasi Produk</button>
</div>

<div class="form-group">
  <label class="control-label">Kebijakan Produk</label>
  <div class="form-control the-editable" rows="7" id="policy-input" placeholder="Kebijakan produk"><?=(!empty($data->policy))?$data->policy:''?></div>
  <p class="help-block">Kebijakan produk ini, kebijakan ini akan muncul ketika pengguna mau membeli produk ini dan pengguna harus menyetujui kebijakan ini.</p>
</div>

<div class="form-group">
  <label class="control-label">Ketentuan Umum</label>
  <div class="form-control the-editable" rows="7" id="ketentuan-umum" placeholder="Ketentuan-ketentuan umum"><?=(!empty($data->ketentuan_umum))?$data->ketentuan_umum:''?></div>
  <p class="help-block">Keterangan ketentuan umum asuransi kecelakaan diri yang tampil di detail polis.</p>
</div>

<div class="form-group">
  <label class="control-label">Dapat Dibeli?</label>
  <div>
    <label>
      <input type="radio" name="can_be_bought" class="can_be_bought" <?=(!isset($data->can_be_bought) or $data->can_be_bought == 1)?'checked="checked"':''?> value="Yes"> Ya
    </label> &nbsp;
    <label>
      <input type="radio" name="can_be_bought" class="can_be_bought" <?=(isset($data->can_be_bought) and $data->can_be_bought == 0)?'checked="checked"':''?> value="No"> Tidak
    </label>
  </div>
  <p class="help-block">Apakah produk ini dapat dibeli langsung di aplikasi oleh pengguna?</p>
</div>


<div class="form-group age-wrapper" style="<?=(isset($data->can_be_bought) and $data->can_be_bought == 0)?'display: none;':''?>">
  <label class="control-label">Batas Usia</label>
  <div class="row">
    <div class="col-sm-6">

      <div class="input-group">
        <input type="text" class="form-control" name="age_min" placeholder="Usia minimal" value="<?=(!empty($data->age_min))?$data->age_min:''?>">
        <div class="input-group-addon">
          <span class="input-group-text">Bulan</span>
        </div>
      </div>

    </div>
    <div class="col-sm-6">

      <div class="input-group">
        <input type="text" class="form-control" name="age_max" placeholder="Usia maksimal" value="<?=(!empty($data->age_max))?$data->age_max:''?>">
        <div class="input-group-addon">
          <span class="input-group-text">Bulan</span>
        </div>
      </div>

    </div>
  </div>
  <p class="help-block">Batas usia untuk pembelian produk dalam bulan, harap isi 0 jika tidak dibatasi.</p>
</div>


<div class="form-group package-price-wrapper" style="<?=(isset($data->can_be_bought) and $data->can_be_bought == 0)?'display: none;':''?>">
  <label class="control-label">Harga Paket</label>
  <div id="package-price-master">
    <div class="row">
      <div class="col-sm-4">
        <div class="input-group">
          <div class="input-group-addon">
            <span class="input-group-text">Rp</span>
          </div>
          <input type="hidden" name="price_id[]" value="<?=(!empty($data->prices[0]->id))?$data->prices[0]->id:''?>">
          <input type="text" class="form-control package-price" name="price[]" placeholder="Harga" value="<?=(!empty($data->prices[0]->price))?$data->prices[0]->price:''?>">
        </div>
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="form-control package-price-period" name="price_period[]" placeholder="Masa berlaku" value="<?=(!empty($data->prices[0]->period))?$data->prices[0]->period:''?>">
          <div class="input-group-addon">
            <span class="input-group-text">Hari</span>
          </div>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="input-group">
          <div class="input-group-addon">
            <span class="input-group-text">Rp</span>
          </div>
          <input type="text" class="form-control package-price-pertanggungan" name="pertanggungan[]" placeholder="Uang Pertanggungan" value="<?=(!empty($data->prices[0]->pertanggungan))?$data->prices[0]->pertanggungan:''?>">
        </div>
      </div>
    </div>
  </div>
  <div id="package-price-cnt">
    <?php if ( !empty($data->prices) ){ foreach ($data->prices as $key => $value) { if ( $key == 0 ) continue; ?>
      <div class="package-price-item">
        <div class="row">
          <div class="col-sm-4">
            <div class="input-group">
              <div class="input-group-addon">
                <span class="input-group-text">Rp</span>
              </div>
              <input type="hidden" name="price_id[]" value="<?=(!empty($value->id))?$value->id:''?>">
              <input type="text" class="form-control package-price" name="price[]" placeholder="Harga" value="<?=(!empty($value->price))?$value->price:''?>">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="input-group">
              <input type="text" class="form-control package-price-period" name="price_period[]" placeholder="Masa berlaku" value="<?=(!empty($value->period))?$value->period:''?>">
              <div class="input-group-addon">
                <span class="input-group-text">Hari</span>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="input-group">
              <div class="input-group-addon">
                <span class="input-group-text">Rp</span>
              </div>
              <input type="text" class="form-control package-price-pertanggungan" name="pertanggungan[]" placeholder="Uang Pertanggungan" value="<?=(!empty($value->pertanggungan))?$value->pertanggungan:''?>">
            </div>
          </div>
        </div>
      </div>
    <?php }} ?>
  </div>
  <button type="button" class="add-package-price btn btn-add-modal btn-block btn-default"><i class="fa fa-plus"></i> Tambah Harga Paket</button>
</div>

<div class="ln_solid"></div>
<div class="form-group">
  <div class="row">
    <div class="col-md-12">
      <?php if ( !empty($data->id) ): ?>
        <div class="pull-right">
          <a href="#" class="red-color delete-event" event-id="<?php echo $data->id?>"><i class="fa fa-trash"></i> Delete</a>
        </div>
      <?php endif; ?>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

