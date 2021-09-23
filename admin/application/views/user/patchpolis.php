<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php $this->load->view('static/sidebar'); ?>
      <?php $this->load->view('static/header'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="admin-container-sm">
          <div class="panel panel-default admin-content-panel">
            <?php if ($data->status == 300): ?>
              Polis sudah ada. <a href="<?=site_url('content/polisdetail/'. $data->polis_id)?>">Lihat polis</a>
            <?php elseif ($data->status == 301 or $data->status == 302): ?>
              User telah melakukan transaksi tetapi terjadi masalah ketika generate polis.
              <div class="note">Lengkapi form dibawah untuk generate ulang polis</div>

              <?php $uri = ($data->status == 301) ? 'user/regeneratepolis' : 'user/regeneratepolis2'; ?>
              <form method="post" action="<?=site_url($uri .'/'. $data->user_id)?>" id="patchpolis-form" style="max-width: 400px;">
                <h3 style="margin-top: 40px;">Generate Ulang Polis</h3>

                <h4 style="margin-bottom: 10px; margin-top: 30px;">Orang Terdekat</h4>
                <div style="border: #eee 1px solid; padding: 15px; padding-bottom: 0;">
                  <div class="form-group">
                    <label>Nama Lengkap Orang Terdekat</label>
                    <input type="text" class="form-control" placeholder="Nama lengkap" name="family_name" value="<?=(!empty($data->orangTerdekat->full_name))?$data->orangTerdekat->full_name:''?>">
                  </div>
                  <div class="form-group">
                    <label>Alamat Email</label>
                    <input type="text" class="form-control" placeholder="Email" name="family_email" value="<?=(!empty($data->orangTerdekat->email))?$data->orangTerdekat->email:''?>">
                  </div>
                  <div class="form-group">
                    <label>Np. Telp.</label>
                    <input type="text" class="form-control" placeholder="Telp." name="family_phone" value="<?=(!empty($data->orangTerdekat->phone))?$data->orangTerdekat->phone:''?>">
                  </div>
                </div>


                <h4 style="margin-bottom: 10px; margin-top: 40px;">Tertanggung</h4>
                <div style="border: #eee 1px solid; padding: 15px; padding-bottom: 0;">
                  <div class="form-group">
                    <label>Nama Lengkap Tertanggung</label>
                    <input type="text" class="form-control" placeholder="Nama lengkap" name="full_name" value="<?=(!empty($data->contact->full_name))?$data->contact->full_name:''?>">
                  </div>
                  <div class="form-group">
                    <label>No. Identitas</label>
                    <input type="text" class="form-control" placeholder="No. Identitas." name="identity_no" value="<?=(!empty($data->contact->identity_no))?$data->contact->identity_no:''?>">
                  </div>
                  <div class="form-group">
                    <label>Alamat Email</label>
                    <input type="text" class="form-control" placeholder="Email" name="email" value="<?=(!empty($data->contact->email))?$data->contact->email:''?>">
                  </div>
                  <div class="form-group">
                    <label>No. Telp.</label>
                    <input type="text" class="form-control" placeholder="Telp." name="phone" value="<?=(!empty($data->contact->phone_number))?$data->contact->phone_number:''?>">
                  </div>
                  <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" class="form-control" placeholder="Tempat Lahir" name="birthplace" value="<?=(!empty($data->contact->birthplace))?$data->contact->birthplace:''?>">
                  </div>
                  <div class="form-group">
                    <label>Tanggal Lahir (yyyy-mm-dd, contoh: 1989-07-31)</label>
                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="birthdate" value="<?=(!empty($data->contact->birthdate))?substr($data->contact->birthdate, 0, 10):''?>">
                  </div>
                  <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gender">
                      <option value="laki-laki">Laki-laki</option>
                      <option value="perempuan" <?=(!empty($data->contact->gender) and $data->contact->gender == 'perempuan')?'selected="selected"':''?>>Perempuan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea placeholder="Alamat" class="form-control" name="address"><?=(!empty($data->contact->address))?$data->contact->address:''?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select class="form-control" id="provinsi-selector" name="province">
                      <?php foreach ($data->provinces as $key => $value) {
                        echo '<option value="'. $value->id .'" ';
                        if (!empty($data->contact->province_id) and $data->contact->province_id == $value->id)
                          echo 'selected="selected" ';
                        echo '>'. $value->name .'</option>';
                      } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kota</label>
                    <select class="form-control" id="city-selector" name="city">
                      <option value="<?=(!empty($data->contact->city_id))?$data->contact->city_id:'0'?>">Pilih Kota</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" class="form-control" placeholder="00000" name="pos_code" value="<?=(!empty($data->contact->pos_code))?$data->contact->pos_code:''?>">
                  </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Generate Ulang Polis</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <!-- /page content -->

      <div id="patchpolis-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center" style="padding: 60px 30px;">
              <div class="loading" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; background: #fff; padding-top: 100px;">Mohon tunggu...</div>
              <p style="font-size: 16px;">Sukses generate ulang polis.</p>
              <a href="<?=site_url('user')?>" class="btn btn-primary">Kembali</a>
            </div>
          </div>
        </div>
      </div>
