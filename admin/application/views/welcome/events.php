
<div class="welcome-event">
	<?php if ( empty($data) ): ?>
		<p class="help-block">Tidak ada acara untuk bulan ini.</p>
	<?php else: foreach ($data as $key => $value) { ?>
		<div class="event-item">
			<div class="event-img" style="background-image: url(<?php echo (!empty($value->poster->image_270))?"'".$value->poster->image_270."'":'/admin/resources/images/img-placeholder-poster.png'?>);"></div>
			<div class="pull-right event-view-detail">
				<a href=""><i class="fa fa-angle-right"></i></a>
			</div>
			<h3><?php echo $value->name?></h3>
			<p><?php echo substr($value->description, 0, 120)?></p>
			<div class="event-item-date"><?=(date('H:i:s', $value->event_date) == '00:00:00')?date('Y-m-d', $value->event_date):date('Y-m-d H:i:s', $value->event_date)?> - <?=(date('H:i:s', $value->end_date) == '00:00:00')?date('Y-m-d', $value->end_date):date('Y-m-d H:i:s', $value->end_date)?></div>
		</div>
	<?php } endif; ?>
</div>