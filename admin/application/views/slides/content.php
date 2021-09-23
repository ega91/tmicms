
<?php if ( empty($data) ): ?>
	<div class="no-data-center">
    <div class="no-data-content">
      <i class="fa fa-file-text-o"></i>
      <h3>There is no Promo Slideshow added yet.</h3>
      <a href="#" class="add-modal btn btn-primary btn-lg">Add Slideshow</a>
	  </div>
  </div>
<?php else: ?>

  <table class="table" id="slide-table">
    <thead>
      <tr>
        <th>Gambar Promo</th>
        <th>Dibuat&nbsp;Pada</th>
      </tr>
    </thead>
    <tbody>
      <tr><td colspan="2" class="td-add-new"><a href="#" class="add-modal btn btn-default btn-add-modal btn-block"><i class="fa fa-plus"></i> Tambah Slideshow</a></td></tr>
      <?php foreach ($data as $key => $value) { ?>
        <tr class="slide-table-item" data-id="<?=$value->id?>">
          <td>
            <?php if ( !empty($value->image_small) ): ?>
              <div class="product-img-tbl open-img-preview" img-hd="<?=$value->image_big?>" style="background-image: url(<?=$value->image_small?>);"></div>
            <?php endif; ?>
            <div class="product-info-container <?=(!empty($value->image_small))?'has-image':''?>">
              <h3 class="td-title"><?=ucfirst($value->link_to)?></h3>
              <p><?php switch ($value->link_to) {
                case 'none':
                  echo 'Hanya menampilkan gambar, tidak ada link.';
                  break;

                case 'product':
                  echo 'Link ke halaman detil produk dengan id: <b>'. $value->product_id .'</b>';
                  break;
                
                case 'article':
                  echo 'Link ke halaman artikel dengan id: <b>'. $value->article_id .'</b>';
                  break;

                case 'eksternal':
                  echo 'Link ke halaman web eksternal dengan url: <b>'. $value->external_url .'</b>';
                  break;
                
                case 'message':
                  echo 'Link ke halaman Pesan.';
                  break;
                
                case 'profile':
                  echo 'Link ke halaman Profil Pengguna.';
                  break;
                
                default:
                  echo 'Link ke halaman '. ucfirst($value->link_to);
                  break;
              } ?></p>

              <div class="table-action-container">
                <a href="#" class="open-img-preview" img-hd="<?=$value->image_big?>"><i class="fa fa-eye"></i> View Image</a> &bull;
                <a href="#" class="edit-modal" data-source="<?=site_url('content/editslide/'. $value->id)?>"><i class="fa fa-pencil"></i> Edit</a> &bull;
                <a href="#" class="delete-modal" delete-uri="<?=site_url('content/deleteslide/'. $value->id)?>"><i class="fa fa-trash"></i> Delete</a>
              </div>
            </div>
          </td>
          <td><?=date('d F Y H:i', $value->created_timestamp)?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php endif; ?>