  <?php if ( empty($data) ): ?>
		<div class="no-data-center">
      <div class="no-data-content">
        <i class="fa fa-file-text-o"></i>
        <h3>There is no Voucher added yet.</h3>
        <a href="#" class="add-modal btn btn-primary btn-lg">Add Voucher</a>
  	  </div>
    </div>
  <?php else: ?>

    <table class="table">
      <thead>
        <tr>
          <th>Voucher</th>
          <th>Discount</th>
          <th>Max Nominal</th>
          <th>Status</th>
          <th>Usage</th>
          <th>Max Usage</th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="6" class="td-add-new"><a href="#" class="add-modal btn btn-default btn-add-modal btn-block"><i class="fa fa-plus"></i> Tambah Voucher</a></td></tr>
        <?php foreach ($data as $key => $value) { ?>
          <tr>
            <td>
              <div class="book-info-container">
                <h3 class="td-title"><?php echo $value->voucher_code?></h3>
                <p><?=$value->descriptions?></p>

                <div class="table-action-container">
                  <a href="#" class="edit-modal" data-source="<?=site_url('content/editvoucher/'. $value->id)?>"><i class="fa fa-pencil"></i> Edit</a> &bull;
                  <a href="#" class="delete-modal" delete-uri="<?=site_url('content/deletevoucher/'. $value->id)?>"><i class="fa fa-trash"></i> Delete</a>
                </div>
              </div>
            </td>
            <td><?=(strstr($value->discount, '%'))?$value->discount:'Rp&nbsp;'. number_format($value->discount, 0, ',', '.')?></td>
            <td><?=(!empty($value->nominal_max))?'Rp '.number_format($value->nominal_max, 0,',','.'):''?></td>
            <?php if ( time() < strtotime($value->periode_start) ) $status = 'not_started';
              elseif ( time() >= strtotime($value->periode_start) and time() <= strtotime($value->periode_end) ) {
                $status = 'active';
              } else {
                $status = 'expired';
              }
            ?>
            <td>
              <b class="voucher-<?=$status?>"><?=ucwords(str_replace('_', ' ', $status))?></b>
              <p><?=substr($value->periode_start, 0, 10)?> - <?=substr($value->periode_end, 0, 10)?></p>
            </td>
            <td><?=$value->usages?>&nbsp;Kali</td>
            <td><?=(empty($value->max_usage))?'Tidak dibatasi':$value->max_usage.' Kali'?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

  <?php endif; ?>