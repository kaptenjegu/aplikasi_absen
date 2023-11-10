<style>
    /* Absolute Center Spinner */
    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

        background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 150ms infinite linear;
        -moz-animation: spinner 150ms infinite linear;
        -ms-animation: spinner 150ms infinite linear;
        -o-animation: spinner 150ms infinite linear;
        animation: spinner 150ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>

<div class="loading" id="loading" style="display: none;">Loading&#8230;</div>
<div class="row">
    <!-- box pilih lokasi -->
    <div class="col-xs-12">
        <form method="GET" action="<?= base_url('Pinjam_barang/index/') ?>">
            <div class="form-group">
                <label><b>Pilih Lokasi Barang</b></label>
                <select class="form-control" name="id_lokasi">
                    <?php foreach ($lokasi as $v) {
                        $slc = '';
                        if(isset($_GET['id_lokasi'])){
                            if($_GET['id_lokasi'] == $v->id_lokasi){
                                $slc = 'selected="selected"';
                            }
                        }
                            echo '<option value="' . $v->id_lokasi . '" ' . $slc . '>' . $v->nama_lokasi . '</option>';
                            
                    } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="border-radius: 5px;">Tampilkan</button>
        </form>
    </div>
    <!-- box pilih lokasi -->

</div><!-- /.row -->

<div class="hr hr32 hr-dotted"></div>

<!-- Tabel Info barang/ set -->
<?php if ($id_lokasi !== '') { ?>
    <div class="row">
        <form id="asetForm">
            <div class="col-sm-12" style="overflow-y: auto;height: 270px;">
                <div>
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Qty Tersedia</th>
                                <th>Qty Pinjam</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($aset as $v) {
                                $no += 1;
                                echo '<tr>
                            <input type="hidden" name="id_barang[]" value="' . $v->id_barang . '">
                            <td>' . $no . '</td>
                            <td>' . $v->nama_barang . '</td>
                            <td id="qty_' . $v->id_barang . '">' . $v->qty_sisa . '</td>
                            <td><input type="number" id="qr_' . $v->id_barang . '" min="1" step="0.01"></td>
                            <td><input type="checkbox" id="id_' . $v->id_barang . '"></td>
                        </tr>';
                            }
                            echo '<input type="hidden" name="total_barang" value="' . $no . '">';
                            ?>

                        </tbody>

                    </table>

                </div>
            </div>
            <div class="col-sm-12">
                <input type="button" onclick="validateForm()" class="btn btn-success" value="Simpan">
            </div>
        </form>
    <?php } ?>
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
<div id="fb_gagal" class="modal fade in" tabindex="-1"  style="margin-top: 0%;background-color: black;opacity: 0.8;">
    <div class="modal-dialog" style="margin-top: 10%;opacity: 10;">
        <div class="modal-content" style="font-size: 20px;color: red;font-weight: bold;text-align: center;">
            <div class="modal-body">
                <span  id="msg">Message</span>
                <br><br>
                <button onclick="close_gagal()" class="btn btn-danger">Ok</button>
            </div>

        </div>
    </div>
</div>
<!-- MODAL GAGAL -->