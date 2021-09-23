<table class="claim-detail-table">
              <tr>
                <td>Status Klaim</td>
                <?php if ($data->polis->claim_status == 'approved'): ?>
                  <td class="green-color">Klaim Disetujui</td>
                <?php elseif ($data->polis->claim_status == 'declined'): ?>
                  <td class="red-color">Klaim Ditolak</td>
                <?php else: ?>
                  <td class="orange-color">Menunggu Persetujuan</td>
                <?php endif; ?>
              </tr>
              <tr>
                <td>Tipe Klaim</td>
                <td><?=ucwords($data->claim_type)?></td>
              </tr>
              <tr>
                <td>Tanggal Pengajuan Klaim</td>
                <td><?=date('Y-m-d H:i:s', $data->claim_timestamp)?></td>
              </tr>
              <?php if (!empty($data->user)): ?>
                <tr>
                  <td>User</td>
                  <td><a href="#" class="view-user" user-id="<?=$data->user->id?>"><?=$data->user->full_name?></a></td>
                </tr>
              <?php endif; ?>

              <tr>
                <td colspan="2"><h4>Informasi Polis</h4></td>
              </tr>
              <tr>
                <td>No Polis</td>
                <td><b><?=(string)$data->polis->polis_no?></b></td>
              </tr>
              <tr>
                <td>Produk</td>
                <td><?=$data->polis->product_id?></td>
              </tr>
              <tr>
                <td>Tipe Polis</td>
                <td><?=ucwords(str_replace('_', ' ', $data->polis->tipe_pembelian))?></td>
              </tr>
              <tr>
                <td>Status Polis</td>
                <td><?=ucwords(str_replace(')', ' ', $data->polis->status))?></td>
              </tr>
              <tr>
                <td>Masa Berlaku Polis</td>
                <td><?=date('Y-m-d H:i:s', strtotime($data->polis->valid_from)-25200)?> s/d <?=date('Y-m-d H:i:s', strtotime($data->polis->valid_until)-25200)?></td>
              </tr>

              <tr>
                <td colspan="2"><h4>Pemegang Polis</h4></td>
              </tr>
              <tr>
                <td>Nama Pemegang Polis</td>
                <td><?=$data->contact->full_name?></td>
              </tr>
              <tr>
                <td>No. Identitas</td>
                <td><?=$data->contact->identity_no?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?=$data->contact->email?></td>
              </tr>
              <tr>
                <td>No. Telp.</td>
                <td><?=$data->contact->phone_number?></td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td><?=ucfirst($data->contact->gender)?></td>
              </tr>
              <tr>
                <td>Tempat Tanggal Lahir</td>
                <td><?=$data->contact->birthplace?>, <?=$data->contact->birthdate?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td><?=$data->contact->address?></td>
              </tr>
              <tr>
                <td>Kota</td>
                <td><?=$data->contact->city_id?></td>
              </tr>
              <tr>
                <td>Provinsi</td>
                <td><?=$data->contact->province_id?></td>
              </tr>
              <tr>
                <td>Kode Pos</td>
                <td><?=$data->contact->pos_code?></td>
              </tr>

              <tr>
                <td colspan="2"><h4>Tertanggung</h4></td>
              </tr>
              <tr>
                <td>Nama Tertanggung</td>
                <td><?=$data->tertanggung->full_name?></td>
              </tr>
              <tr>
                <td>No. Identitas</td>
                <td><?=$data->tertanggung->identity_no?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?=$data->tertanggung->email?></td>
              </tr>
              <tr>
                <td>No. Telp.</td>
                <td><?=$data->tertanggung->phone_number?></td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td><?=ucfirst($data->tertanggung->gender)?></td>
              </tr>
              <tr>
                <td>Tempat Tanggal Lahir</td>
                <td><?=$data->tertanggung->birthplace?>, <?=$data->tertanggung->birthdate?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td><?=$data->tertanggung->address?></td>
              </tr>
              <tr>
                <td>Kota</td>
                <td><?=$data->tertanggung->city_id?></td>
              </tr>
              <tr>
                <td>Provinsi</td>
                <td><?=$data->tertanggung->province_id?></td>
              </tr>
              <tr>
                <td>Kode Pos</td>
                <td><?=$data->tertanggung->pos_code?></td>
              </tr>

              <?php if ($data->claim_type == 'meninggal'): ?>
                <tr>
                  <td colspan="2"><h4>Informasi Ahli Waris</h4></td>
                </tr>
                <tr>
                  <td>Nama Ahli Waris</td>
                  <td><?=$data->ahli_waris->full_name?></td>
                </tr>
                <tr>
                  <td>No. Identitas</td>
                  <td><?=$data->ahli_waris->identity_no?></td>
                </tr>
                <?php /**
                <tr>
                  <td>Foto Identitas</td>
                  <td><?=$data->ahli_waris->identity_no?></td>
                </tr>
                <tr>
                  <td>Foto Kartu Keluarga</td>
                  <td><?=$data->ahli_waris->identity_no?></td>
                </tr>
                */ ?>
                <tr>
                  <td>Email</td>
                  <td><?=$data->ahli_waris->email?></td>
                </tr>
                <tr>
                  <td>No. Telp.</td>
                  <td><?=$data->ahli_waris->phone_number?></td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td><?=ucfirst($data->ahli_waris->gender)?></td>
                </tr>
                <tr>
                  <td>Tempat Tanggal Lahir</td>
                  <td><?=$data->ahli_waris->birthplace?>, <?=$data->ahli_waris->birthdate?></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td><?=$data->ahli_waris->address?></td>
                </tr>
                <tr>
                  <td>Kota</td>
                  <td><?=$data->ahli_waris->city_id?></td>
                </tr>
                <tr>
                  <td>Provinsi</td>
                  <td><?=$data->ahli_waris->province_id?></td>
                </tr>
                <tr>
                  <td>Kode Pos</td>
                  <td><?=$data->ahli_waris->pos_code?></td>
                </tr>
              <?php endif; ?>

              <tr>
                <td colspan="2"><h4>Akun Bank</h4></td>
              </tr>
              <tr>
                <td>No Rekening</td>
                <td><?=$data->no_rek?></td>
              </tr>
              <tr>
                <td>Pemilik Rekening</td>
                <td><?=$data->pemilik_rek?></td>
              </tr>
              <tr>
                <td>Bank</td>
                <td><?=$data->nama_bank?></td>
              </tr>

              <tr>
                <td colspan="2"><h4>Dokumen Yang Diunggah</h4></td>
              </tr>

              <tr>
                <td colspan="2">
                  <div class="uploaded-doc-cnt">
                    <?php if (empty($data->documents)): ?>
                      <p class="help-block">Tidak ada dokumen yang diunggah.</p>
                    <?php else: ?>

                      <?php if (!empty($data->documents->surat_keterangan_diagnosa_small)): ?>
                        <div class="uploaded-doc open-img-preview" 
                          img-hd="<?=$data->documents->surat_keterangan_diagnosa?>" 
                          style="background-image: url('<?=$data->documents->surat_keterangan_diagnosa_small?>')"></div>
                      <?php endif; ?>
                      <?php if (!empty($data->documents->surat_keterangan_kecelakaan_small)): ?>
                        <div class="uploaded-doc open-img-preview" 
                          img-hd="<?=$data->documents->surat_keterangan_kecelakaan?>" 
                          style="background-image: url('<?=$data->documents->surat_keterangan_kecelakaan_small?>')"></div>
                      <?php endif; ?>
                      <?php if (!empty($data->documents->kuitansi_biaya_perawatan_small)): ?>
                        <div class="uploaded-doc open-img-preview" 
                          img-hd="<?=$data->documents->kuitansi_biaya_perawatan?>" 
                          style="background-image: url('<?=$data->documents->kuitansi_biaya_perawatan_small?>')"></div>
                      <?php endif; ?>
                      <?php if (!empty($data->documents->fotocopy_resume_medis_small)): ?>
                        <div class="uploaded-doc open-img-preview" 
                          img-hd="<?=$data->documents->fotocopy_resume_medis?>" 
                          style="background-image: url('<?=$data->documents->fotocopy_resume_medis_small?>')"></div>
                      <?php endif; ?>
                      <?php if (!empty($data->documents->surat_keterangan_kematian_small)): ?>
                        <div class="uploaded-doc open-img-preview" 
                          img-hd="<?=$data->documents->surat_keterangan_kematian?>" 
                          style="background-image: url('<?=$data->documents->surat_keterangan_kematian_small?>')"></div>
                      <?php endif; ?>
                      <?php if (!empty($data->documents->berita_acara_kepolisian_small)): ?>
                        <div class="uploaded-doc open-img-preview" 
                          img-hd="<?=$data->documents->berita_acara_kepolisian?>" 
                          style="background-image: url('<?=$data->documents->berita_acara_kepolisian_small?>')"></div>
                      <?php endif; ?>

                    <?php endif; ?>
                    <div class="clearfix"></div>
                  </div>
                </td>
              </tr>
            </table>