<!-- Add Modal -->
<div class="modal fade" id="deletePicture" tabindex="-1" role="dialog" aria-labelledby="deletePictureLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePictureLabel">Halo...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are You sure to delete Your profile picture?
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('user/edit'); ?>" method="post">
                    <input type="hidden" id="email" name="email" value="<?= $user['email']; ?>">
                    <input type="hidden" id="name" name="name" value="<?= $user['name']; ?>">
                    <input type="hidden" id="image" name="image" value="<?= $user['image']; ?>">
                    <input type="hidden" id="status" name="status" value="ZGVsZXRl">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="row">

        <div class="col-lg-8">
            <div class="alert alert-primary mb-4 text-center" role="alert">
                File-type: <strong>JPG|GIF|PNG</strong> Max-size: <strong>8 MB</strong>
            </div>

            <?= form_open_multipart('user/edit'); ?>
            <div class="form-group row">
                <label for="emailNew" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <div class="form-control-plaintext"><?= $user['email']; ?></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Full Name <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" autocomplete="off">
                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="usernameNew" class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="usernameNew" name="usernameNew" value="<?= $user['username']; ?>" autocomplete="off">
                    <?= form_error('usernameNew', '<small class="text-danger">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="no_telp" class="col-sm-2 col-form-label">No. Telp</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $user['no_telp']; ?>" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea name="alamat" id="alamat" class="form-control" rows="3"><?= $user['alamat']; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">Picture</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="" class="img-thumbnail">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file mt-1">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <input type="hidden" id="email" name="email" value="<?= $user['email']; ?>">
                    <input type="hidden" id="username" name="username" value="<?= $user['username']; ?>">
                    <button type="submit" class="btn btn-primary my-1">Edit</button>
                    <?php if ($user['image'] !== 'default.jpg') : ?>
                        <button type="button" class="btn btn-danger my-1" data-toggle="modal" data-target="#deletePicture">Delete My Profile Picture</button>
                    <?php endif; ?>

                </div>
            </div>

            </>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->