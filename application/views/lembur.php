<div class="row">
    <!-- box waktu server -->
    <div class="col-xs-12">
        <?= $this->session->flashdata('msg') ?>
        <form method="POST" action="<?= base_url('Lembur/simpan_lembur') ?>">
            <div class="form-group">
                <label><b>Mulai Lembur</b></label>
                <input type="text" class="form-control" name="mulai_lembur" id="mulai_lembur" required>
            </div>
            <div class="form-group">
                <label><b>Selesai Lembur</b></label>
                <input type="text" class="form-control" name="selesai_lembur" id="selesai_lembur" required>
            </div>
            <div class="form-group">
                <label><b>Tanggal Lembur</b></label>
                <input type="text" class="form-control" name="tgl_lembur" required>
            </div>
            <div class="form-group">
                <label><b>Keterangan</b></label>
                <textarea class="form-control" name="keterangan" style="height: 200px;resize: none; "></textarea>
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
                        <th>Tanggal Lembur</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($lembur as $v) {
                        if($v->status_lembur == 1){
                            $status = '<b style="color: green">disetujui</b>';
                        }else{
                            $status = '<b style="color: red">sedang ditinjau</b>';
                        }
                        echo '<tr>
                        <td>' . date('d-m-Y', strtotime($v->tgl_lembur)) . '</td>
                        <td>' . $v->mulai_lembur . '</td>
                        <td>' . $v->selesai_lembur . '</td>
                        <td>' . $status . '</td>
                    </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Tabel Info Absen -->