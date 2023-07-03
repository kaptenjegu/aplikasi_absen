<div class="row">
    <!-- box waktu server -->
    <div class="col-xs-12">
        <?= $this->session->flashdata('msg') ?>
        <form method="POST" action="<?= base_url('Absen/simpan_tertunda') ?>">
            <div class="form-group">
                <label><b>Pilih Jenis Absen</b></label>
                <select class="form-control" name="pending">
                    <option value="7">Cuti</option>
                    <option value="8">Unpaid Leave</option>
                    <option value="9">Sakit</option>
                    <option value="1">Lupa Absen Masuk</option>
                    <!--option value="10">Libur Shift</option-->
                </select>
            </div>
            <div class="form-group">
                <label><b>Tanggal</b></label>
                <input type="text" class="form-control" name="tgl_absen" required>
            </div>
            <div class="form-group">
                <label><b>Keterangan</b></label>
                <textarea class="form-control" name="keterangan" style="height: 200px;resize: none; " required></textarea>
            </div>

            <button type="submit" class="btn btn-success" style="border-radius: 5px;">Simpan</button>
        </form>
    </div>
    <!-- box waktu server -->

</div><!-- /.row -->

<div class="hr hr32 hr-dotted"></div>

<!-- Tabel Info Absen -->
<div class="row">
    <div class="col-sm-12">
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Absen Masuk</th>
                        <th>Jam Absen Keluar</th>
                        <th>Jenis Absen</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($pending as $v) {
                        if($v->pending == 4){
                            $jenis = 'Cuti';
                            $status = '<b style="color: green">disetujui</b>';
                        }elseif($v->pending == 7){
                            $jenis = 'Cuti';
                            $status = '<b style="color: red">pending</b>';
                        }elseif($v->pending == 5){
                            $jenis = 'Unpaid Leave';
                            $status = '<b style="color: green">disetujui</b>';
                        }elseif($v->pending == 8){
                            $jenis = 'Unpaid Leave';
                            $status = '<b style="color: red">pending</b>';
                        }elseif($v->pending == 6){
                            $jenis = 'Sakit';
                            $status = '<b style="color: green">disetujui</b>';
                        }elseif($v->pending == 9){
                            $jenis = 'Sakit';
                            $status = '<b style="color: red">pending</b>';
                        }elseif($v->pending == 1){
                            $jenis = 'Lupa Absen';
                            $status = '<b style="color: red">pending</b>';
                        }elseif($v->pending == 2){
                            $jenis = 'Lupa Absen';
                            $status = '<b style="color: green">disetujui</b>';
                        }elseif($v->pending == 10){
                            $jenis = 'Libur Shift';
                            $status = '<b style="color: red">pending</b>';
                        }elseif($v->pending == 11){
                            $jenis = 'Libur Shift';
                            $status = '<b style="color: green">disetujui</b>';
                        }else{
                            $jenis = 'None';
                            $status = 'None';
                        }
                        echo '<tr>
                            <td>' . date('d-m-Y',strtotime($v->tgl_absen)) . '</td>
                            <td>' . $v->absen_masuk . '</td>
                            <td>' . $v->absen_pulang . '</td>
                            <td>' . $jenis . '</td>
                            <td>' . $status . '</td>
                        </tr>';
                    }
                    ?>

                </tbody>
            </table>
            <br>
            <?php if($cuti > 0){ ?>
                <a href="<?= base_url('Absen/form_cuti/') ?>" class="btn btn-purple" style="border-radius: 5px;">Form Cuti</a>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Tabel Info Absen -->