<div class="loading" id="loading" style="display: none;">Loading&#8230;</div>

<?= $this->session->flashdata('msg') ?>
<!-- Tabel Info barang/ set -->
<div class="row">
    <form method="POST" action="<?= base_url('Pengembalian_barang/simpan_data/') ?>">
        <div class="col-sm-12" style="overflow-y: auto;height: 470px;">
            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Quantity Pinjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Lokasi Barang</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($pinjam as $v) {
                            $no += 1;
                            echo '<tr>
                            <input type="hidden" name="id_pinjam[]" value="' . $v->id_pinjam . '">
                            <td>' . $no . '</td>
                            <td>' . $v->nama_barang . '</td>
                            <td>' . $v->qty_pinjam . '</td>
                            <td>' . date('d-m-Y', strtotime($v->tgl_pinjam)) . '</td>
                            <td>' . $v->nama_lokasi . '</td>
                            <td><input type="checkbox" name="id_' . $v->id_pinjam . '"></td>
                        </tr>';
                        }
                        //echo '<input type="hidden" name="total_barang" value="' . $no . '">';
                        ?>
                    </tbody>

                </table>

            </div>
        </div>
        <div class="col-sm-12">
            <input type="submit" class="btn btn-primary" value="Ajukan">
        </div>
    </form>
</div>

<!-- MODAL SUKSES -->
<div id="fb_sukses" class="modal fade in" tabindex="-1" style="margin-top: 0%;background-color: black;opacity: 0.8;">
    <div class="modal-dialog" style="margin-top: 10%;opacity: 2;">
        <div class="modal-content">
            <!--div class="modal-header">
                <button type="button" onclick="close_sukses()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="smaller lighter blue no-margin" style="text-align: center;">Pesan</h3>
            </div-->

            <div class="modal-body" style="font-size: 20px;color: green;font-weight: bold;text-align: center;">
                Data Berhasil Disimpan<br><br>
                <a href="<?= base_url('Pinjam_barang') ?>" class="btn btn-success">Ok</a>
            </div>

        </div>
    </div>
</div>
<!-- MODAL SUKSES -->

<!-- MODAL GAGAL-->
<div id="fb_gagal" class="modal fade in" tabindex="-1" style="margin-top: 0%;background-color: black;opacity: 0.8;">
    <div class="modal-dialog" style="margin-top: 10%;opacity: 10;">
        <div class="modal-content" style="font-size: 20px;color: red;font-weight: bold;text-align: center;">
            <div class="modal-body">
                <span id="msg">Message</span>
                <br><br>
                <button onclick="close_gagal()" class="btn btn-danger">Ok</button>
            </div>

        </div>
    </div>
</div>
<!-- MODAL GAGAL -->