<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            
            <?php $this->load->view('claim/detail_content'); ?>

            <div class="detail-action-cnt">
              <?php if ($data->polis->claim_status == 'pending'): ?>
                <button class="btn btn-primary approve-claim" claim-id="<?=$data->id?>">Setujui Pengajuan Klaim</button>
                <button class="btn btn-danger reject-claim" claim-id="<?=$data->id?>">Tolak Pengajuan Klaim</button>
              <?php endif; ?>
              <a class="btn btn-default" href="<?=site_url('content/claimdetail/'. $data->id .'?print=data')?>" target="blank"><i class="fa fa-print"></i> Print</a>
            </div>
  
          </div>
        </div>
      </div>
      <!-- /page content -->

      <div id="ModalClaimStatus" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Pesan Untuk Pengaju Klaim</h3>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
              <textarea class="form-control" id="claim-status-message" rows="4" placeholder="Pesan..."></textarea>
              <p class="help-block">Isi pesan yang akan dikirim ke pengaju klaim, jika pesan kosong maka akan menggunakan pesan default</p>
              <div class="text-right">
                <button class="btn btn-default" data-dismiss="modal">Batal</button> 
                <button class="btn btn-primary" id="modal-btn-approve">Setujui Pengajuan Klaim</button>
                <button class="btn btn-danger" id="modal-btn-decline">Tolak Pengajuan Klaim</button>
              </div>
            </div>
          </div>
        </div>
      </div>

