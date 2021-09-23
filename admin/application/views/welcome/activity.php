

<?php foreach ($data as $key => $value) { ?>
	<div class="chart-item text-center">
		<div class="val" style="height: <?=(!empty($value))?($value/$max)*100:0?>%"></div>
		<div class="val-text <?=(!empty($value) and (($value/$max)*100) > 30)?'val-text-with-val':''?>">
			<span><?=$value?></span>
			Activity
		</div>
		<span class="key"><?=$key?></span>
	</div>
<?php } ?>