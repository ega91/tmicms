<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">

          <div class="content-main-content">
            <form method="post" action="<?php echo site_url('setting/save/content')?>" class="form-horizontal form-label-left ajax-form">

              <div class="row">
                <div class="col-md-9 col-xs-12">
                  <div class="alert alert-danger" style="margin-top: 6px;"></div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-9 col-xs-12">

                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Desa Detail Page</h2>
                      <ul class="nav navbar-right panel_toolbox">
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Display News</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" name="display_news" 
                              class="js-switch" <?php echo (!empty($setting->display_news))?'checked':''?> />
                            <p class="help-block">Display news about <i>desa</i> in detail page.</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Display Event</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" name="display_event" 
                              class="js-switch" <?php echo (!empty($setting->display_event))?'checked':''?> />
                            <p class="help-block">Display <i>desa</i> event in detail page.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="x_panel">
                    <div class="x_title">
                      <h2>News Detail Page</h2>
                      <ul class="nav navbar-right panel_toolbox">
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="form-group hidden">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Autoload Next News</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" name="autoload_next_news" 
                              class="js-switch" <?php echo (!empty($setting->autoload_next_news))?'checked':''?> />
                            <p class="help-block">Autoload next news when user scroll reach bottom. Enable this will disable display related news</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Display Related News</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" name="display_related_news" 
                              class="js-switch" <?php echo (!empty($setting->display_related_news))?'checked':''?> />
                            <p class="help-block">Display related news in bottom of news article.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="x_panel hidden">
                    <div class="x_title">
                      <h2>Comment</h2>
                      <ul class="nav navbar-right panel_toolbox">
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Comment Engine</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="comment_by" class="form-control">
                              <option value="disqus" <?php echo ($setting->comment_by == 'disqus')?'selected':''?>>Disqus</option>
                              <option value="facebook" <?php echo ($setting->comment_by == 'facebook')?'selected':''?>>Facebook</option>
                            </select>
                            <p class="help-block">If visitor can comment in content page, this comment provider will be used.</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Allow Comment in <i>Desa</i></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" name="display_comment_in_desa" 
                              class="js-switch" <?php echo (!empty($setting->display_comment_in_desa))?'checked':''?>  />
                            <p class="help-block">Visitor can post comment in desa detail page?.</p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Allow Comment in News</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" name="display_comment_in_news"
                              class="js-switch" <?php echo (!empty($setting->display_comment_in_news))?'checked':''?> />
                            <p class="help-block">Visitor can post comment in news detail page?.</p>
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
