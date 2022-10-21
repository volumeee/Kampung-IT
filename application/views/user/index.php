<link href="<?= base_url(); ?>assets/vendor/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="row">
        <div class="col-lg-5 mb-3 order-md-1 order-2">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img" alt="<?= $user['name'] ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $user['name']; ?></h5>
                            <p class="card-text"><?= $user['email']; ?></p>
                            <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']); ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->session->userdata('role_id') == 3) : ?>
            <?php if (isset($merchant) && $merchant['is_active'] == 0) : ?>
                <!-- jika sudah punya toko tapi belum aktif -->
                <div class="col-lg-7 order-md-2 order-1">
                    <!-- Collapsable -->
                    <div class="card shadow mb-4">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseBukaMerchant" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseBukaMerchant">
                            <h6 class="m-0 font-weight-bold text-primary">Aktivasi Penyedia Jasa</h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseBukaMerchant">
                            <div class="card-body">
                                <!-- form add new program -->
                                <div class="form-group">
                                    <label for="nama_usaha" class="font-italic font-weight-bold">Nama Bisnis</label>
                                    <p>
                                        <?= $merchant['nama_usaha']; ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="font-italic font-weight-bold">Deskripsi Bisnis</label>
                                    <p>
                                        <?= $merchant['deskripsi']; ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="font-italic font-weight-bold">Status</label>
                                    <p class="text-danger">
                                        Menunggu untuk Aktivasi
                                    </p>
                                </div>
                                <!-- submit token -->
                                <form action="<?= base_url('user/aktivatemerchant'); ?>" method="post" class="mb-n2">
                                    <div class="form-group">
                                        <label for="token" class="font-italic font-weight-bold">Token Aktivasi <span class="text-danger">*</span></label>
                                        <input type="text" name="token" id="token" autocomplete="off" class="form-control" required autofocus>
                                        <?= form_error('token', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">Submit</button>
                                    </div>
                                </form>
                                <!-- kirim ulang token aktivasi -->
                                <form action="<?= base_url('user/resendcodemerchant'); ?>" method="post">
                                    <input type="hidden" name="email" value="<?= $merchant['email']; ?>">
                                    <input type="hidden" name="nama_usaha" value="<?= $merchant['nama_usaha']; ?>">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-sm btn-block">Kirim ulang token</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!$merchant) : ?>
                <!-- jika belum punya merchant -->
                <div class="col-lg-7 order-md-2 order-1">
                    <!-- Collapsable -->
                    <div class="card shadow mb-4">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseBukaMerchant" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseBukaMerchant">
                            <h6 class="m-0 font-weight-bold text-primary">Pengajuan Penyedia Jasa</h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseBukaMerchant">
                            <div class="card-body">
                                <!-- form add new program -->
                                <form action="<?= base_url('user/openmerchant'); ?>" method="post">
                                    <div class="form-group">
                                        <label for="nama_usaha">Nama Bisnis</label>
                                        <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" autocomplete="off" value="<?= $user['name']; ?>" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori">Kategori</label>
                                        <select class="selectpicker form-control" id="kategori" name="kategori" placeholder="..." autocomplete="off" data-live-search="true" required>
                                            <option value="#" disabled selected>Pilih kategori..</option>
                                            <?php foreach ($kategori as $s) : ?>
                                                <option value="<?= $s['kategori_id']; ?>"><?= $s['kategori']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" value="<?= $user['alamat']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi Bisnis</label>
                                        <textarea rows="3" name="deskripsi" id="deskripsi" class="form-control" autocomplete="off" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script src="<?= base_url(); ?>assets/vendor/bootstrap-select/bootstrap-select.min.js"></script>