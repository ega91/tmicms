<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            <div class="panel-body with-table panel-content" data-source="<?=site_url('content/allslides')?>">Memuat data...</div>
          </div>
        </div>
      </div>
      <!-- /page content -->


      <!-- video modal -->
      <div id="SlideModal" class="modal form-modal fade" modal-source="<?=site_url('content/addslide')?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Add Slideshow</h4>
            </div>
            <div class="modal-body">
              <form id="modal-form" 
                method="post" 
                action="<?php echo site_url('content/saveslide')?>" 
                class="modal-form" 
                role="form"
                enctype="multipart/form-data">
                <i class="fa fa-spinner fa-spin fa-fw"></i> Mohon tunggu...
              </form>
            </div>
          </div>
        </div>
      </div>
