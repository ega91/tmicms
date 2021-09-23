<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">

          <div class="content-main-content">
            <form method="post" action="<?php echo site_url('setting/save/display')?>" class="form-horizontal form-label-left ajax-form">

              <div class="row">
                <div class="col-sm-6 col-xs-12">
                  <div class="alert alert-danger" style="margin-top: 6px;"></div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6 col-xs-12">


                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Sport Training Tips</h2>
                      <ul class="nav navbar-right panel_toolbox">
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="form-group" style="margin-bottom: 20px;">
                        <div class="row">
                          <label class="control-label col-sm-7 col-xs-12">Display Article <br /><b>UPPER BODY WORKOUT</b></label>
                          <div class="col-sm-5 col-xs-12" style="padding-top: 10px;">
                            <input type="checkbox" class="js-switch" name="display_article_1" <?php echo (!empty($setting->display_article_1))?'checked="checked"':''?> />
                          </div>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom: 20px;">
                        <div class="row">
                          <label class="control-label col-sm-7 col-xs-12">Display Article <br /><b>LOWER BODY WORKOUT</b></label>
                          <div class="col-sm-5 col-xs-12" style="padding-top: 10px;">
                            <input type="checkbox" class="js-switch" name="display_article_2" <?php echo (!empty($setting->display_article_2))?'checked="checked"':''?> />
                          </div>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom: 20px;">
                        <div class="row">
                          <label class="control-label col-sm-7 col-xs-12">Display Article <br /><b>WHOLE BODY WORKOUT</b></label>
                          <div class="col-sm-5 col-xs-12" style="padding-top: 10px;">
                            <input type="checkbox" class="js-switch" name="display_article_3" <?php echo (!empty($setting->display_article_3))?'checked="checked"':''?> />
                          </div>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-lg btn-block btn-primary">Save Changes</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /page content -->
