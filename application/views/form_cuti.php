<div class="panel-body">
    <form role="form" action="<?= base_url() ?>Absen/cetak_form_cuti/" method="GET" target="_blank">
        <input type="hidden" name="id_user" value="<?= $user->id_akun ?>">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama_user" value="<?= $user->nama_user ?>" readonly>
        </div>
        <div class="form-group">
            <label>Jabatan</label>
            <input type="text" class="form-control" name="jabatan" value="<?= $user->nama_jabatan ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nomor Telpon</label>
            <input type="text" class="form-control" name="no_telp" value="<?= $user->no_telp ?>" readonly>
        </div>
        <div class="form-group">
            <label>Total Cuti</label>
            <input type="text" class="form-control" name="total_cuti" value="<?= $n_cuti ?>" readonly>
        </div>
        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="text" class="form-control" name="tgl_masuk" placeholder="Masukkan tanggal masuk" minlength="10" required>
        </div>
        <div class="form-group">
            <label>Keperluan Cuti</label>
            <input type="text" class="form-control" name="keterangan" maxlength="50" placeholder="Masukkan Keperluan Cuti(Max 50 karakter)" required>
        </div>


        <br>
        <label>Tugas dan Tanggung Jawab diserahkan kepada :</label>
        <div class="form-group">
            <label>Nama</label>
            <select class="form-control" name="id_user_tj">
                <option value="0">-</option>
                <?php 
                foreach ($user_tj as $v) {
                    echo '<option value="' . $v->id_akun . '">' . $v->nama_user . '</option>';
                }
                ?>
            </select>
        </div>

        <br><br>
        <div class="form-group">
            <label>Atasan Langsung</label>
            <select class="form-control" name="id_user_atasan" min="1">
                <?php foreach ($user_atasan as $v) {
                    echo '<option value="' . $v->nama_user . '">' . $v->nama_user . '</option>';
                }
                ?>
            </select>
        </div>

        <br><br>
        <button type="submit" class="btn btn-info"><i class="fa fa-print"></i> Cetak</button>
    </form>
</div>