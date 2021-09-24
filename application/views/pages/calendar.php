<?php if ( !empty($calendar) ){ foreach ($calendar as $key => $value) { ?>
    <li class="cal-li">
    	<a href="/<?=$value->parent_slug?>/<?=$value->post_slug?>">
        <h3><?=$value->name?></h3>
        <p class="cal-date"><?=date('d M Y', $value->event_date)?> - <?=date('d M Y', $value->end_date)?></p>
    </li>
<?php }} ?>