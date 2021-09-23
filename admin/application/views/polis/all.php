<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            <?php $query = ($page != 'all') ? $query = 'status='. $page :''; ?>
            <div class="panel-body with-table panel-content" data-source="<?=site_url('content/allpolis?'. $query)?>">Memuat data...</div>
          </div>
        </div>
      </div>
      <!-- /page content -->
