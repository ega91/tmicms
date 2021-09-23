
<input type="hidden" name="id" value="<?php echo (!empty($data))?$data->id:0?>">
<input type="hidden" name="policy" id="policy" value="<?=(!empty($data->policy))?$data->policy:''?>">

<div class="alert alert-danger" style="display: none;"></div>

<div class="form-group">
  <div class="row">
    <div class="col-sm-12">
      <div class="slide-img view-product-img <?=(!empty($data->image->image_medium))?'has-image':''?>" style="<?=(!empty($data->image->image_medium))?'background-image: url('. $data->image->image_blured .');':''?> <?=(!empty($data->image->image_medium))?'background-image: url('. $data->image->image_medium .');':''?>"></div>
    </div>
  </div>
</div>

<div class="form-group">
  <h4><?=(!empty($data->name))?$data->name:''?></h4>
  <p class="help-block"><?=(!empty($data->descriptions))?$data->descriptions:''?></p>
</div>

<div class="panel-group panel-group-product" id="accordion" role="tablist" aria-multiselectable="true">
  <?php if ( !empty($data->info) ){ foreach ($data->info as $key => $value) { ?>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$key?>">
            <?=$value->title?>
          </a>
        </h4>
      </div>
      <div id="collapse-<?=$key?>" class="panel-collapse collapse <?=($key==0)?'in':''?>" role="tabpanel">
        <div class="panel-body">
          <?=$value->info?>
        </div>
      </div>
    </div>
  <?php }} ?>
</div>

<div class="form-group">
  <label class="control-label">Kebijakan Produk</label>
  <p><?=(!empty($data->policy))?$data->policy:''?></p>
</div>

<div class="form-group package-price-wrapper" style="<?=(isset($data->can_be_bought) and $data->can_be_bought == 0)?'display: none;':''?>">
  <label class="control-label">Harga Paket</label>
    <?php if ( !empty($data->prices) ){ 
      echo '<ul>';
        foreach ($data->prices as $key => $value) { ?>
          <li>Rp <?=$value->price?>/<?=$value->period?> hari</li>
    <?php } echo '</ul>'; } ?>
</div>

