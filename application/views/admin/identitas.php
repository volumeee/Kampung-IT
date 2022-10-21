<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- if ada pesan -->
    <?= $this->session->flashdata('message'); ?>

    <!-- Content Row -->
    <div class="row mb-3">

        <div class="col-lg-8 mb-3">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseIdentitasUmum" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseIdentitasUmum">
                    <h6 class="m-0 font-weight-bold text-primary">Identitas Umum</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseIdentitasUmum">
                    <div class="card-body">
                        <!-- form edit identitas -->
                        <form action="<?= base_url('admin/identitas'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-3 text-center">
                                <img src="<?= ($identitas['logo'] == '') ? base_url('assets/img/default-banner-infaq-online-4x4.jpg') : base_url('assets/img/logo/') . $identitas['logo']; ?>" alt="logo <?= $identitas['nama_instansi']; ?>" class="img-thumbnail w-25" id="previewLogoInstansi">
                            </div>
                            <div class="form-group mb-3">
                                <label for="logoInstansi">Logo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="logoInstansi" name="logoInstansi">
                                    <label class="custom-file-label" for="logoInstansi" data-browse="Browse">Pilih file</label>
                                </div>
                                <?= form_error('banner', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="namaInstansi">Nama Instansi</label>
                                <input type="text" class="form-control" id="namaInstansi" name="namaInstansi" placeholder="Nama Organisasi..." value="<?= $identitas['nama_instansi']; ?>" required>
                                <?= form_error('namaInstansi', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat ..." value="<?= $identitas['alamat']; ?>" required>
                                <?= form_error('alamat', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="noTelp">No. Telepon</label>
                                <input type="text" class="form-control" id="noTelp" name="noTelp" placeholder="Nomor Telepon ..." value="<?= $identitas['no_telp']; ?>" required>
                                <?= form_error('noTelp', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email..." value="<?= $identitas['email']; ?>" required>
                                <?= form_error('email', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi..." value="<?= $identitas['deskripsi']; ?>" required>
                                <?= form_error('deskripsi', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="typePost" value="<?= base64_encode('umum'); ?>">
                                <input type="hidden" name="logoOld" value="<?= $identitas['logo']; ?>">
                                <button type="submit" class="btn btn-block btn-primary">Edit</button>
                            </div>
                        </form>
                        <?php if ($identitas['logo'] != '') : ?>
                            <form action="<?= base_url('admin/identitas'); ?>" method="post" class="mt-n2">
                                <div class="form-group">
                                    <input type="hidden" name="typePost" value="<?= base64_encode('deleteLogo'); ?>">
                                    <input type="hidden" name="logoOld" value="<?= $identitas['logo']; ?>">
                                    <button type="submit" class="btn btn-block btn-danger">Delete Logo</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseSystem" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSystem">
                    <h6 class="m-0 font-weight-bold text-primary">Identitas Sistem</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseSystem">
                    <div class="card-body">
                        <!-- form -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="text-center mb-2">Favicon saat ini<br>
                                    <img src="<?= base_url('/assets/img/favicon/') . $identitas['favicon']; ?>" alt="favicon" class="w-50">
                                </p>
                                <?php if ($identitas['favicon'] != 'default.ico') : ?>
                                    <form action="<?= base_url('admin/identitas'); ?>" method="post" class="mb-2 text-center">
                                        <input type="hidden" name="typePost" value="<?= base64_encode('defaultFavicon') ?>">
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Udah yakin belom...?')">Reset</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="text-center mb-2">Icon saat ini<br>
                                    <i class="fas fa-<?= $identitas['icon']; ?> fa-6x"></i>
                                </p>
                                <?php if ($identitas['icon'] != 'briefcase') : ?>
                                    <form action="<?= base_url('admin/identitas'); ?>" method="post" class="mb-2 text-center">
                                        <input type="hidden" name="typePost" value="<?= base64_encode('defaultIcon') ?>">
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Udah yakin belom...?')">Reset</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <form action="<?= base_url('admin/identitas'); ?>" enctype="multipart/form-data" method="post" class="form-row mb-3">
                            <div class="col-12">
                                <label for="faviconOrganisasi">Favicon Baru</label>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="file" class="form-control-file" name="faviconOrganisasi" id="faviconOrganisasi" required>
                                <small class="form-text text-muted pl-1">File type .ico, .jpg, .png ukuran 32x32</small>
                            </div>
                            <div class="col-12 col-md-4 mt-2 mt-md-0">
                                <input type="hidden" name="typePost" value="<?= base64_encode('favicon'); ?>">
                                <button type="submit" class="btn btn-primary btn-block" id="btnGantiFavicon" disabled>Ganti Favicon</button>
                            </div>
                            <?= form_error('faviconOrganisasi', '<small class="text-danger pl-1">', '</small>'); ?>
                        </form>
                        <form action="<?= base_url('admin/identitas'); ?>" method="post" class="form-row mb-3">
                            <div class="col-12 col-md-8">
                                <label for="iconOrganisasi">Icon Baru</label>
                                <input type="text" class="form-control" id="iconOrganisasi" name="iconOrganisasi" placeholder="fontawesome v5.10.12" value="<?= $identitas['icon']; ?>" required>
                                <small class="form-text text-muted pl-1">Font Awesome v5.10.12</small>
                                <?= form_error('iconOrganisasi', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="col-12 col-md-4 my-auto">
                                <input type="hidden" name="typePost" value="<?= base64_encode('icon'); ?>">
                                <button type="submit" class="btn btn-primary mt-2 btn-block">Ganti Icon</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->

</div>
<!-- .container-fluid -->

</div>
<!-- End of Main Content -->

<!-- modal error upload gambar -->
<div class="modal fade" id="errorNotifModal" tabindex="-1" role="dialog" aria-labelledby="errorNotifModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorNotifModalTitle">Halo...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="isiErrorNotifModal"> </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>