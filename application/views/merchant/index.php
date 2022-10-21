<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-3 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- if ada pesan -->
    <?= $this->session->flashdata('message'); ?>

    <!-- Content Row -->
    <div class="row mb-3">
        <div class="col-lg-7">
            <!-- Collapsable -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="<?= base_url('merchant'); ?>" method="post">
                        <div class="form-group">
                            <label for="nama_usaha">Nama Bisnis</label>
                            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" autocomplete="off" value="<?= $merchant['nama_usaha']; ?>" autofocus required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="selectpicker form-control" id="kategori" name="kategori" placeholder="..." autocomplete="off" data-live-search="true" required>
                                <option value="#" disabled selected>Pilih kategori..</option>
                                <?php foreach ($kategori as $s) : ?>
                                    <option value="<?= $s['kategori_id']; ?>" <?= ($s['kategori_id'] == $merchant['kategori']) ? 'selected' : ''; ?>><?= $s['kategori']; ?> <?= ($s['kategori_id'] == $merchant['kategori']) ? '(terakhir dipilih)' : ''; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" value="<?= $merchant['alamat']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Bisnis</label>
                            <textarea rows="3" name="deskripsi" id="deskripsi" class="form-control" autocomplete="off" required><?= $merchant['deskripsi']; ?>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="nama_usaha_old" value="<?= $merchant['nama_usaha']; ?>">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of row -->

</div>
<!-- .container-fluid -->

</div>
<!-- End of Main Content -->