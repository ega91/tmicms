
<div class="form-group role-allowd-list">

  <h3><?=(!empty($data->name))?$data->name:'-'?></h3>
  <?php if (!empty($data->description)): ?>
    <h4><?=$data->description?></h4>
  <?php endif; ?>
  <p>&nbsp;</p>
  <table class="viewrole-table">
    <tr>  
      <td style="width: 260px;">Mengirim pesan broadcast</td><td><?=(!empty($data->broadcast))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Mengirim pesan layanan pelanggan</td><td><?=(!empty($data->message))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat produk</td><td><?=(!empty($data->view_product))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Edit/Tambah/Hapus produk</td><td><?=(!empty($data->edit_product))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat promo slideshow</td><td><?=(!empty($data->view_slideshow))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Edit/Tambah/Hapus promo slideshow</td><td><?=(!empty($data->edit_slideshow))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat kode voucher</td><td><?=(!empty($data->view_voucher))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Edit kode voucher</td><td><?=(!empty($data->edit_voucher))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat artikel</td><td><?=(!empty($data->view_article))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Edit/Tambah/Hapus artikel</td><td><?=(!empty($data->edit_article))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat polis</td><td><?=(!empty($data->view_polis))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat data transaksi</td><td><?=(!empty($data->view_trx))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat data berminat</td><td><?=(!empty($data->view_berminat))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat pengajuan klaim</td><td><?=(!empty($data->view_claim))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Menerima/Menolak pengajuan klaim</td><td><?=(!empty($data->approve_claim))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat pengguna aplikasi</td><td><?=(!empty($data->view_user))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Edit/Tambah/Hapus pengguna</td><td><?=(!empty($data->edit_user))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat media galeri</td><td><?=(!empty($data->view_media))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Edit/Tambah/Hapus media galeri</td><td><?=(!empty($data->edit_media))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Melihat admin</td><td><?=(!empty($data->view_admin))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
    <tr>  
      <td>Edit/Tambah/Hapus admin</td><td><?=(!empty($data->edit_admin))?'<b class="green-color">Ya</b>':'<b class="red-color">Tidak</b>'?></td>
    </tr>
</div>
