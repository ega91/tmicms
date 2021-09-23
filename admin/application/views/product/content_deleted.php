<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>There is no Product.</h3>
	  </div>
  </div>
<?php else: ?>

  <table id="products-table" class="table table-striped_">
    <thead>
      <tr>
        <th>Product</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $key => $value) { ?>
        <tr class="sortable-tr" data-id="<?=$value->id?>">
          <td>
            <?php if ( !empty($value->image->image_small) ): ?>
              <div class="product-img-tbl" style="background-image: url(<?=$value->image->image_small?>);"></div>
            <?php endif; ?>
            <div class="product-info-container <?=(!empty($value->image->image_small))?'has-image':''?>">
              <h3 class="td-title"><?php echo $value->name?></h3>
              <p></p>
    			    <p><?=substr(strip_tags($value->descriptions), 0, 110)?><?=(strlen($value->descriptions) > 110)?'...':''?></p>

              <div class="table-action-container">
                <a href="#" class="restore-modal" restore-uri="<?=site_url('content/restoreproduct/'. $value->id)?>">Restore</a>
              </div>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>