<?php foreach ($category as $key => $value) {
	echo '<li><a href="">'. $value->name .'</a></li>';
} ?>
<li><a href="#" class="cat-filter-option" data-toggle="modal" data-target="#category-modal"><i class="fa fa-ellipsis-h"></i></a></li>
