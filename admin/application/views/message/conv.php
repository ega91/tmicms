<?php if (!empty($data)): foreach ($data as $key => $value) { ?>
	<div class="message <?=(empty($value->is_me))?'message-l':'message-r'?>">
		<div class="user-img"></div>
		<div class="the-message">
			<div class="the-buble">
				<h3><?=(empty($value->is_me))?$sender:$value->message_from?></h3>
				<p class="the-p"><?=$value->body?></p>
			</div>
			<p class="message-date"><?=date('H:i', $value->timestamp+25200)?></p>
		</div>
	</div>
<?php } endif; ?>
