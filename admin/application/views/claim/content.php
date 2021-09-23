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
    filter-source="<?=site_url('content/filterclaim?'. http_build_query($this->input->get()))?>"><i class="fa fa-filter"></i> Filter</a>
</div>


<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>Tidak ada pengajuan klaim untuk saat ini.</h3>
	  </div>
  </div>
<?php else: ?>

  <table class="table table-striped_">
    <thead>
      <tr>
        <th>Pengajuan Klaim</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $key => $value) { ?>
        <tr>
          <td>
            <div class="product-info-container">
              <h3 class="td-title"><a href="#" class="view-user" user-id="<?=(!empty($value->user))?$value->user->id:0?>"><?=(!empty($value->user))?$value->user->full_name:'-'?></a></h3>
              <table class="polis-table">

                <?php if (!empty($value->polis)): ?>
                  <tr>
                    <td class="f-td">Status Klaim</td><td>:&nbsp;</td>
                    <?php if ($value->polis->claim_status == 'approved'): ?>
                      <td class="green-color">Klaim Disetujui</td>
                    <?php elseif ($value->polis->claim_status == 'declined'): ?>
                      <td class="red-color">Klaim Ditolak</td>
                    <?php else: ?>
                      <td class="orange-color">Menunggu Persetujuan</td>
                    <?php endif; ?>
                  </tr>
                <?php endif; ?>

                <tr><td class="f-td">Tipe</td><td>:&nbsp;</td><td><?=ucwords(str_replace('_', ' ', $value->claim_type))?></td></tr>
                <tr><td class="f-td">No. Polis</td><td>:&nbsp;</td><td><?=(!empty($value->polis))?(string)$value->polis->polis_no:'-'?></td></tr>
                <tr><td class="f-td">No. Rekening</td><td>:&nbsp;</td><td><?=$value->no_rek?></td></tr>
                <tr><td class="f-td">Pemilik Rekening</td><td>:&nbsp;</td><td><?=$value->pemilik_rek?></td></tr>
                <tr><td class="f-td">Bank</td><td>:&nbsp;</td><td><?=$value->nama_bank?></td></tr>
              </table>
            </div>
            <a href="<?=site_url('content/claimdetail/'. $value->id)?>"><i class="fa fa-eye"></i> View Detail</a>
          </td>
          <td><?=date('Y-m-d H:i:s', strtotime($value->claim_datetime))?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>