
  <body class="login">

    <div id="login-cnt">
      <div class="container">
        <section class="login_content">
          <form method="post" action="<?php echo site_url('user/signing_in')?>">
            <div class="login-logo">
              <img src="/admin/resources/images/mine-logo.png">
              CMS<span>River</span>
            </div>
            <h2>Sign In</h2>
            <p>Sign in to access your account</p>
            <?php if ( $this->session->flashdata( 'error' ) != null ): ?>
              <div class="alert alert-danger"><?php echo $this->session->flashdata('error')?></div>
            <?php endif; ?>
            <div>
              <input type="text" name="email" class="form-control" placeholder="Email" required="" value="<?php echo $this->session->flashdata('email')?>" />
            </div>
            <div>
              <input type="password" name="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <button type="submit" class="btn btn-primary submit btn-block btn-lg">Sign In</button>
              <p></p>
              <div class="pull-right">
                <a href="#" class="forgot-password">Lost your password?</a>
            </div>
            <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>

            <div class="separator" style="border: none;">
              <p class="change_link hidden">New to site?
                <a href="#signup" class="to_register"> Create Account </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <div class="text-center">
                </div>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>

    <p>&nbsp;</p>
  </body>
</html>
