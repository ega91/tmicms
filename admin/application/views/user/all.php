<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            <div class="panel-body with-table panel-content" data-source="<?=site_url('user/alluser')?>">
              Memuat data...
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->


      <div id="VoucherModal" class="modal form-modal fade" modal-source="<?=site_url('user/adduser')?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Tambah/Edit Pengguna</h4>
            </div>
            <div class="modal-body">
              <form id="modal-form" 
                method="post" 
                action="<?php echo site_url('user/save')?>" 
                class="modal-form" 
                role="form">
                <i class="fa fa-spinner fa-spin fa-fw"></i> Mohon tunggu...
              </form>
            </div>
          </div>
        </div>
      </div>

      <div id="TempChangePassModal" class="modal temp-change-pass-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center" style="padding: 60px 30px;">
              <div class="loading" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; background: #fff; padding-top: 100px;">Mohon tunggu...</div>
              <p style="font-size: 16px;">Selama 30 detik password diganti dengan <b>12345678</b> dan akan diganti kembali ke password awal user setelah 30 detik.</p>
              <h2 id="temp-pass-tick" style="font-size: 40px; margin-top: 20px;">30 detik</h2>
            </div>
          </div>
        </div>
      </div>

