
	<li class="new-content-content" content-idx="<?php echo $content_idx?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][id]" class="content_id" value="<?php echo (!empty($content->id))?$content->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][data_id]" value="<?php echo (!empty($content->data->id))?$content->data->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][content_type]" value="article">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][order_number]" value="<?php echo $content_idx?>">

		<ul class="new-content-action">
			<li><a href="#" class="refresh-new-content"><i class="fa fa-refresh"></i></a></li>
			<li><a href="#" class="sortable-handle"><i class="fa fa-arrows-alt"></i></a></li>
			<li><a href="#" class="collapse-new-content"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down"></i></a></li>
			<li><a href="#" content-id="<?php echo (!empty($content->id))?$content->id:0?>" class="delete-new-content"><i class="fa fa-times"></i></a></li>
		</ul>
		<div class="new-content-title">
			<i class="fa fa-file-text-o fa-fw"></i> Text Article
		</div>

		<div class="new-content-content-inside">
			<div class="form-group">
				<textarea name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][article]" 
					placeholder="Write text here..."
					class="tinymce form-control"><?php echo (!empty($content->data->article))?$content->data->article:''?></textarea>
			</div>
		</div>
    </li>

