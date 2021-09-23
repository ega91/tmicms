
<body class="nav-md">
<div class="container body">
  <div class="main_container">

    <?php $this->load->view('static/sidebar'); ?>
    <?php $this->load->view('static/header'); ?>

    <!-- page content -->
    <div class="right_col" role="main">
      <div class="admin-container-sm">
        <div class="media-library">
          <div class="row">
            <?php if ( empty($media) ): ?>
              <div class="col-sm-12">
                <p>Belum ada media ditambahkan.</p>
              </div>
            <?php else: ?>
              <div id="load-more-container" load-uri="<?php echo site_url('media?'. http_build_query($this->input->get()))?>">
                <?php $this->load->view( 'media/gallery_item' ); ?>
              </div>
              <div id="load-more-bottom"></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /page content -->
