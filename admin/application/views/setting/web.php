<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">

          <div class="content-main-content">
            <form method="post" action="<?php echo site_url('setting/save/web')?>" class="form-horizontal form-label-left ajax-form">

              <div class="row">
                <div class="col-md-9 col-xs-12">
                  <div class="alert alert-danger" style="margin-top: 6px;"></div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-9 col-xs-12">

                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Basic Setting</h2>
                      <ul class="nav navbar-right panel_toolbox">
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Site Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="site_name" class="form-control" placeholder="Site name" 
                              value="<?php echo $setting->site_name?>">
                            <p class="help-block">Displayed in title meta. recomended 78 characters.</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Site Description</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="site_description" rows="4" class="form-control" placeholder="Site description..."><?php echo $setting->site_description?></textarea>
                            <p class="help-block">Displayed in description meta tag. recomended 170 - 172 characters.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Webmaster &amp; Analityc</h2>
                      <ul class="nav navbar-right panel_toolbox">
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Google Webmaster</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="google_webmaster" class="form-control" placeholder="Google webmaster meta tag" 
                              value="<?php echo $setting->google_webmaster?>">
                            <p class="help-block">Google webmaster meta tag.</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Google Analityc ID</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="google_analityc" rows="3" class="form-control" placeholder="Google analityc" value="<?php echo $setting->google_analityc?>">
                            <p class="help-block">Google analityc tracking id. example: <b>UA-60236868-2</b></p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Bing Webmaster</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="bing_webmaster" class="form-control" placeholder="Bing webmaster meta tag" 
                              value="<?php echo $setting->bing_webmaster?>">
                            <p class="help-block">Bing webmaster meta tag.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Social Media</h2>
                      <ul class="nav navbar-right panel_toolbox">
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><i class="fa fa-facebook"></i> Facebook</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="facebook_url" class="form-control" placeholder="Facebook url" 
                              value="<?php echo $setting->facebook_url?>">
                            <p class="help-block">Full url to facebook page.</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><i class="fa fa-facebook"></i> Twitter</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="twitter_url" class="form-control" placeholder="Twitter url"
                              value="<?php echo $setting->twitter_url?>">
                            <p class="help-block">Url to Twitter profile.</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><i class="fa fa-youtube"></i> Youtube</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="youtube_url" class="form-control" placeholder="Youtube channle url" 
                              value="<?php echo $setting->youtube_url?>">
                            <p class="help-block">Youtube channel url</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><i class="fa fa-instagram"></i> Instagram</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="instagram_url" class="form-control" placeholder="Instagram url" 
                              value="<?php echo $setting->instagram_url?>">
                            <p class="help-block">Instagram url.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /page content -->
