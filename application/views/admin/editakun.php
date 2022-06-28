<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <!------------------------------------------ menampilkan pesan error/berhasil di dari 'menu' apabila  isi data------------------------------------------------------>
            <?= form_error('admin/editakun', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>
            <!------------------------------------------ menampilkan pesan error/berhasil di dari 'menu' apabila  isi data------------------------------------------------------>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newAkunModal">Tambah Akun</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Password</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                    <?php $i = 1; ?>
                    <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                    <?php foreach ($admin as $a) : ?>
                        <tr>
                            <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>
                            <th scope="row"><?= $i; ?></th>
                            <!------------------------------------------ mengurutkan nomor ------------------------------------------------------>

                            <!------------------------------------------ menampilkan data menu ------------------------------------------------------>
                            <td><?= $a['email']; ?></td>
                            <td><?= $a['name']; ?></td>
                            <td><?= $a['password']; ?></td>
                            <!------------------------------------------ menampilkan data menu ------------------------------------------------------>
                            <td>
                                <a href="<?= base_url(); ?>admin/edit/<?= $a['id']; ?>" class="badge badge-success">Edit</a>
                                <a href="<?= base_url(); ?>admin/hapus/<?= $a['id']; ?>" class="badge badge-danger float" onclick="return confirm('Anda yakin menghapus akun?'); ">Hapus</a>
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
<div class="modal fade" id="newAkunModal" tabindex="-1" role="dialog" aria-labelledby="newAkunModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAkunModalLabel">Tambah Akun Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!--------------------------------------------------------------------------------------- form tambah data ------------------------------------------------------------------------------------------------>
            <!----------------------------------------------------- php buat tambah data ---------------------------------------------->
            <form class='user' method="POST" action="<?= base_url('admin/editakun'); ?>">
                <!------------------------------------------------- php buat tambah data ---------------------------------------------->
                <div class="modal-body">
                    <!-------------------------------------------------------------------- kotak form dari sini ---------------------------------------------->
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Masukan nama lengkap" value="<?= set_value('name'); ?>">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Masukan email" value="<?= set_value('email'); ?>">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password : minimal 3 karakter">
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulang Password ">
                        </div>
                    </div>
                    <!-------------------------------------------------------------------- kotak form sampai sini -------------------------------------------->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-user btn-block" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Buat Akun
                    </button>
                </div>
            </form>
            <!----------------------------------------------------------------------------------------- form tambah data -------------------------------------------------------------------------------------------->
        </div>
    </div>
</div>