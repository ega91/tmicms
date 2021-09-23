
<input type="hidden" name="edit_id" value="<?php echo (!empty($data))?$data->id:0?>">
<input type="hidden" name="event_start" id="event_start">
<input type="hidden" name="event_end" id="event_end">

<div class="alert alert-danger" style="display: none;"></div>
<div class="form-group">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name Acara</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" name="name" class="form-control" placeholder="Nama acara" 
        value="<?php echo (!empty($data))?$data->name:''?>">
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <textarea name="description" class="form-control" placeholder="Keterangan acara..." rows="4"><?php echo (!empty($data))?$data->description:''?></textarea>
      <p class="help-block">Keterangan tentang acara ini.</p>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi Acara</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <textarea name="location" class="form-control" placeholder="Alamat lokasi..." rows="4"><?php echo (!empty($data))?$data->location:''?></textarea>
      <p class="help-block">Alamat lokasi acara ini diadakan.</p>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Poster Acara</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <div class="row">
        <div class="col-xs-8 col-md-8">
          <div class="bgimage-display bgimage-display-event" style="border-radius: 0px; height: 320px; overflow: hidden;">
            <img src="<?php echo (!empty($data->poster))?$data->poster_data->image_270:site_url('resources/images/img-placeholder-poster.png')?>"
              img-placeholder="<?php echo site_url('resources/images/img-placeholder-poster.png')?>"
              style="width: auto; height: 100%;">
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-12 col-xs-12">
          <input type="hidden" name="poster" class="bgimage-input" value="<?php echo (!empty($data))?$data->poster:''?>">
          <button type="button" class="btn btn-default media-manager-event">
            <i class="fa fa-file-image-o"></i> Tetapkan Gambar
          </button>
          <a href="#" class="red-color delete-bgimage" chapter-idx="1">
            <i class="fa fa-trash"></i> Hapus gambar
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="form-group hidden">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Desa</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="link_to_desa" class="event-desa-checkbox" <?php echo (!empty($data->post_id))?'checked="checked"':''?>">
          Apakah acara ini terkait dengan desa?
        </label>
      </div>
      <div class="event-desa-container" style="display: <?php echo (!empty($data->post_id))?'blick':'none'?>;">
        <select class="form-control" name="desa">
          <?php foreach ($desa as $key => $value) { if ( !empty($value->sections) and !empty($value->sections[0]->title) ){ ?>
            <option value="<?php echo $value->id?>"
              <?php echo (!empty($data->post_id) and $data->post_id ==  $value->id)?'selected="selected"':''?>><?php echo $value->sections[0]->title?></option>
          <?php }} ?>
        </select>
        <p class="help-block">Pilih Desa yang terkain dengan acara ini.</p>
      </div>
    </div>
  </div>
</div>
<div class="form-group">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Link Url<br />(Map location)</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <div class="input-group no-radius">
        <span class="input-group-addon">http://</span>
        <input type="text" name="url" class="form-control" placeholder="Link url..." value="<?php echo (!empty($data))?$data->url:''?>">
      </div>
      <p class="help-block">Optional link url for this event.</p>
    </div>
  </div>
</div>

<div class="ln_solid"></div>
<div class="form-group">
  <div class="row">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
      <?php if ( !empty($data) ): ?>
        <div class="pull-right">
          <a href="#" class="red-color delete-event" event-id="<?php echo $data->id?>"><i class="fa fa-trash"></i> Hapus acara</a>
        </div>
      <?php endif; ?>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

