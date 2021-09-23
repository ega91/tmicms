
  <?php $user = $this->session->userdata('user'); ?>
  <div id="upload-progress-header" class="upload-progress">
    <div class="upload-progress-spiner"><span></span></div>
    <span class="upload-progress-percent">20%</span>
  </div>
  <div id="upload-progress-2"></div>

  <!-- top navigation -->
  <div class="top_nav">
    <div class="nav_menu">
      <nav>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="<?php echo site_url('resources/images/user.png')?>" alt="<?php echo $user->first_name?> <?php echo $user->last_name?>">
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a href="<?php echo site_url('user/edit/'. $user->id)?>"> Edit Profile</a></li>

              <?php /**
              <li style="background: #eee;"><a style="color: #bbb" href="#">Display Setting</a></li>
              <li style="background: #eee;"><a style="color: #bbb" href="#">Content Setting</a></li>
              <li style="background: #eee;"><a style="color: #bbb" href="#">Web Setting</a></li>
              */ ?>

              <li><a href="/" target="_blank">View site</a></li>
              <li><a href="<?php echo site_url('user/logout')?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
            </ul>
          </li>
          <li class="li-ping-status">
            <div class="ping-status"></div>
            Ping <span id="ping-ms">36ms</span>
          </li>
        </ul>
        <button class="menu-toggle">
          <div class="line-1"></div>
          <div class="line-2"></div>
          <div class="line-3"></div>
        </button>
        <?=(!empty($title))?'<h1 class="adm-page-title">'.$title.'</h1>':''?>
      </nav>
    </div>
  </div>
  <!-- /top navigation -->