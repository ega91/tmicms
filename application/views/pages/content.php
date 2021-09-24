

<?php if (empty($data)): ?>
	<div class="alert alert-grey alert-with-padding">No result found.</div>
<?php else: foreach ($data as $key => $value) { ?>
	<div class="card-item">
		<div class="card-wrapper">
			<div class="card-head">
				<div class="card-user-pict">
					<img src="/resources/img/user.png">
				</div>
				<div class="card-user-name"><a href="#"><?=$value->author->first_name .' '. $value->author->last_name?></a></div>
			</div>
			<div class="card-img" style="background-image: url('<?=(!empty($value->featured_image))?str_replace("'", "\'", $value->featured_image->image_270):'/resources/img/placeholder.jpg'?>');">
				<div class="card-category">mobilisation</div>
			</div>
			<div class="card-content">
				<h3><?=$value->title?></h3>
			</div>
			<div class="card-foot">
				<a href="/<?=$value->parent->slug?>/<?=$value->slug?>" class="btn btn-block btn-default btn-card">View Movement</a>
			</div>
		</div>
	</div>
<?php } endif; ?>