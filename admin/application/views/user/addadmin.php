
<div class="form-group">
  <div class="row">
    <div class="col-sm-12">
      <div class="user-img-cnt">
        <div class="slide-img img-chooser <?=(!empty($data->profile_picture_medium))?'has-image':''?>" style="<?=(!empty($data->profile_picture_medium))?'background-image: url('. $data->profile_picture_medium .');':''?> <?=(!empty($data->profile_picture_medium))?'background-image: url('. $data->profile_picture_medium .');':''?>"></div>
      </div>
      <div class="img-fake-cnt">
        <input type="file" name="image" class="img-fake">
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="id" value="<?=(!empty($data->id))?$data->id:0?>">
<div class="alert alert-danger" style="display: none;"></div>

<div class="form-group">
  <label class="control-label">Role</label>
  <select class="form-control" name="role">
    <option value="0">Pilih role</option>
    <?php foreach ($roles as $key => $value) {
      echo '<option value="'. $value->id .'" ';
      if (!empty($data->role) and $data->role == $value->id)
        echo 'selected="selected"';
      echo '>'. $value->name .'</option>';
    } ?>
  </select>
</div>

<div class="form-group">
  <label class="control-label">Nama Lengkap</label>
  <input type="text" class="form-control" name="full_name" placeholder="Nama lengkap" value="<?=(!empty($data->full_name))?$data->full_name:''?>">
</div>

<div class="form-group">
  <label class="control-label">Email</label>
  <input type="text" class="form-control" name="email" placeholder="Email" value="<?=(!empty($data->email))?$data->email:''?>">
</div>

<div class="form-group">
  <label class="control-label">No. Telp.</label>
  <input type="text" class="form-control" name="phone" placeholder="No. telp." value="<?=(!empty($data->phone))?$data->phone:''?>">
</div>

<div class="form-group">
  <label class="control-label">Username</label>
  <input type="text" class="form-control" name="username" placeholder="Username" value="<?=(!empty($data->username))?$data->username:''?>">
</div>

<?php if (!empty($data) and !empty($data->id)): ?>
  <a href="#" class="change-pass-btn">Ganti Password?</a>
<?php endif; ?>

<div class="form-group ch-password ch-password-cnt" <?=(!empty($data) and !empty($data->id))?'style="display: none;"':''?>>
  <?php if (!empty($data) and !empty($data->id)): ?>
    <label class="control-label">Ganti Password?</label>
  <?php else: ?>
    <label class="control-label">Password</label>
  <?php endif; ?>
  <input type="password" class="form-control" name="password" placeholder="Password baru">
  <input type="password" class="form-control" name="password2" placeholder="Ulangi password">
  <p class="help-block">Password untuk admin minimal 8 karakter dan harus memilik angka, huruf kecil dan huruf besar</p>
</div>

<div class="ln_solid"></div>
<div class="form-group">
  <div class="row">
    <div class="col-md-12">
      <?php if ( !empty($data) ): ?>
        <div class="pull-right">
          <a href="#" class="red-color delete-modal" delete-uri="<?=site_url('user/delete/'. $data->id)?>"><i class="fa fa-trash"></i> Delete</a>
        </div>
      <?php endif; ?>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

