
<?php foreach ($data as $key => $value) { ?>
  <div id="post-item-<?=$value->id?>" class="post-item col-md-12">
    <div class="post <?=(!empty($value->featured_image))?'post-with-img':''?>">
      <?php if ( !empty($value->featured_image) ): ?>
        <div class="post-img" style="background-image: url('<?=$value->featured_image->image_blured?>'); background-image: url('<?=$value->featured_image->image_medium?>')"></div>
      <?php endif; ?>
      <div class="post-info">
        <h3 class="p-title"><?=$value->title?></h3>
        <p class="p-description"><?=$value->description?></p>

        <div class="post-action">
          <a href="<?=site_url('articles/edit/'. $value->id)?>"><i class="fa fa-pencil"></i><span class="hidden-xs"> Edit</span></a>
          <a href="#" class="media-action-mid hidden" target="_blank"><i class="fa fa-external-link"></i><span class="hidden-xs"> View</span></a>
          <?php $exlcIDs = Array(1,2,3,4); if ( !in_array($value->id, $exlcIDs) ): ?>
            <a href="#" post-id="<?=$value->id?>" class="delete-post"><i class="fa fa-trash"></i><span class="hidden-xs"> Delete</span></a>
          <?php endif; ?>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
<?php } ?>