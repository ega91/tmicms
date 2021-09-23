      <li class="new-content-content">
            <input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][id]" class="content_id" value="<?php echo (!empty($content->id))?$content->id:0?>">
            <input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][data_id]" value="<?php echo (!empty($content->data->id))?$content->data->id:0?>">
      	<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][content_type]" value="map_embed">
      	<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][order_number]" value="<?php echo $content_idx?>">

            <ul class="new-content-action">
                  <li><a href="#" class="refresh-new-content"><i class="fa fa-refresh"></i></a></li>
                  <li><a href="#" class="sortable-handle"><i class="fa fa-arrows-alt"></i></a></li>
                  <li><a href="#" class="collapse-new-content"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down"></i></a></li>
                  <li><a href="#" content-id="<?php echo (!empty($content->id))?$content->id:0?>" class="delete-new-content"><i class="fa fa-times"></i></a></li>
            </ul>
      	<div class="new-content-title">
      		<i class="fa fa-map fa-fw"></i> Embed Map
      	</div>


            <div class="new-content-content-inside">
            	<div class="form-group">
            		<label class="control-label control-label-lg control-label-w-normal text-right">Display Format</label>
            		<div class="gallery-format-chooser">
            			<input type="hidden" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][display_format]" value="<?php echo (!empty($content->data->display_format))?$content->data->display_format:'wide_fs'?>" class="display_format">
            			<div class="gallery-format-item <?php echo (empty($content->data->display_format) or $content->data->display_format == 'wide_fs')?'selected':''?>" value="wide_fs">
            				<img src="<?php echo site_url('resources/images/fs-map.png')?>">
            				<p>Wide Fullscreen</p>
            			</div>
            			<div class="gallery-format-item <?php echo (!empty($content->data->display_format) and $content->data->display_format == 'standard')?'selected':''?>" value="standard">
            				<img src="<?php echo site_url('resources/images/standard-map.png')?>">
            				<p>Standard Map</p>
            			</div>
            			<div class="clearfix"></div>
            		</div>
            	</div>

            	<div class="form-group">
            		<textarea rows="4" name="sections[<?php echo $section_idx?>][contents][<?php echo $content_idx?>][embed_code]" class="form-control" placeholder="Map Embed Code"><?php echo (!empty($content->data->embed_code))?$content->data->embed_code:''?></textarea>
            		<p class="help-block">Embed code dari map yang akan ditampilkan.</p>
                  </div>
            </div>

      </li>

