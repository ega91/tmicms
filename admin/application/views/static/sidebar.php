  <?php $user = $this->session->userdata('user'); ?>
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">
        <a href="<?php echo site_url()?>" class="site_title">
          <img src="/admin/resources/images/mine-logo-white.png"> CMS<span>River</span>
        </a>
      </div>

      <div class="clearfix"></div>

      <!-- menu profile quick info -->
      <div class="profile clearfix">
        <div class="profile_pic">
          <img src="<?php echo site_url('resources/images/user.png')?>" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
          <span>Welcome,</span>
          <h2><?php echo $user->first_name?> <?php echo $user->last_name?></h2>
        </div>
      </div>
      <!-- /menu profile quick info -->

      <?php if (!empty($user->role_data)): ?>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <ul class="nav side-menu">

              <?php if ($user->role_data->broadcast > 0 or $user->role_data->message > 0): ?>
                <h3>Pesan</h3>
                <?php if ($user->role_data->broadcast > 0): ?>
                  <li><a href="<?php echo site_url('messages/broadcast')?>"><i class="fa fa-bullhorn"></i> Broadcast</a></li>
                <?php endif; ?>
                <?php if ($user->role_data->broadcast > 0): ?>
                  <li><a href="<?php echo site_url('messages')?>"><i class="fa fa-comments-o"></i> Pesan<span class="badge" id="badge-message" style="display: none;">0</span></a></li>
                <?php endif; ?>
              <?php endif; ?>

              <?php if ($user->role_data->view_product > 0): ?>
                <h3>Products</h3>
                <li><a href="<?=site_url('content/products')?>">Products</a></li>
                <li><a href="<?=site_url('content/deletedproducts')?>">Deleted Products</a></li>
              <?php endif; ?>

              <?php if ($user->role_data->view_slideshow > 0 or $user->role_data->view_voucher > 0): ?>
                <h3>Promotions</h3>
                <?php if ($user->role_data->view_slideshow > 0): ?>
                  <li><a href="<?=site_url('content/slideshow')?>">Slideshow</a></li>
                <?php endif; ?>
                <?php if ($user->role_data->view_voucher > 0): ?>
                  <li><a href="<?=site_url('content/voucher')?>">Vouchers</a></li>
                  <li><a href="<?=site_url('content/deletedvoucher')?>">Deleted Vouchers</a></li>
                <?php endif; ?>
              <?php endif ?>

              <?php if ($user->role_data->view_article > 0): ?>
                <h3>Articles</h3>
                <li><a href="<?=site_url('articles')?>">Articles <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('articles')?>">Semua Artikel</a></li>
                    <?php if ($user->role_data->edit_article > 0): ?>
                      <li><a href="<?php echo site_url('articles/add')?>">Tambah Artikel <i class="fa fa-plus-circle pull-right"></i></a></li>
                    <?php endif; ?>
                  </ul>
                </li>
              <?php endif; ?>

              <?php if ($user->role_data->view_polis > 0 or $user->role_data->view_trx > 0 or $user->role_data->view_berminat): ?>
                <h3>Purchase</h3>

                <?php if ($user->role_data->view_polis > 0): ?>
                  <li><a href="<?=site_url('content/polis')?>">Polis <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('content/polis')?>">Semua Polis</a></li>
                      <li><a href="<?php echo site_url('content/polis/aktif')?>">Polis Aktif</a></li>
                      <li><a href="<?php echo site_url('content/polis/pending')?>">Menunggu Pembayaran</a></li>
                      <li><a href="<?php echo site_url('content/polis/batal')?>">Gagal/Tidak Dibayar</a></li>
                      <li><a href="<?php echo site_url('content/polis/sudah_berakhir')?>">Sudah Berakhir</a></li>
                    </ul>
                  </li>
                <?php endif; ?>
                <?php if ($user->role_data->view_trx > 0): ?>
                  <li><a href="<?=site_url('content/transactions')?>">Data Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('content/transactions')?>">Semua Transaksi</a></li>
                      <li><a href="<?php echo site_url('content/transactions/success')?>">Pembayaran Sukses</a></li>
                      <li><a href="<?php echo site_url('content/transactions/waiting')?>">Menunggu Pembayaran</a></li>
                      <li><a href="<?php echo site_url('content/transactions/failed')?>">Gagal</a></li>
                    </ul>
                  </li>
                <?php endif; ?>
                <?php if ($user->role_data->view_berminat > 0): ?>
                  <li><a href="<?=site_url('content/buyrequest')?>">Berminat Membeli</a></li>
                <?php endif; ?>
              <?php endif; ?>

              <?php if ($user->role_data->view_claim > 0): ?>
                <h3>Klaim</h3>
                <li><a href="<?=site_url('content/claim')?>">Pengajuan Klaim <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('content/claim')?>">Semua Pengajuan</a></li>
                    <li><a href="<?php echo site_url('content/claim/waiting')?>">Menunggu Persetujuan</a></li>
                    <li><a href="<?php echo site_url('content/claim/aproved')?>">Disetujui</a></li>
                    <li><a href="<?php echo site_url('content/claim/declined')?>">Ditolak</a></li>
                  </ul>
                </li>
              <?php endif; ?>

              <?php if ($user->role_data->view_user > 0): ?>
                <h3>Users</h3>
                <li><a href="<?php echo site_url('user')?>"><i class="fa fa-user"></i> User Terdaftar <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('user')?>">Semua Pengguna</a></li>
                    <!-- <li><a href="<?php echo site_url('user/bought')?>">Pernah Beli</a></li> -->
                    <!-- <li><a href="<?php echo site_url('user/neverbought')?>">Belum Pernah Beli</a></li> -->
                    <!-- <li><a href="<?php echo site_url('user/add')?>">Add User <i class="fa fa-plus-circle pull-right"></i></a></li> -->
                    <!-- <li><a href="<?php echo site_url('user/edit/'. $user->id)?>">Your Profil</a></li> -->
                  </ul>
                </li>
              <?php endif; ?>

              <?php if ($user->role_data->view_media > 0 or $user->role_data->view_admin > 0): ?>
                <h3>Config</h3>
                <?php if ($user->role_data->view_media > 0): ?>
                  <li><a href="<?php echo site_url('media')?>"><i class="fa fa-image"></i> Images <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('media')?>">Library</a></li>
                      <?php if ($user->role_data->view_admin > 0): ?>
                        <li><a href="#" class="add-media-btn"><i class="fa fa-arrow-circle-o-up pull-right"></i> Unggah Media</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                <?php endif; ?>
                <?php if ($user->role_data->view_admin > 0): ?>
                  <li><a href="<?php echo site_url('user/admin')?>"><i class="fa fa-user-secret"></i> Admin <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('user/role')?>">Admin Role</a></li>
                      <li><a href="<?php echo site_url('user/admin')?>">All Admin</a></li>
                    </ul>
                  </li>
                <?php endif; ?>
              <?php endif; ?>

            </ul>
          </div>
        </div>
        <!-- /sidebar menu -->
      <?php endif; ?>

    </div>
  </div>
