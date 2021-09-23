
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        <?php $this->load->view('static/sidebar'); ?>
        <?php $this->load->view('static/header'); ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="admin-container-sm">
            <?php if ( empty($post_parent) ): echo '<div class="alert alert-danger" style="margin: 0;">Parent data required.</div>'; else: ?>

              <input type="hidden" id="parent-slug" value="<?=$post_parent->slug?>">
              <input type="hidden" name="post_parent" id="post_parent" value="<?=$post_parent->id?>">
              <input type="hidden" name="edit_id" id="edit_id" value="<?=(!empty($data->id))?$data->id:0?>">
              <input type="hidden" name="lang" id="lang" value="<?=(!empty($data->lang))?$data->lang:$this->input->get('lang')?>">
              <input type="hidden" name="featured_image" id="featured_image" value="<?=(!empty($data->featured_image))?$data->featured_image->id:0?>">

              <div class="clearfix"></div>
              <div class="add-form-container">

                <div class="row">
                  <div class="col-sm-offset-2 col-sm-7 col-editor">

                    <div class="form-group">
                      <textarea type="text" id="post-title" class="form-control input-lg post-title with-placeholder" placeholder="Title here..." rows="1"><?=(!empty($data->title))?$data->title:''?></textarea>
                    </div>

                    <?php $data->display_author = 1; ?>
                    <?php if (isset($data->display_author) and $data->display_author == 0): ?>
                    <?php else: ?>
                      <?php $month = Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'); ?>
                      <div id="article-user" class="article-user form-group">
                        <img src="/admin/resources/images/user.png" alt="" class="hidden">
                        <div class="au-name" style="padding-left: 0;"><span class="hidden"><?=$author->first_name?> <?=$author->last_name?></span>
                          <div class="au-date">
                            <div class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="ed-month"><?=(!empty($data->publish_date))?$month[date('n', $data->publish_date) -1]:$month[date('n') -1]?></a>
                              <ul class="dropdown-menu">
                                <?php foreach ($month as $key => $value) {
                                  echo '<li><a href="#" value="'. ($key +1) .'">'. $value .'</a></li>';
                                } ?>
                              </ul>
                            </div>
                            <div class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="ed-date"><?=(!empty($data->publish_date))?date('d', $data->publish_date):date('d')?></a>
                              <ul class="dropdown-menu">
                                <?php for ($i=1; $i < 32; $i++) {
                                  echo '<li><a href="#">'. $i .'</a></li>';
                                } ?>
                              </ul>
                            </div>
                            <span id="ed-year"><?=date('Y')?></span> at 
                            <div class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="ed-hour"><?=(!empty($data->publish_date))?date('h', $data->publish_date):date('h')?></a>
                              <ul class="dropdown-menu">
                                <?php for ($i=1; $i < 13; $i++) { 
                                  $_i = $i;
                                  if ( $i < 10 ) $_i = '0'. $_i;
                                  echo '<li><a href="#">'. $_i .'</a></li>';
                                } ?>
                              </ul>
                            </div>:<div class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="ed-minute"><?=(!empty($data->publish_date))?date('i', $data->publish_date):date('i')?></a>
                              <ul class="dropdown-menu">
                                <?php for ($i=0; $i < 61; $i++) { 
                                  $_i = $i;
                                  if ( $i < 10 ) $_i = '0'. $_i;
                                  echo '<li><a href="#">'. $_i .'</a></li>';
                                } ?>
                              </ul>
                            </div><div class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="ed-ampm"><?=(!empty($data->publish_date))?date('a', $data->publish_date):date('a')?></a>
                              <ul class="dropdown-menu d-ampm">
                                <li><a href="#">am</a></li>
                                <li><a href="#">pm</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <p class="au-about hidden">Life is all about live</p>
                        <div class="clearfix"></div>
                      </div>
                    <?php endif; ?>

                    <div class="form-group">
                      <div class="ce-am-container">
                        <div class="am-container">
                          <div class="open-am"></div>
                          <div class="am-btn-container">
                            <div class="am-btn am-btn-img"><i class="fa fa-image"></i></div>
                            <div class="am-btn am-btn-video"><i class="fa fa-youtube"></i></div>
                            <?php /*<div class="am-btn am-btn-map"><i class="fa fa-map"></i></div>*/ ?>
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
            <?php endif; ?>
          </div>
        </div>

        <div id="editor-action">
          <div class="container">
            <div class="row">
              <div class="col-sm-7 col-sm-offset-2">
                <div class="pull-right ea-r">

                  <?php /**
                  <li class="dropup editor-cat-cnt">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="ed-category">Category <i class="fa fa-angle-up"></i></a>
                    <ul class="dropdown-menu editor-cat-ddm">
                      <div id="category-wrapper">
                        <?php foreach ($category as $key => $value) {
                          echo '<li cat-id="'. $value->id .'"><a href="#" value="'. $value->id .'" class="';
                          if ( (!empty($data->categories)) and in_array($value, $data->categories) )
                            echo 'selected';
                          echo ' cat-name">'. $value->name .'</a>';
                          if ( $value->post_parent > 0 )
                            echo '<span class="edit-cat"><i class="fa fa-pencil"></i></span><span class="delete-cat"></span>';
                          echo '</li>';
                        } ?>
                      </div>
                      <li role="separator" class="divider"></li>
                      <li><a href="#" class="add-post-category" post-parent="<?=$post_parent->id?>"><i class="add-icon"></i> Add category</a></li>
                    </ul>
                  </li>
                  */ ?>

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
                        <?php /**
                        <div class="addpost-publish-item">
                          Author
                          <div><?=(!empty($data->author))?$data->author->first_name.' '.$data->author->last_name:' '?></div>
                        </div>
                        */ ?>

                        <?php /**
                        <div class="addpost-publish-item">
                          Display Author
                          <div>
                            <div class="toggle <?=(isset($data->display_author) and $data->display_author == 0)?'off':'on'?> display-author" value="<?=(isset($data->display_author) and $data->display_author == 0)?'off':'on'?>">
                              <div class="toggle-handle"></div>
                            </div>
                          </div>
                        </div>
                        */ ?>

                        <?php /**
                        <div class="addpost-publish-item">
                          Allow Comment
                          <div>
                            <div class="toggle <?=(isset($data->allow_comment) and $data->allow_comment == 0)?'off':'on'?> allow-comment" value="<?=(isset($data->allow_comment) and $data->allow_comment == 0)?'off':'on'?>">
                              <div class="toggle-handle"></div>
                            </div>
                          </div>
                        </div>
                        */ ?>

                      </div>
                      <div class="edcf edcf-tags">
                        <h3>Tags</h3>
                        <p>Add tag in field below, separate by comma.</p>
                        <textarea class="form-control" placeholder="Add tag here..." id="ed-tags"><?=(!empty($data->tags))?$data->tags:''?></textarea>
                      </div>

                      <div class="edcf edcf-featured-img">
                        <h3>Featured Image</h3>
                        <p>Select which image you want to make it become featured image <a href="#"><i class="fa fa-question-circle"></i></a></p>
                        <div id="featured-img-cnt"></div>
                      </div>

                    </ul>
                  </li>
                  <li><a href="#" id="publish-post"><?=(empty($data->id))?'Publish':'Update'?></a></li>
                </div>
                <div class="ea-l">

                  <?php /**
                  <li class="dropup">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="ed-lang">Language: <span><?=(!empty($data->lang) and $data->lang == 'id')?'ID':'EN'?></span> <i class="fa fa-angle-up"></i></a>
                    <ul class="dropdown-menu">
                      <li><a href="#" class="change-lang" lang="en" post-parent="<?=$post_parent->id?>">English</a></li>
                      <li><a href="#" class="change-lang" lang="id" post-parent="<?=$post_parent->id?>">Bahasa Indonesia</a></li>
                    </ul>
                  </li>
                  */ ?>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->
