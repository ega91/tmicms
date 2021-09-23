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
  <a href="#" class="page-filter btn btn-default" 
    filter-source="<?=site_url('content/filtertrx?'. http_build_query($this->input->get()))?>"><i class="fa fa-filter"></i> Filter</a>
  <a href="#" class="page-export btn btn-default"><i class="fa fa-external-link"></i> Export CSV</a>
</div>


<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>Belum ada transaksi untuk saat ini.</h3>
	  </div>
  </div>
<?php else: ?>

  <table class="table table-striped_">
    <thead>
      <tr>
        <th>Transaction</th>
        <th>Transaction Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $key => $value) { ?>
        <tr>
          <td>
            <div class="product-info-container <?=(!empty($value->image->image_small))?'has-image':''?>">
              <h3 class="td-title">No Transaksi: <?=$value->trx_no?></h3>
              <table class="polis-table">
                <tr><td class="f-td">Paymnet Method</td><td>:&nbsp;</td><td><?=ucwords(str_replace('_', ' ', $value->payment_method))?></td></tr>
                <tr><td class="f-td">User</td><td>:&nbsp;</td><td><?=$value->user->full_name?> <?=(!empty($value->user->phone))?'('.$value->user->phone.')':''?></td></tr>

                <?php if ($value->payment_method == 'virtual_account'): ?>
                  <tr><td class="f-td">No Virtual Account</td><td>:&nbsp;</td><td><?=number_format($value->trx_no, 0, '', '')?></td></tr>
                  <tr><td class="f-td">Bank</td><td>:&nbsp;</td><td><?=(!empty($value->bank))?$value->bank->nama_bank:'-'?></td></tr>
                <?php endif; ?>

                <tr><td class="f-td">Total</td><td>:&nbsp;</td><td>Rp <?=number_format($value->total_price, 0, ',','.')?></td></tr>
                <tr><td class="f-td">Discount</td><td>:&nbsp;</td><td><?=(!empty($value->discount))?(strstr($value->discount, '%'))?$value->discount:'Rp '. number_format($value->discount, 0, ',','.'):'-'?></td></tr>
                <tr><td class="f-td">Discount Ammount</td><td>:&nbsp;</td><td><?=($value->discount_ammount > 0)?'Rp '. number_format($value->discount_ammount, 0,',','.'):'-'?></td></tr>
                <tr><td class="f-td">Kode Voucher</td><td>:&nbsp;</td><td><?=(!empty($value->voucher_code))?$value->voucher_code:'-'?></td></tr>
                <tr><td class="f-td">Grand Total</td><td>:&nbsp;</td><td>Rp <?=number_format($value->grand_total, 0,',','.')?></td></tr>
              </table>
            </div>
          </td>
          <td><?=date('Y-m-d H:i:s', $value->trx_timestamp)?></td>
          <td><div class="div-status <?=$value->status?>"><?=ucwords(str_replace('_', ' ', $value->status))?></div></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>