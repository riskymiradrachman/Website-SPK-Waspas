<form action="<?= base_url('mahasiswa/update/' . $mahasiswa[0]['id']); ?>" method="POST">
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <div class="form-group">
            <div class="form-group mb-2">
                <label for="nim">NIM Mahasiswa</label>
                <input type="text" name="nim" class="form-control" id="nim" value="<?= $mahasiswa[0]['nim'] ?>">
            </div>
            <div class="form-group mb-2">
                <label for="nama">Nama Mahasiswa</label>
                <input type="text" name="nama" class="form-control" id="nama" value="<?= $mahasiswa[0]['nama'] ?>">
            </div>
            <div class="form-group mb-2">
                <label for="ipk">IPK</label>
                <input type="text" name="ipk" class="form-control" id="ipk" value="<?= $mahasiswa[0]['ipk'] ?>">
            </div>
            <div class="form-group mb-2">
                <label for="semester">SEMESTER</label>
                <input type="text" name="semester" class="form-control" id="semester" value="<?= $mahasiswa[0]['semester'] ?>">
            </div>
            <div class="form-group mb-4">
                <label for="pekerjaan_family">Pekerjaan Orang Tua</label>
                <input type="text" name="pekerjaan_family" class="form-control" id="pekerjaan_family" value="<?= $mahasiswa[0]['pekerjaan_family'] ?>">
            </div>
            <div class="form-group mb-4">
                <label for="sktm">Surat Keterangan Tidak Mampu</label>
                <input type="text" name="sktm" class="form-control" id="sktm" value="<?= $mahasiswa[0]['sktm'] ?>">
            </div>
            <div class="form-group mb-4">
                <label for="sktmb">Surat Keterangan Tidak Menerima Beasiswa Lain</label>
                <input type="text" name="sktmb" class="form-control" id="sktmb" value="<?= $mahasiswa[0]['sktmb'] ?>">
            </div>
            <div class="form-group mb-2">
                <label for="universitas">Universitas</label>
                <input type="text" name="universitas" class="form-control" id="universitas" value="<?= $mahasiswa[0]['universitas'] ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ubah</button>

    </div>
</form>