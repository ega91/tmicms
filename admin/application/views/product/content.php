<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>There is no Product added yet.</h3>
      <a href="#" class="add-modal btn btn-primary btn-lg">Add Product</a>
	  </div>
  </div>
<?php else: ?>

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
    </div>
    <a href="#" class="reload-table btn btn-default"><i class="fa fa-history"></i></a>
  </div>

  <table id="products-table" class="table table-striped_">
    <thead>
      <tr>
        <th>Product <span style="display: block; color: #888; font-weight: normal;">Drag & drop produk untuk mengganti urutan.</span></th>
        <th>Dapat&nbsp;Dibeli?</th>
      </tr>
    </thead>
    <tbody>
      <tr><td colspan="2" class="td-add-new"><a href="#" class="add-modal btn btn-default btn-add-modal btn-block"><i class="fa fa-plus"></i> Tambah Produk</a></td></tr>
      <?php foreach ($data as $key => $value) { ?>
        <tr class="sortable-tr" data-id="<?=$value->id?>">
          <td>
            <?php if ( !empty($value->image->image_small) ): ?>
              <div class="product-img-tbl" style="background-image: url(<?=$value->image->image_small?>);"></div>
            <?php endif; ?>
            <div class="product-info-container <?=(!empty($value->image->image_small))?'has-image':''?>">
              <h3 class="td-title"><?php echo $value->name?></h3>
    			    <p><?=substr(strip_tags($value->descriptions), 0, 70)?><?=(strlen($value->descriptions) > 70)?'...':''?></p>
              <p><b>Kebijakan Produk:</b><br /><?=substr(strip_tags($value->policy), 0, 100)?><?=(strlen($value->policy) > 100)?'...':''?></p>
              <p><b>Ketentuan Umum:</b><br /><?=substr(strip_tags($value->ketentuan_umum), 0, 100)?><?=(strlen($value->ketentuan_umum) > 100)?'...':''?></p>

              <div class="table-action-container">
                <a href="#" class="view-product" product-id="<?=$value->id?>"><i class="fa fa-eye"></i> View</a> &bull;
                <a href="#" class="edit-modal" data-source="<?=site_url('content/editproduct/'. $value->id)?>"><i class="fa fa-pencil"></i> Edit</a> &bull;
                <a href="#" class="delete-modal" delete-uri="<?=site_url('content/deleteproduct/'. $value->id)?>"><i class="fa fa-trash"></i> Delete</a>
              </div>
            </div>
          </td>
          <td class="text-center"><?=(!empty($value->can_be_bought))?'Ya':'Tidak'?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>