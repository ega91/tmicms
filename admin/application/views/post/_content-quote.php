	<li class="new-content-content">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][id]" class="content_id" value="<?php echo (!empty($content->id))?$content->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][data_id]" value="<?php echo (!empty($content->data->id))?$content->data->id:0?>">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][content_type]" value="quote">
		<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][order_number]" value="<?php echo $content_idx?>">

		<ul class="new-content-action">
			<li><a href="#" class="refresh-new-content"><i class="fa fa-refresh"></i></a></li>
			<li><a href="#" class="sortable-handle"><i class="fa fa-arrows-alt"></i></a></li>
			<li><a href="#" class="collapse-new-content"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down"></i></a></li>
			<li><a href="#" content-id="<?php echo (!empty($content->id))?$content->id:0?>" class="delete-new-content"><i class="fa fa-times"></i></a></li>
		</ul>
		<div class="new-content-title"><i class="fa fa-quote-right fa-fw"></i> Quote</div>
		<div class="new-content-content-inside">
			<div class="form-group">
				<textarea rows="4" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][quote]" 
					placeholder="Write text here..."
					class="form-control"><?php echo (!empty($content->data->quote))?$content->data->quote:''?></textarea>
			</div>

			<div class="form-group">
				<input type="text" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][quote_by]" class="form-control" placeholder="Quote by (optional)" value="<?php echo (!empty($content->data->quote_by))?$content->data->quote_by:''?>">
			</div>
		</div>

    </li>

