
<input type="hidden" name="id" value="<?php echo (!empty($data))?$data->id:0?>">

<div class="alert alert-danger" style="<?=(empty($error))?'display: none;':''?>"><?=(!empty($error))?$error:''?></div>

<div class="form-group">
  <label class="control-label">Kode Voucher</label>
  <input type="text" class="form-control" name="code" placeholder="Kode Voucher" value="<?=(!empty($data->voucher_code))?$data->voucher_code:''?>">
  <p class="help-block">Masukan kode voucher. 1 user hanya dapat menggunakan kode voucher ini 1 kali.</p>
</div>

<div class="form-group">
  <label class="control-label">Potongan Harga</label>
  <input type="text" class="form-control" name="discount" placeholder="Potongan harga" value="<?=(!empty($data->discount))?$data->discount:''?>">
  <p class="help-block">Potongan harga, bisa dalam bentuk persentase atau nominal. Isi 100% untuk gratis.<br />Contoh: 20% untuk persentase atau 20000 untuk nominal sebesar Rp 20.000</p>
</div>

<div class="form-group">
  <label class="control-label">Nominal Maksimal</label>
  <input type="text" class="form-control" name="nominal_max" placeholder="Nominal Maksimal" value="<?=(!empty($data->nominal_max))?$data->nominal_max:''?>">
  <p class="help-block">Jika potongan harga berupa persentase, nominal maksimal akan digunakan sebagai batasan nominal potongan harga. Contoh: 5% maksimal Rp. 100.000</p>
</div>

<div class="form-group">
  <label class="control-label">Deskripsi penggunaan voucher ini.</label>
  <textarea class="form-control" name="descriptions" placeholder="Deskripsi"><?=(!empty($data->descriptions))?$data->descriptions:''?></textarea>
  <p class="help-block">Informasi ini hanya untuk keterangan internal, tidak akan ditampilkan di aplikasi.</p>
</div>

<div class="form-group">
  <label class="control-label">Penggunaan Maksimal</label>
  <div class="input-group">
    <input type="text" class="form-control" name="max_usage" placeholder="Penggunaan maksimal voucher" value="<?=(!empty($data->max_usage))?$data->max_usage:''?>">
    <div class="input-group-addon">
      <span class="input-group-text" id="basic-addon2">Kali</span>
    </div>
  </div>
  <p class="help-block">Berapa kali voucher ini dapat digunakan, kosongkan atau isi 0 untuk tidak memberi batasan.</p>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Periode</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="periode_start" placeholder="Dari tanggal" value="<?=(!empty($data->periode_start))?substr($data->periode_start, 0, 10):''?>">
        <div class="input-group-addon">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
      <p class="help-block">Periode masa berlaku voucher.</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">&nbsp;</label>
      <div class="input-group">
        <input type="text" class="form-control new-datepicker" name="periode_end" placeholder="Sampai tanggal" value="<?=(!empty($data->periode_end))?substr($data->periode_end, 0, 10):''?>">
        <div class="input-group-addon">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="ln_solid"></div>
<div class="form-group">
  <div class="row">
    <div class="col-md-12">
      <?php if ( !empty($data) ): ?>
        <div class="pull-right">
          <a href="#" class="red-color delete-event" event-id="<?php echo $data->id?>"><i class="fa fa-trash"></i> Delete</a>
        </div>
      <?php endif; ?>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

