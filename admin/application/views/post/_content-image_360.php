	<li class="new-content-content">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][id]" class="content_id" value="<?php echo (!empty($content->id))?$content->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][data_id]" value="<?php echo (!empty($content->data->id))?$content->data->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][content_type]" value="image_360">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][order_number]" value="<?php echo $content_idx?>">

		<ul class="new-content-action">
			<li><a href="#" class="refresh-new-content"><i class="fa fa-refresh"></i></a></li>
			<li><a href="#" class="sortable-handle"><i class="fa fa-arrows-alt"></i></a></li>
			<li><a href="#" class="collapse-new-content"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down"></i></a></li>
			<li><a href="#" content-id="<?php echo (!empty($content->id))?$content->id:0?>" class="delete-new-content"><i class="fa fa-times"></i></a></li>
		</ul>
		<div class="new-content-title">
			<div class="content-image-360"><span>360<sup>o</sup></span></div>
			Image 360
		</div>

		<div class="new-content-content-inside">
			<div class="form-group">
				<input type="text" 
					name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][title]" 
					class="form-control" 
					placeholder="Title (optional)"
					value="<?php echo (!empty($content->data->title))?$content->data->title:''?>">
			</div>
			<div class="form-group">
				<textarea rows="2" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][description]" 
					placeholder="Description (optional)"
					class="form-control"><?php echo (!empty($content->data->description))?$content->data->description:''?></textarea>
			</div>

			<div class="form-group">
				<div class="row">
		      		<label class="control-label control-label-lg control-label-w-normal col-sm-3">Caption Position</label>
	    	  		<div class="col-sm-9">:
	      				<label><input type="radio" 
	      					value="top" <?php echo (!empty($content->data->caption_valign) and $content->data->caption_valign == 'top')?'checked="checked"':''?>
	      					name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][caption_valign]"> Top</label>
	      				&nbsp; &nbsp;
	      				<label><input type="radio" 
	      					value="bottom" <?php echo (empty($content->data->caption_valign) or $content->data->caption_valign == 'bottom')?'checked="checked"':''?>
	      					name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][caption_valign]"> Bottom</label>
	      			</div>
	      		</div>
				<div class="row">
		      		<label class="control-label control-label-lg control-label-w-normal col-sm-3">Caption Align</label>
	    	  		<div class="col-sm-9">:
	      				<label><input type="radio" 
	      					value="left" <?php echo (!empty($content->data->caption_align) and $content->data->caption_align == 'left')?'checked="checked"':''?>
	      					name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][caption_align]"> <i class="fa fa-align-left"></i> Left</label>
	      				&nbsp; &nbsp;
	      				<label><input type="radio" 
	      					value="center" <?php echo (empty($content->data->caption_align) or $content->data->caption_align == 'center')?'checked="checked"':''?>
	      					name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][caption_align]"> <i class="fa fa-align-center"></i> Center</label>
	      				&nbsp; &nbsp;
	      				<label><input type="radio" 
	      					value="right" <?php echo (!empty($content->data->caption_align) and $content->data->caption_align == 'right')?'checked="checked"':''?>
	      					name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][caption_align]"> <i class="fa fa-align-right"></i> Right</label>
	      			</div>
	      		</div>
			</div>

			<div class="form-group">
	      		<label class="control-label control-label-lg control-label-w-normal text-right">Display Format</label>
	      		<div class="gallery-format-chooser">
					<input type="hidden" 
						class="display_format"
						name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][display_format]" 
						value="<?php echo (!empty($content->data->display_format))?$content->data->display_format:'wide_fs'?>">

	      			<div class="gallery-format-item <?php echo (empty($content->data->display_format) or $content->data->display_format == 'wide_fs')?'selected':''?>" value="wide_fs">
	      				<img src="<?php echo site_url('resources/images/fs-image-360.png')?>">
	      				<p>Wide Fullscreen</p>
	      			</div>
	      			<div class="gallery-format-item <?php echo (!empty($content->data->display_format) and $content->data->display_format == 'standard')?'selected':''?>" value="standard">
	      				<img src="<?php echo site_url('resources/images/jumbo-image-360.png')?>">
	      				<p>Standard Image</p>
	      			</div>
	      			<div class="clearfix"></div>
	      		</div>
	      	</div>

			<div class="form-group">
	      		<label class="control-label control-label-lg control-label-w-normal">Images</label>
				<div class="content-image-container content-image-container-360">
		            <div class="bgimage-display">
		              <img id="chapter-bgimg-1" img-placeholder="<?php echo site_url('resources/images/img-placeholder-wide.png')?>" src="<?php echo (!empty($content->data->image))?$content->data->image->image:site_url('resources/images/img-placeholder-wide.png')?>">
		            </div>
		            <div class="input-bgimage-container">
		              <input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][image]" class="bgimage-input" value="<?php echo (!empty($content->data->image))?$content->data->image->id:0?>">
		              <button type="button" class="media-manager-input btn btn-default btn-flat">
		                <i class="fa fa-image"></i> Set Image
		              </button>
		              <button type="button" class="btn btn-default btn-flat red-color delete-bgimage" chapter-idx="1">
		                <i class="fa fa-trash"></i> Delete Image
		              </button>
		            </div>
				</div>
			</div>
		</div>

    </li>


