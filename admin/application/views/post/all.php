<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">

          <?php if ( !empty($category) ): ?>
            <div class="category-filter">
              <h3>Category:</h3>
              <ul id="cat-filter" parent-id="<?=$parent->id?>">
                <?php $this->load->view('post/category'); ?>
              </ul>
              <div class="clearfix"></div>
            </div>
          <?php endif; ?>

          <div class="table-header" style="margin: 10px 0 0; padding: 0;">
            <div class="pull-right">
              <a href="#" class="page-prev page-pagination btn btn-default" 
                <?=(empty($prev))?'disabled="true"':'page-uri="'. $prev .'"'?>><i class="fa fa-chevron-left"></i></a>
              <a href="#" class="page-next page-pagination btn btn-default" 
                <?=(empty($next))?'disabled="true"':'page-uri="'. $next .'"'?>><i class="fa fa-chevron-right"></i></a>
              <a href="#" class="page-goto btn btn-default" style="margin: 0;">Go To Page</a>
            </div>
            <a href="#" class="reload-table btn btn-default"><i class="fa fa-history"></i></a>
          </div>

          <?php if ( empty($data) ): ?>
            <div class="no-data-center">
              <div class="no-data-content">
                <i class="fa fa-file-text-o"></i>
                <h3>There is no <?=$parent->name?> added yet.</h3>
                <a href="<?=site_url('articles/add')?>" class="btn btn-primary btn-lg"> Add new <?=$parent->name?></a>
              </div>
            </div>
          <?php else: ?>
            <div class="posts">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group"><a href="<?=site_url('articles/add')?>" class="btn btn-default btn-add-modal btn-block"><i class="fa fa-plus"></i> Tambah Artikel</a></div>
                </div>
                <?php $this->load->view('post/all_data'); ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <!-- /page content -->


      <div class="modal fade" id="category-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">All Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul class="cat-filter-modal" parent-id="<?=$parent->id?>">
                <?php foreach ($category as $key => $value) {
                  echo '<li cat-id="'. $value->id .'"><a href="#" class="cat-name">'. $value->name .'</a>';
                  if ( $value->post_parent > 0 )
                    echo '<span class="edit-cat"><i class="fa fa-pencil"></i></span><span class="delete-cat"></span>';
                  echo '</li>';
                } ?>
              </ul>
              <li class="cat-filter-add"><i class="add-icon"></i> Add Category</li>
            </div>
          </div>
        </div>
      </div>
