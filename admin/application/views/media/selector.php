  

  <div class="media-manager-library-container">
    <div class="row">
      <?php if ( empty($media) ): ?>
        <div class="col-xs-12 col-sm-12">
          <p>Belum ada media ditambahkan.<br />
            <a href="#" class="btn btn-danger table-add-btn add-media-btn"><i class="fa fa-plus-circle"></i> Tambah media</a></p>
        </div>
      <?php else: ?>
        <div class="col-xs-12 col-sm-12">
          <div class="media-manager-library-content">
            <div class="row">
              <?php $this->load->view( 'media/selector_content' ); ?>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3 hidden">
          <div id="media-manager-library-info">
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="media-manager-library-footer">
      <div class="pull-right">
        <button class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm insert-media">Insert Media</button>
      </div>
      <p><b>0 media selected</b></p>
      <div class="clearfix"></div>
    </div>
  </div>
