
<input type="hidden" name="id" value="<?php echo (!empty($data))?$data->id:0?>">

<div class="alert alert-danger" style="display: none;"></div>
<div class="form-group">
  <div class="row">
    <label class="control-label col-sm-12">Gambar Slideshow</label>
    <div class="col-sm-12">
      <div class="slide-img img-chooser <?=(!empty($data->image_medium))?'has-image':''?>" style="<?=(!empty($data->image_medium))?'background-image: url('. $data->image_blured .');':''?> <?=(!empty($data->image_medium))?'background-image: url('. $data->image_medium .');':''?>"></div>
      <p>Ukuran gambar: 900px x 400px</p>
      <div class="img-fake-cnt">
        <input type="file" name="promo" class="img-fake">
      </div>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="control-label col-sm-12">Link</label>
    <div class="col-sm-12 link-to-<?=(!empty($data->link_to))?$data->link_to:'none'?> link-to-unknown">
      <div class="form-group">
        <select class="form-control" name="link_to" id="slide-chooser">
          <?php $slideLinks = Array(
            Array( 'value' => 'none', 'label' => 'Tidak Ada' ),
            Array( 'value' => 'product', 'label' => 'Produk Detil' ),
            Array( 'value' => 'polis', 'label' => 'Halaman Polis' ),
            Array( 'value' => 'article', 'label' => 'Artikel' ),
            Array( 'value' => 'message', 'label' => 'Halaman Pesan' ),
            Array( 'value' => 'profile', 'label' => 'Profil Pengguna' ),
            Array( 'value' => 'eksternal', 'label' => 'Halaman Web Eksternal' )); ?>

          <?php foreach ($slideLinks as $key => $value) { 
            echo '<option value="'. $value['value'] .'" ';
            if ( !empty($data->link_to) and $data->link_to == $value['value'] )
              echo 'selected="selected"';
            echo '>'. $value['label'] .'</option>';
          } ?>
        </select>
      </div>
      <div class="form-group" id="link-article">
        <select class="form-control" name="article_id">
          <?php if ( empty($articles) ): ?>
            <option value="0">Pilih artikel</option>
          <?php else: foreach ($articles as $key => $value) { ?>
            <option value="<?=$value->id?>" <?=(!empty($data->article_id) and $data->article_id == $value->id)?'selected="selected"':''?>><?=$value->title?></option>
          <?php } endif; ?>
        </select>
      </div>
      <div class="form-group" id="link-product">
        <select class="form-control" name="product_id">
          <?php if ( empty($products) ): ?>
            <option value="0">Pilih produk</option>
          <?php else: foreach ($products as $key => $value) { ?>
            <option value="<?=$value->id?>" <?=(!empty($data->product_id) and $data->product_id == $value->id)?'selected="selected"':''?>><?=$value->name?></option>
          <?php } endif; ?>
        </select>
      </div>
      <div class="form-group" id="link-eksternal">
        <input type="text" class="form-control" name="external_url" placeholder="Url halaman web eksternal" value="<?=(!empty($data->external_url))?$data->external_url:''?>">
      </div>
      <p class="help-block">Link, bisa ke halaman eksternal url web atau ke halaman lain di aplikasi seperti halaman produk, halaman polis, artikel, atau halaman profil pengguna.</p>
    </div>
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

