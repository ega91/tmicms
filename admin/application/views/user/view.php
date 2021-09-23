
<div class="alert alert-danger" style="display: none;"></div>

<div class="form-group">
  <div class="row">
    <div class="col-sm-12">
      <div class="user-img-cnt view-user-img">
        <div class="slide-img <?=(!empty($data->profile_picture_medium))?'has-image':''?>" style="<?=(!empty($data->profile_picture_medium))?'background-image: url('. $data->profile_picture_medium .');':''?> <?=(!empty($data->profile_picture_medium))?'background-image: url('. $data->profile_picture_medium .');':''?>"></div>
      </div>
    </div>
  </div>
</div>

<div class="form-group text-center">
  <h3><?=(!empty($data->full_name))?$data->full_name:''?></h3>
  <p class="help-block">
    <?=(!empty($data->email))?'<i class="fa fa-envelope-o"></i> '. $data->email:''?>
    <?=(!empty($data->username))?'<br/>Username: '. $data->username:''?>
    <?=(!empty($data->phone))?'<br/><i class="fa fa-phone"></i> '. $data->phone:''?>
  </p>
</div>

