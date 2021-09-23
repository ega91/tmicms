  <?php foreach ($media as $key => $value) { ?>
    <div class="col-sm-4 col-xs-6 col-md-4 col-lg-3 media-item-col">
      <div class="media-item load-more-item" item-id="<?=$value->id?>">
        <div edit-id="<?=$value->id?>" class="media-uploaded-item uploaded edit-media" style="background-image: url('<?=$value->image_small?>')">
          <a href="#" class="close-btn"><i class="fa fa-times"></i></a>
        </div>
        <div class="media-action">
          <a href="<?php echo $value->image_original?>" target="_blank"><i class="fa fa-cloud-download"></i><span class="hidden-xs"> Download</span></a>
          <a href="#" edit-id="<?php echo $value->id?>" class="edit-media media-action-mid"><i class="fa fa-eye"></i><span class="hidden-xs"> View</span></a>
          <a href="#" media-id="<?php echo $value->id?>" class="delete-media"><i class="fa fa-trash"></i><span class="hidden-xs"> Hapus</span></a>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  <?php } ?>