<?= $this->session->flashdata('msg') ?>
<form method="POST" action="<?= base_url('Akun/simpan/') ?>">
<input type="hidden" name="id_user" value="<?= $_SESSION['id_akun'] ?>">
<div class="form-group">
    <label>Nama</label>
    <input type="text" class="form-control" name="nama_user" placeholder="Masukkan Nama Anda" value="<?= $user->nama_user ?>" required>
</div>

<div class="form-group">
    <label>Email</label>
    <input type="text" class="form-control" value="<?= $user->email ?>" disabled>
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="password" required>
</div>

<div class="form-group">
    <label>Jabatan</label>
    <input type="text" class="form-control" value="<?= $user->nama_jabatan ?>" disabled>
</div>

<div class="form-group">
    <label>No Telp</label>
    <input type="text" class="form-control" name="no_telp" value="<?= $user->no_telp ?>" placeholder="Masukkan Nomor Telpon Anda" required>
</div>

<div class="form-group">
    <label>Sisa Cuti</label>
    <input type="text" class="form-control" value="<?= $user->sisa_cuti ?>" disabled>
</div>

<button type="submit" class="btn btn-success" style="border-radius: 5px;"><b>Simpan</b></button>
</form>