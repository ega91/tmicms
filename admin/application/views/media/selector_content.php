<?php foreach ($media as $key => $value) { ?>
<div class="col-sm-3 col-xs-6 col-md-2">
  <div class="media-item media-item-selector" 
    media-id="<?php echo $value->id?>" 
    image-uri="<?php echo $value->image_small?>"
    image-original="<?php echo $value->image_original?>"
    image-920="<?php echo $value->image_big?>">

    <div class="media-uploaded-item uploaded" style="background-image: url('<?php echo $value->image_small?>')">
      <a href="#" class="close-btn"><i class="fa fa-times"></i></a>
    </div>
  </div>
</div>
<?php } ?>
