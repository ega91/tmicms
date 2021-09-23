<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            <div class="panel-body with-table panel-content" data-source="<?=site_url('content/allbuyrq')?>">Memuat data...</div>
          </div>
        </div>
      </div>
      <!-- /page content -->

      <div id="ModalBerminatNote" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Catatan Untuk Follow Up</h3>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
              <textarea class="form-control" id="follow-up-note" rows="4" placeholder="Catatan..."></textarea>
              <p></p>
              <div class="text-right">
                <button class="btn btn-default" data-dismiss="modal">Batal</button> 
                <button class="btn btn-primary" id="modal-btn-follow-up">Follow Up</button>
              </div>
            </div>
          </div>
        </div>
      </div>

