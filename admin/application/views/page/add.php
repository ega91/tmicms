
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        <?php $this->load->view('static/sidebar'); ?>
        <?php $this->load->view('static/header'); ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="admin-container-sm">

            <input type="hidden" name="edit_id" id="edit_id" value="<?=(!empty($data->id))?$data->id:0?>">
            <input type="hidden" name="header_image" id="header_image" value="<?=(!empty($data->header_image))?$data->header_image->id:0?>">

            <div class="clearfix"></div>
            <div class="add-form-container">
              <div class="header-img-cnt" id="header-img-cnt" style="<?=(!empty($data->header_image))?'background-image: url(\''. $data->header_image->image_920 .'\')':''?>">
                <a id="ch-himg" class="ch-himg" data-toggle="tooltip" data-placement="left" title="Change header image"><i class="fa fa-image"></i></a>
                <div class="pt-cnt">
                  <textarea type="text" id="page-title" class="form-control input-lg page-title post-title with-placeholder" placeholder="Title here..." rows="1"><?=(!empty($data->title))?$data->title:''?></textarea>
                  <textarea type="text" id="page-subtitle" class="form-control input-lg page-subtitle post-title with-placeholder" placeholder="Title here..." rows="1"><?=(!empty($data->subtitle))?$data->subtitle:''?></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-offset-2 col-sm-8 col-editor">
                  <div class="form-group">
                    <div class="ce-am-container">
                      <div class="am-container">
                        <div class="open-am"></div>
                        <div class="am-btn-container">
                          <div class="am-btn am-btn-img"><i class="fa fa-image"></i></div>
                          <div class="am-btn am-btn-video"><i class="fa fa-youtube"></i></div>
                          <div class="am-btn am-btn-map"><i class="fa fa-map"></i></div>
                          <div class="am-btn am-btn-embed"><i class="fa fa-code"></i></div>
                        </div>
                      </div>
                      <ul class="ce-container content-editor ed-section" id="content-editor">
                        <?=(!empty($data->content))?$data->content:'<p><br /></p>'?>
                      </ul>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div id="editor-action">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                <div class="pull-right ea-r">
                  <li class="dropup editor-config-cnt">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></a>
                    <ul class="dropdown-menu">
                      <div class="edcf edcf-info">
                        <h3>Post Info</h3>
                        <div class="addpost-publish-item">
                          Status
                          <div><span class="status-draft">Draft</span></div>
                        </div>
                        <div class="addpost-publish-item">
                          Visibility
                          <div>Hidden</div>
                        </div>
                        <div class="addpost-publish-item">
                          Author
                          <div><?=(!empty($data->author))?$data->author->first_name.' '.$data->author->last_name:'M Firmansyah'?></div>
                        </div>
                      </div>
                      <div class="edcf edcf-tags">
                        <h3>Tags</h3>
                        <p>Add tag in field below, separate by comma.</p>
                        <textarea class="form-control" placeholder="Add tag here..." id="ed-tags"><?=(!empty($data->tags))?$data->tags:''?></textarea>
                      </div>
                    </ul>
                  </li>
                  <li><a href="#" id="publish-page"><?=(empty($data->id))?'Publish':'Update'?></a></li>
                </div>
                <div class="ea-l">
                  <li><span class="<?=(empty($data->id))?'status-draft':'status-published'?>"><?=(empty($data->id))?'Draft':'Published'?></span></li>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->
