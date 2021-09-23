
<?php if (empty($data)): ?>
  <p>Belum ada pesan untuk saat ini.</p>
<?php else: foreach ($data as $key => $value) { ?>
  <div class="mu mu-inbox" data-id="<?=$value->id?>" data-to="" data-sender="<?=(!empty($value->user))?$value->user->full_name:'Unregistered User'?>">
    <div class="user-img"></div>
    <div class="mu-content">
      <div class="pull-right">
      	<p class="mu-date"><?=(date('Y-m-d', $value->timestamp) == date('Y-m-d'))?date('H:i', $value->timestamp):date('d-m-Y', $value->timestamp)?></p>
      	<div class="inbox-unread" style="display: <?=(!empty($value->unread_from))?'block':'none'?>"></div>
      </div>

      </div>
      <h3><?=(!empty($value->user))?$value->user->full_name:'Unregistered User'?></h3>
      <p><?=$value->body?></p>
    </div>
  </div>
<?php } endif; ?>