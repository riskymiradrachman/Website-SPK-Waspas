<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <!------------------------------------------ menampilkan pesan error/berhasil di dari 'menu' apabila  isi data------------------------------------------------------>
            <?= form_error('nim', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('nama', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('ipk', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('semester', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('pekerjaan_family', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('sktm', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('sktmb', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('universitas', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>
            <!------------------------------------------ menampilkan pesan error/berhasil di dari 'menu' apabila  isi data------------------------------------------------------>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Tambah Data</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">NAMA</th>
                        <th scope="col">IPK</th>
                        <th scope="col">SEMESTER</th>
                        <th scope="col">PEKERJAAN ORANG TUA</th>
                        <th scope="col">SKTM</th>
                        <th scope="col">SKTMB</th>
                        <th scope="col">UNIVERSITAS</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                    <?php $i = 1; ?>
                    <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                    <?php foreach ($mahasiswa as $m) : ?>
                        <tr>
                            <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                            <th scope="row"><?= $i; ?></th>
                            <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>

                            <!------------------------------------------ menampilkan data menu ------------------------------------------------------>
                            <td><?= $m['nim']; ?></td>
                            <td><?= $m['nama']; ?></td>
                            <td><?= $m['ipk']; ?></td>
                            <td><?= $m['semester']; ?></td>
                            <td><?= $m['pekerjaan_family']; ?></td>
                            <td><img src=" <?= base_url('assets/img/sktm/') . $m['sktm']; ?>" width="100px"></td>
                            <td><img src=" <?= base_url('assets/img/sktmb/') . $m['sktmb']; ?>" width="100px"></td>
                            <td><?= $m['universitas']; ?></td>
                            <!------------------------------------------ menampilkan data menu ------------------------------------------------------>
                            <td>
                                <a href=" <?= base_url(); ?>mahasiswa/edit/<?= $m['id']; ?>" class="badge badge-success">Edit</a>
                                <a href="<?= base_url(); ?>mahasiswa/hapus/<?= $m['id']; ?>" class="badge badge-danger float" onclick="return confirm('Yakin Menghapus Data Mahasiswa?'); ">Hapus</a>
                            </td>
                        </tr>
                        <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                        <?php $i++; ?>
                        <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!------------------------------------------------------------------------------------ Modal/pilihan form untuk isi data ------------------------------------------------------------------------------------------>

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Tambah Menu Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--------------------------------------------------------------------------------------- form tambah data ------------------------------------------------------------------------------------------------>
            <!----------------------------------------------------- php buat tambah data ---------------------------------------------->

            <!-- kalau upload file harus ada  enctype="multipart/form-data" -->
            <form action="<?= base_url('mahasiswa'); ?>" method="POST" enctype="multipart/form-data">
                <!------------------------------------------------- php buat tambah data ---------------------------------------------->
                <div class="modal-body">
                    <!-------------------------------------------------------------------- kotak form dari sini ---------------------------------------------->
                    <div class="form-group">
                        <div class="form-group mb-2">
                            <label for="nim">NIM Mahasiswa</label>
                            <input type="text" name="nim" class="form-control" id="nim">
                        </div>
                        <div class="form-group mb-2">
                            <label for="nama">Nama Mahasiswa</label>
                            <input type="text" name="nama" class="form-control" id="nama">
                        </div>
                        <div class="form-group mb-2">
                            <label for="ipk">IPK</label>
                            <input type="text" name="ipk" class="form-control" id="ipk">
                        </div>
                        <div class="form-group mb-2">
                            <label for="semester">SEMESTER</label>
                            <input type="text" name="semester" class="form-control" id="semester">
                        </div>
                        <div class="form-group mb-4">
                            <label for="pekerjaan_family">Pekerjaan Orang Tua</label>
                            <input type="text" name="pekerjaan_family" class="form-control" id="pekerjaan_family">
                        </div>
                        <div class="custom-file mb-4">
                            <input type="file" class="custom-file-input" name="sktm" id="sktm">
                            <label class="custom-file-label" for="sktm">Surat Keterangan Tidak Mampu</label>
                        </div>
                        <div class="custom-file mb-4">
                            <input type="file" class="custom-file-input" name="sktmb" id="sktmb">
                            <label class="custom-file-label" for="sktmb">Surat Keterangan Tidak Menerima Beasiswa Lain</label>
                        </div>
                        <div class="form-group mb-2">
                            <label for="universitas">Universitas</label>
                            <input type="text" name="universitas" class="form-control" id="universitas">
                        </div>
                    </div>
                    <!-------------------------------------------------------------------- kotak form sampai sini -------------------------------------------->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
            <!----------------------------------------------------------------------------------------- form tambah data -------------------------------------------------------------------------------------------->
        </div>
    </div>
</div>