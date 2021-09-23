	<li class="new-content-content">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][id]" class="content_id" value="<?php echo (!empty($content->id))?$content->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][data_id]" value="<?php echo (!empty($content->data->id))?$content->data->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][content_type]" value="image_gallery">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][order_number]" value="<?php echo $content_idx?>">

		<ul class="new-content-action">
			<li><a href="#" class="refresh-new-content"><i class="fa fa-refresh"></i></a></li>
			<li><a href="#" class="sortable-handle"><i class="fa fa-arrows-alt"></i></a></li>
			<li><a href="#" class="collapse-new-content"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down"></i></a></li>
			<li><a href="#" content-id="<?php echo (!empty($content->id))?$content->id:0?>" class="delete-new-content"><i class="fa fa-times"></i></a></li>
		</ul>
		<div class="new-content-title">
			<div class="content-image-gallery">
                  <i class="fa fa-image fa-image-1"></i>
                  <i class="fa fa-image fa-image-2"></i>
            </div>
            Images Gellery
		</div>

		<div class="new-content-content-inside">
			<div class="form-group">
	      		<label class="control-label control-label-lg control-label-w-normal text-right">Display Format</label>
	      		<div class="gallery-format-chooser">
					<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][display_format]" value="<?php echo (!empty($content->data->display_format))?$content->data->display_format:'wide_fs'?>" class="display_format">

	      			<div class="gallery-format-item <?php echo (empty($content->data->display_format) or $content->data->display_format == 'wide_fs')?'selected':''?>" value="wide_fs">
	      				<img src="<?php echo site_url('resources/images/fs-image.png')?>">
	      				<p>Wide Fullscreen</p>
	      			</div>
	      			<div class="gallery-format-item <?php echo (!empty($content->data->display_format) and $content->data->display_format == 'standard')?'selected':''?>" value="standard">
	      				<img src="<?php echo site_url('resources/images/jumbo-image.png')?>">
	      				<p>Standard Gallery</p>
	      			</div>
	      			<div class="gallery-format-item <?php echo (!empty($content->data->display_format) and $content->data->display_format == 'big_thumb')?'selected':''?>" value="big_thumb">
	      				<img src="<?php echo site_url('resources/images/jumbo-image-big.png')?>">
	      				<p>Big Thumbnail</p>
	      			</div>
	      			<div class="clearfix"></div>
	      		</div>
	      	</div>

			<div class="form-group">
	      		<label class="control-label control-label-lg control-label-w-normal">Images</label>
				<div class="content-image-container">
					<div class="content-image-item">
						<?php if ( !empty($content->data->images) ){ foreach ($content->data->images as $image) { ?>
							<div class="content-image" style="background-image: url('<?php echo $image->image->image?>');">
								<input type="hidden" 
									class="content-image-input" 
									name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][image_ids][]" 
									value="<?php echo $image->id?>">
								<a href="#" class="close-btn"><i class="fa fa-times"></i></a>
							</div>
						<?php }} ?>
						<div class="content-image content-image-master">
							<input type="hidden" 
								class="content-image-input" 
								name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][images][]" 
								value="0">
							<a href="#" class="close-btn"><i class="fa fa-times"></i></a>
						</div>
					</div>
					<div class="content-image content-image-add add-image-gallery">
						<i class="fa fa-image"></i> Add Image
					</div>
				<div class="clearfix"></div>
				</div>
			</div>
		</div>
    </li>
