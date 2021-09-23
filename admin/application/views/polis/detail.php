<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            <?php $this->load->view('polis/content_detail'); ?>

            <a href="<?=site_url('content/polisdetail/'. $data->id .'?print=data')?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Print Informasi Ini</a>
            <a href="<?=site_url('content/polisdetail/'. $data->id .'?download=pdf')?>" class="btn btn-default" target="_blank"><i class="fa fa-download"></i> Download PDF Polis</a>

          </div>
        </div>
      </div>
      <!-- /page content -->
