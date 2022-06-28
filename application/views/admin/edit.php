<form action="<?= base_url('admin/update/' . $user[0]['id']); ?>" method="POST">
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <div class="form-group">
            <div class="form-group mb-2">
                <label for="email">Email Mahasiswa</label>
                <input type="text" name="email" class="form-control" id="email" value="<?= $user[0]['email'] ?>">
            </div>
            <div class="form-group mb-2">
                <label for="nama">Nama Mahasiswa</label>
                <input type="text" name="name" class="form-control" id="name" value="<?= $user[0]['name'] ?>">
            </div>
            <div class="form-group mb-2">
                <label for="password">Password</label>
                <input type="text" name="password" class="form-control" id="password" value="<?= $user[0]['password'] ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ubah</button>

    </div>
</form>