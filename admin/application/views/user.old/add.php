
<?php $admin = $this->session->userdata('user'); ?>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm with-padding">
          <form method="post" action="<?php echo site_url('user/save')?>" class="form-horizontal form-label-left ajax-form" success-uri="<?php echo site_url('user')?>" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" value="<?php echo (!empty($user))?$user->id:0?>">
            <input type="hidden" name="delete_image" class="delete-image">

            <div class="row">
              <div class="col-lg-6 col-md-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Basic Information</h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="alert alert-danger"></div>
                    <div class="form-group">
                      <div class="row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="first_name" class="form-control" placeholder="First name" 
                            value="<?php echo (!empty($user))?$user->first_name:''?>">
                          <br />
                          <input type="text" name="last_name" class="form-control" placeholder="Last name"
                            value="<?php echo (!empty($user))?$user->last_name:''?>">
                          <p class="help-block">Name of new user</p>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="email" class="form-control" placeholder="Email address"
                            value="<?php echo (!empty($user))?$user->email:''?>">
                          <p class="help-block">Email adress, all information and notification will be sent via email.</p>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control select2" name="city">
                            <option value="0">Kota</option>
                            <?php if (empty($city)){
                              echo '<option value="0">Tidak ada kota</option>';
                            } else{ foreach ($city as $key => $value) {
                              echo '<option value="'. $value->id .'" ';
                              if (!empty($user->city) and $user->city == $value->id)
                                echo 'selected="selected"';
                              echo '>'. $value->name .'</option>';
                            }} ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <a href="#" class="btn btn-default show-change-password" style="display: <?php echo (!empty($user))?'inline-block;':'none;'?>">Change Password</a>
                          <div id="change-password-container" style="display: <?php echo (!empty($user))?'none;':'block;'?>">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <br />
                            <input type="password" name="password2" class="form-control" placeholder="Retype password">
                            <p class="help-block">Choose password for user, minimal 8 character.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Administrator</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="1" <?php echo (!empty($user) and !empty($user->is_admin))?'checked="checked"':''?> name="is_admin"> Make this user as administrator
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href="<?php echo site_url('user')?>" class="btn btn-default">Cancel</a>
                          <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Profile Picture</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                    <div class="col-xs-12">
                      <div class="x-open-input bgimage-display" style="overflow: hidden;">
                        <img id="blah" src="<?php echo (!empty($user->profile_picture))?$user->profile_picture:site_url('resources/images/img-placeholder.png')?>"
                          img-placeholder="<?php echo site_url('resources/images/img-placeholder.png')?>"
                          style="width: 100%; height: auto;">
                      </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                      <input type="file" name="profile_picture" class="x-bgimage-input">
                      <button type="button" class="btn btn-default x-open-input btn-block">
                        <i class="fa fa-file-image-o"></i> Set Image
                      </button>
                      <div class="text-right">
                        <a href="#" class="red-color delete-x-bgimage" chapter-idx="1">
                          <i class="fa fa-trash"></i> Delete image
                        </a>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /page content -->
