	<li class="new-content-content">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][id]" class="content_id" value="<?php echo (!empty($content->id))?$content->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][data_id]" value="<?php echo (!empty($content->data->id))?$content->data->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][content_type]" value="video_embed">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][order_number]" value="<?php echo $content_idx?>">

		<ul class="new-content-action">
			<li><a href="#" class="refresh-new-content"><i class="fa fa-refresh"></i></a></li>
			<li><a href="#" class="sortable-handle"><i class="fa fa-arrows-alt"></i></a></li>
			<li><a href="#" class="collapse-new-content"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down"></i></a></li>
			<li><a href="#" content-id="<?php echo (!empty($content->id))?$content->id:0?>" class="delete-new-content"><i class="fa fa-times"></i></a></li>
		</ul>
		<div class="new-content-title"><i class="fa fa-file-movie-o fa-fw"></i> Embed Video</div>

		<div class="new-content-content-inside">
			<div class="form-group">
				<textarea rows="4" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][embed_code]" class="form-control" placeholder="Video Embed Code"><?php echo (!empty($content->data->embed_code))?$content->data->embed_code:''?></textarea>
				<p class="help-block">Embed code dari video yang akan ditampilkan.</p>
		    </div>

			<div class="form-group">
				<textarea rows="2" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][caption]" 
					placeholder="Caption (optional)"
					class="form-control"><?php echo (!empty($content->data->caption))?$content->data->caption:''?></textarea>
			</div>
		</div>

    </li>
