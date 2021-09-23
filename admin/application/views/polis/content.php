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
          <li><a href="#">Nama Produk a-Z</a></li>
          <li><a href="#">Nama Produk Z-a</a></li>
          <li><a href="#">Nama User/Pembeli a-Z</a></li>
          <li><a href="#">Nama User/Pembeli Z-a</a></li>
          <li><a href="#">Nama Tertanggung a-Z</a></li>
          <li><a href="#">Nama Tertanggung Z-a</a></li>
          <li><a href="#">Tanggal Terbit a-Z</a></li>
          <li><a href="#">Tanggal Terbit Z-a</a></li>
          <li><a href="#">Tanggal Berakhir a-Z</a></li>
          <li><a href="#">Tanggal Berakhir Z-a</a></li>
        </ul>
      </div>
    </div>
    <a href="#" class="reload-table btn btn-default"><i class="fa fa-history"></i></a>
    <a href="#" class="page-filter btn btn-default" 
      filter-source="<?=site_url('content/filterpolis?'. http_build_query($this->input->get()))?>"><i class="fa fa-filter"></i> Filter</a>
    <a href="#" class="page-export btn btn-default"><i class="fa fa-external-link"></i> Export CSV</a>
  </div>

  <table class="table table-striped_">
    <thead>
      <tr>
        <th>Polis</th>
        <th>User/Pembeli</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php if ( empty($data) ): ?>
        <tr><td colspan="3">
          <div class="no-data-center">
            <div class="no-data-content">
              <i class="fa fa-file-text-o"></i>
              <h3>Belum ada polis untuk saat ini.</h3>
            </div>
          </div>
        </td></tr>
      <?php else: ?>
        <?php foreach ($data as $key => $value) { ?>
          <tr>
            <td>
              <div class="product-info-container">
                <h3 class="td-title"><a href="#" class="view-product" product-id="<?=$value->product->id?>"><?=$value->product->name?></a></h3>
                <table class="polis-table">
                  <tr><td class="f-td" style="width: 200px;">No Polis</td><td>:&nbsp;</td><td><?=($value->polis_no > 0 and ($value->status == 'aktif' or $value->status == 'berakhir'))?number_format($value->polis_no, 0, '', ''):'-'?></td>
                  <tr><td class="f-td">No Invoice</td><td>:&nbsp;</td><td><?=(!empty($value->trx))?$value->trx->invoice_no:'-'?></td>
                  <tr><td class="f-td">No Transaksi</td><td>:&nbsp;</td><td><?=(!empty($value->trx))?$value->trx->trx_no:'-'?></td>
                  <tr><td class="f-td">Pemegang Polis</td><td>:&nbsp;</td><td><?=(!empty($value->contact))?$value->contact->full_name:'-'?></td>
                  <tr><td class="f-td">Tertanggung</td><td>:&nbsp;</td><td><?=(!empty($value->tertanggung))?$value->tertanggung->full_name:'-'?></td>

                  <?php if ( $value->status == 'pending' ): ?>
                    <tr><td class="f-td">Batas Waktu Pembayaran</td><td>:&nbsp;</td><td><?=date('d F Y H:i', $value->batas_waktu_pembayaran_timestamp)?></td>
                  <?php else: ?>
                    <tr><td class="f-td">Masa Berlaku</td><td>:&nbsp;</td><td><?=date('d F Y H:i', strtotime($value->valid_from)-25200)?> s/d <?=date('d F Y H:i', strtotime($value->valid_until)-25200)?></td>
                  <?php endif; ?>
                </table>

                <div class="table-action-container">
                  <a href="<?=site_url('content/polisdetail/'. $value->id)?>" class="view-modal" data-source="<?=site_url('content/viewpolis/'. $value->id)?>"><i class="fa fa-eye"></i> Lihat Polis</a> &bull;
                </div>
              </div>
            </td>
            <td><a href="#" class="view-user" user-id="<?=$value->user->id?>"><?=$value->user->full_name?></a></td>
            <td>
              <div class="div-status <?=$value->status?>"><?=ucfirst(str_replace('_', ' ', $value->status))?></div>
            </td>
          </tr>
        <?php } ?>
      <?php endif; ?>
  </tbody>
  </table>

