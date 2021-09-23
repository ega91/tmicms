<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            <div class="panel-body with-table">
              <?php if ( empty($users) ): ?>
                <p class="help-block panel-body-p">User not found.</p>
              <?php else: ?>

                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Kota</th>
                      <th>Tanggal Daftar</th>
                      <th>Terakhir Login</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $key => $value) { ?>
                      <tr class=" <?php echo (!empty($value->banned))?'banned':''?>">
                        <td>
                          <div class="user-img-container">
                            <span></span>
                            <img src="<?php echo (!empty($value->profile_picture_thumb))?$value->profile_picture_thumb:'/resources/user/thumb/user-placeholder.png'?>">
                          </div>
                          <div class="book-info-container user-info-container">
                            <h3 class="td-title"><?php echo $value->first_name?> <?php echo $value->last_name?></h3>
                            <p><?php echo $value->email?><?php echo (!empty($value->is_email_verified))?' <i class="green-color fa fa-check-circle-o"></i>':''?></p>

                            <div class="user-label-container">
                              <?php if ( !empty($value->is_admin)): ?>
                                <span class="user-label label label-warning">Admin</span>
                              <?php endif; ?>
                              <span class="banned-label user-label label label-danger">Banned</span>
                            </div>

                            <div class="table-action-container">
                              <a href="<?php echo site_url('user/edit/'. $value->id)?>"><i class="fa fa-pencil"></i> Edit</a> &bull;
                              <a href="#" class="delete-user" user-id="<?php echo $value->id?>"><i class="fa fa-trash"></i> Hapus</a>
                              <a href="#" user-id="<?php echo $value->id?>" class="hidden <?php echo (empty($value->banned))?'ban':'unban'?>-user"><i class="fa fa-<?php echo (empty($value->banned))?'ban':'unlock'?>"></i> <?php echo (empty($value->banned))?'Ban':'Unban'?> User</a>
                            </div>
                          </div>
                        </td>
                        <td><?=(!empty($value->location))?$value->location:''?></td>
                        <td><?php echo ($value->registered_date > 0)?date('Y-m-d', $value->registered_date):'-'?></td>
                        <td><?php echo ($value->last_login > 0)?date('Y-m-d', $value->last_login):'-'?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>

              <?php endif; ?>
            </div>
            <div class="panel-footer with-pagination text-center">
              <?php $this->load->view( 'static/pagination', Array( 'data' => Array('__meta' => $__meta), 'page_uri' => '/admin/user' ) ); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->
