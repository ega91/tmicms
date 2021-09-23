<table class="claim-detail-table">
              <tr>
                <td>Produk</td>
                <td><?=(!empty($data->product))?$data->product->name:''?></td>
              </tr>
              <tr>
                <td>No Polis</td>
                <td><b><?=number_format($data->polis_no, 0, '', '')?></b></td>
              </tr>
              <tr>
                <td>Tipe Pembelian</td>
                <td><?=ucwords(str_replace('_', ' ', $data->tipe_pembelian))?></td>
              </tr>
              <tr>
                <td>Status Polis</td>
                <td class="div-status-2 <?=strtolower($data->polis_status)?>"><?=ucwords(str_replace(')', ' ', $data->polis_status))?></td>
              </tr>
              <tr>
                <td>Masa Berlaku Polis</td>
                <td><?=date('d F Y H:i', strtotime($data->valid_from)-25200)?> s/d <?=date('d F Y H:i', strtotime($data->valid_until)-25200)?></td>
              </tr>
              <?php if ($data->polis_status == 'pending'): ?>
                <tr>
                  <td>Batas Waktu Pembayaran</td>
                  <td><?=date('d F Y H:i', strtotime($data->batas_waktu_pembayaran_timestamp))?></td>
                </tr>
              <?php endif; ?>

              <tr>
                <td colspan="2"><h4>Data Pembelian</h4></td>
              </tr>
              <tr>
                <td>No. Invoice</td>
                <td><?=$data->trx->invoice_no?></td>
              </tr>
              <tr>
                <td>No. Transaksi</td>
                <td><?=$data->trx->trx_no?></td>
              </tr>
              <tr>
                <td>Tanggal Pembelian</td>
                <td><?=date('d F Y H:i', $data->trx->trx_timestamp)?></td>
              </tr>
              <tr>
                <td>Paket Produk</td>
                <td><?=(!empty($data->product_price))?'Rp '.number_format($data->product_price->price,2,",",".").' /'. $data->product_price->period.'hari':'-'?></td>
              </tr>
              <tr>
                <td>Harga Produk</td>
                <td><?=(!empty($data->trx))?number_format($data->trx->total_price,2,',','.'):'-'?></td>
              </tr>
              <tr>
                <td>Diskon</td>
                <td><?=(!empty($data->trx->discount))?$data->trx->discount:'-'?></td>
              </tr>
              <tr>
                <td>Kode Voucher</td>
                <td><?=(!empty($data->trx->voucher_code))?$data->trx->voucher_code:'-'?></td>
              </tr>
              <tr>
                <td>Pembayaran Total</td>
                <td><?=(!empty($data->trx))?number_format($data->trx->grand_total,2,',','.'):'-'?></td>
              </tr>
              <tr>
                <td>Payment Gateway</td>
                <td>Finpay</td>
              </tr>
              <tr>
                <td>Metode Pembayaran</td>
                <td><?=(!empty($data->trx))?ucwords(str_replace('_', ' ', $data->trx->payment_method)):'-'?></td>
              </tr>


              <?php if (!empty($data->contact)): ?>
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
                  <td><?=$data->contact->birthplace?><?=(!empty($data->contact->birthdate))?', '.date('d F Y', strtotime($data->contact->birthdate)):''?></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td><?=$data->contact->address?></td>
                </tr>
                <tr>
                  <td>Kota</td>
                  <td><?=(!empty($data->contact->city))?$data->contact->city->name:'Tidak diketahui';?></td>
                </tr>
                <tr>
                  <td>Provinsi</td>
                  <td><?=(!empty($data->contact->province))?$data->contact->province->name:'Tidak diketahui';?></td>
                </tr>
                <tr>
                  <td>Kode Pos</td>
                  <td><?=$data->contact->pos_code?></td>
                </tr>
                <?php if (!empty($data->contact->identity_doc_small)): ?>
                  <tr>
                    <td>Foto Identitas</td>
                    <td><div class="uploaded-doc open-img-preview" img-hd="<?=$data->contact->identity_doc_big?>" style="background-image: url(<?=$data->contact->identity_doc_small?>)"></td>
                  </tr>
                <?php endif; ?>
              <?php endif; ?>

              <?php if (!empty($data->tertanggung)): ?>
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
                  <td><?=$data->tertanggung->birthplace?>, <?=date('d F Y', strtotime($data->tertanggung->birthdate))?></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td><?=$data->tertanggung->address?></td>
                </tr>
                <tr>
                  <td>Kota</td>
                  <td><?=(!empty($data->tertanggung->city))?$data->tertanggung->city->name:'Tidak diketahui';?></td>
                </tr>
                <tr>
                  <td>Provinsi</td>
                  <td><?=(!empty($data->tertanggung->province))?$data->tertanggung->province->name:'Tidak diketahui';?></td>
                </tr>
                <tr>
                  <td>Kode Pos</td>
                  <td><?=$data->tertanggung->pos_code?></td>
                </tr>
                <?php if (!empty($data->tertanggung->identity_doc_small)): ?>
                  <tr>
                    <td>Foto Identitas</td>
                    <td><div class="uploaded-doc open-img-preview" img-hd="<?=$data->contact->identity_doc_big?>" style="background-image: url(<?=$data->tertanggung->identity_doc_small?>)"></td>
                  </tr>
                <?php endif; ?>
              <?php endif; ?>
            </table>