
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            &copy; <?=date('Y')?> CMSRiver
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <div class="modal fade media-manager" id="media-manager" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="upload-media-btn"><i class="fa fa-upload"></i> Upload</button>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
            <h4 class="modal-title">Media Manager</h4>
          </div>
          <div class="modal-body">

            <div id="media-manager-library">
              <div class="media-editor-loading">
                <p><i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></p>
                <p>Loading...</p>
              </div>
            </div>

            <div id="media-manager-upload">
              <form action="<?php echo site_url('media/upload')?>" method="post" enctype="multipart/form-data" id="form-uploader">
                <div class="file-selector-container">
                  <input type="file" name="images[]" multiple="true" id="file-selector" class="file-selector">
                </div>
              </form>
              <div id="media-dropzone">
                <h3>Drop files here to upload</h3>
                <p>Allowed file types: jpg, jpeg, png, gif.</p>
                <p>or</p>
                <button type="button" class="btn btn-default btn-lg open-file-selector"><i class="fa fa-folder-open-o"></i> Select File</button>
              </div>
              <div id="media-upload-progress">
                <div class="media-uploaded">
                  <div id="media-uploaded-item" class="media-uploaded-item">
                    <a href="#" class="close-btn"><i class="fa fa-times"></i></a>
                    <div class="failed-upload-container">
                      <span>Upload failed</span>
                    </div>
                    <div class="uploading-progress">
                      <div class="uploading-label">Uploading <span>0</span> images</div>
                      <div class="upload-progress-2"></div>
                      <div class="upload-progress">
                        <div class="upload-progress-spiner"><span></span></div>
                        <span class="upload-progress-percent">0%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="modal fade media-manager" id="media-editor" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <h4 class="modal-title">Media Editor</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" style="text-align: center;"></div>
            <div class="media-editor-loading">
              <p><i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></p>
              <p>Loading...</p>
            </div>
            <div id="media-editor-container">
              <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-9">
                  <div class="editor-image-container">
                    <img id="editor-image">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3">
                  <div class="editor-info-container">
                    <form method="post" action="<?php echo site_url('media/edit')?>" class="ajax-form" success-uri="<?php echo site_url('media')?>">
                      <input type="hidden" name="edit_id" id="media_edit_id" value="0">
                      <div class="alert-danger alert" style="display: none; margin: -20px; margin-bottom: 10px;"></div>

                      <div class="editor-file-info">
                        <table>
                          <tr>
                            <td><span class="editor-file-info-label">File size</span></td><td>: <span id="editor-file-file_size"></span></td>
                          </tr>
                          <tr>
                            <td><span class="editor-file-info-label">File type</span></td><td>: <span id="editor-file-file_type"></span></td>
                          </tr>
                        </table>
                      </div>

                      <div class="text-right">
                        <a href="#" class="red-color delete-media delete-from-modal"><i class="fa fa-trash"></i> Hapus</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="need-login" style="display: none;">
      <div id="login-cnt">
        <div class="container">
          <section class="login_content">
            <form method="post" id="need-login-form" action="<?php echo site_url('user/resignin')?>">
              <div class="login-logo">
                <img src="/admin/resources/images/mine-logo.png">
                CMS<span>River</span>
              </div>
              <h2>Sign In</h2>
              <p>Session expired, please login again</p>

              <div class="alert alert-danger signin-error" style="display: none;"></div>
              <div>
                <input type="text" name="email" class="form-control" placeholder="Email" required="" value="<?php echo $this->session->flashdata('email')?>" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-primary btn-signin submit btn-block btn-lg">Sign In</button>
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

    </div>

    <div id="ViewModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          </div>
          <div class="modal-body">
            <div id="view-container">
              <i class="fa fa-spinner fa-spin fa-fw"></i> Mohon tunggu...
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="image-preview">
      <div class="image-preview-print"><a href="#" target="_blank"><i class="fa fa-print"></i></a></div>
      <div class="image-preview-close"><i class="fa fa-times"></i></div>
      <div class="img-content">Memuat...</div>
    </div>

    <div id="FilterModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Filter</h4>
          </div>
          <div class="modal-body">
            <form id="filter-form" 
              method="post"
              action="<?php echo site_url('user/filteruser')?>" 
              class="filter-form" 
              role="form">
              <i class="fa fa-spinner fa-spin fa-fw"></i> Mohon tunggu...
            </form>
          </div>
        </div>
      </div>
    </div>



    <div class="loading-full"><span>Menyimpan...</span></div>
    <!-- jQuery -->
    <script   
      src="https://code.jquery.com/jquery-1.12.3.min.js"   
      integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ="   
      crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script type="text/javascript">var SITE_URL = '<?php echo site_url()?>';</script>
    <?php if ( !empty($js) ){ foreach ($js as $key => $value) {
      echo '<script src="'. $value .'"></script>';
    }} ?>

    <!-- PNotify -->
    <script src="<?php echo site_url('resources/js/pnotify.custom.min.js')?>"></script>

    <!-- Jquery Form -->
    <script src="<?php echo site_url('resources/js/jquery.form.min.js')?>"></script>

    <script src="<?php echo site_url('resources/js/howler.min.js')?>"></script>
    <script src="<?php echo site_url('resources/js/bootstrap-datepicker.min.js')?>"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo site_url('resources/js/custom.js')?>"></script>
    <script src="<?php echo site_url('resources/js/gg.js')?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.0/socket.io.js"></script>
    <script src="/admin/resources/js/message.js"></script>
  </body>
</html>
