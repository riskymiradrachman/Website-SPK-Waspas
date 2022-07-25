<form action="<?= base_url('mahasiswa/edit/' . $mahasiswa[0]['id']); ?>" method="POST" enctype="multipart/form-data">
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
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="<?= base_url('assets/img/sktm/') . $mahasiswa[0]['sktm']; ?>" width="100px">
                        </div>
                        <div class="col-sm-10">
                            <div class="col-mb-2">Surat Keterangan Tidak Mampu</div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="sktm" name="sktm">
                                <label class="custom-file-label" for="sktm">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="<?= base_url('assets/img/sktmb/') . $mahasiswa[0]['sktmb']; ?>" width="100px">
                        </div>
                        <div class="col-sm-10">
                            <div class="col-mb-2">Surat Keterangan Tidak Menerima Beasiswa Lain</div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="sktmb" name="sktmb">
                                <label class="custom-file-label" for="sktmb">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="<?= base_url('assets/img/piagam/') . $mahasiswa[0]['piagam']; ?>" width="100px">
                        </div>
                        <div class="col-sm-10">
                            <div class="col-mb-2">Piagam</div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="piagam" name="piagam">
                                <label class="custom-file-label" for="sktmb">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="universitas">Universitas</label>
                <input type="text" name="universitas" class="form-control" id="universitas" value="<?= $mahasiswa[0]['universitas'] ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ubah</button>
    </div>
    </div>
</form>