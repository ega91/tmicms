<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">

          <div class="message-input" style="display: none;">
            <form method="post" action="" id="message-form">
              <div contenteditable="true" class="form-control" id="message-input" autocomplete="off" placeholder="Type message here..."></div>
              <button type="submit" class="btn btn-default">Send</button>
            </form>
          </div>

          <div class="panel panel-default admin-content-panel">
            <div class="row">
              <div class="col-sm-4">
                <div class="message-user">
                  <div class="conv-cnt">

                    <div class="mu mu-inbox" data-id="1" data-to="bc_all">
                      <div class="user-img broadcast-icon"></div>
                      <div class="mu-content">
                        <h3>Semua Pengguna App</h3>
                        <p>Kirim pesan ke semua pengguna</p>
                      </div>
                    </div>
                    <div class="mu mu-inbox" data-id="1" data-to="bc_registered">
                      <div class="user-img broadcast-icon"></div>
                      <div class="mu-content">
                        <h3>Pengguna Terdaftar</h3>
                        <p>Kirim pesan ke pengguna terdaftar</p>
                      </div>
                    </div>
                    <div class="mu mu-inbox" data-id="1" data-to="bc_unregistered">
                      <div class="user-img broadcast-icon"></div>
                      <div class="mu-content">
                        <h3>Tidak Terdaftar</h3>
                        <p>Kirim pesan ke pengguna belum terdaftar</p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-sm-8">
                <div class="message-content" style="display: none;">

                  <div class="message message-l">
                    <div class="user-img"></div>
                    <div class="the-message">
                      <div class="the-buble">...</div>
                      <p class="message-date"><?=date('h:ia')?></p>
                    </div>
                  </div>

                  <div class="message message-r">
                    <div class="user-img"></div>
                    <div class="the-message">
                      <div class="the-buble">
                        <h3>Endang Edie</h3>
                        <p class="the-p">Hello, welcome to the jungle</p>
                      </div>
                      <p class="message-date"><?=date('h:ia')?></p>
                    </div>
                  </div>

                  <div class="message message-l">
                    <div class="user-img"></div>
                    <div class="the-message">
                      <div class="the-buble">
                        <h3>Endang Edie</h3>
                        <p class="the-p">Hello, welcome to the jungle</p>
                      </div>
                      <p class="message-date"><?=date('h:ia')?></p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->
