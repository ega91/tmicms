  <div class="table-header">
    <div class="pull-right">
      <a href="#" class="page-prev page-pagination btn btn-default" 
        <?=(empty($prev))?'disabled="true"':'page-uri="'. $prev .'"'?>><i class="fa fa-chevron-left"></i></a>

      <a href="#" class="page-disabled page-pagination btn btn-default" disabled="true">
        <?=($this->input->get('page') != null)?$this->input->get('page')+1:'1';?>
      </a>

      <a href="#" class="page-next page-pagination btn btn-default" 
        <?=(empty($next))?'disabled="true"':'page-uri="'. $next .'"'?>><i class="fa fa-chevron-right"></i></a>
      <a href="#" class="page-goto btn btn-default">Go To Page</a>
      <div class="dropdown">
        <a href="#" class="page-sort dropdown-toggle btn btn-default" data-toggle="dropdown"><i class="fa fa-sort-amount-desc"></i> Urutkan</a>
        <ul class="dropdown-menu">
          <li><a href="#">Terbaru</a></li>
        </ul>
      </div>
    </div>
    <a href="#" class="reload-table btn btn-default"><i class="fa fa-history"></i></a>
    <a href="#" class="page-filter btn btn-default" 
      filter-source="<?=site_url('content/filterberminat?'. http_build_query($this->input->get()))?>"><i class="fa fa-filter"></i> Filter</a>
  </div>

<?php if ( empty($data) ): ?>
  <div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>Belum ada user yang berminat membeli untuk saat ini.</h3>
    </div>
  </div>
<?php else: ?>

  <table class="table table-striped_">
    <thead>
      <tr>
        <th>User</th>
        <th>Produk</th>
        <th>Sudah di follow up?</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $key => $value) { ?>
        <tr>
          <td>
            <?php if ( !empty($value->image->image_small) ): ?>
              <div class="product-img-tbl" style="background-image: url(<?=$value->image->image_small?>);"></div>
            <?php endif; ?>
            <div class="product-info-container <?=(!empty($value->image->image_small))?'has-image':''?>">
              <h3 class="td-title"><?php echo $value->name?></h3>
              <p></p>
              <i class="fa fa-envelope-o fa-fw"></i> <?=$value->email?><br />
              <i class="fa fa-phone fa-fw"></i> <?=$value->phone?>
              <p></p>
              <button class="btn btn-default cancel-follow-up" data-id="<?=$value->id?>">Batalkan Status Follow Up</button>
              <button class="btn btn-default follow-up" data-id="<?=$value->id?>">Follow Up</button>
            </div>
          </td>
          <td><a href="#" class="view-product" product-id="<?=$value->product_id?>"><b><?=$value->product->name?></b></a></td>
          <td><span class="follow-up-status <?=(!empty($value->follow_up))?'green-color':'orange-color'?>"><?=(!empty($value->follow_up))?'Sudah':'Belum'?></span>
            <div style="padding: 7px 12px; background-color: yellow;"><b>Note:</b><br /><?=(!empty($value->note))?$value->note:'-'?></div>
          </td>
          <td><?=date('d F Y H:i', strtotime($value->timestamp))?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>