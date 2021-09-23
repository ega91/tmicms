<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div id='calendar'></div>
        </div>
      </div>
      <!-- /page content -->
      <div class="clearfix"></div>


      <!-- calendar modal -->
      <div id="CalenderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title" id="myModalLabel">Add Calendar</h4>
            </div>
            <div class="modal-body">
              <form id="event-container" 
                method="post" 
                action="<?php echo site_url('event/save')?>" 
                class="form-horizontal calender" 
                role="form">
                <i class="fa fa-spinner fa-spin fa-fw"></i> Please wait...
              </form>
            </div>
          </div>
        </div>
      </div>
