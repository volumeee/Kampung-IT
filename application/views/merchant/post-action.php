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

        <!-- bqck artiekl -->
        <div class="col-lg-12 mb-3">
            <div class="card shadow">
                <div class="my-auto card-body py-3 d-sm-flex align-items-center justify-content-between">
                    <h6 class="mb-2 font-weight-bold text-primary">
                        <?= ($this->uri->segment(3)) ? 'Edit Postingan' : 'Buat Postingan'; ?>
                    </h6>
                    <div class="ml-auto">
                        <a href="<?= base_url('merchant/posting'); ?>" class="btn btn-sm btn-primary shadow-sm mb-1 mb-md-0">
                            <i class="fas fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- workspace artikel -->
        <div class="col-lg-12">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#workspacePosting" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="workspacePosting">
                    <h6 class="m-0 font-weight-bold text-primary">What's going on?</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="workspacePosting">
                    <div class="card-body">
                        <form action="<?= base_url('merchant/postaction'); ?>" method="post" enctype="multipart/form-data">
                            <?php if ($this->uri->segment(3)) : ?>
                                <div class="form-group mb-3 text-center">
                                    <img src="<?= base_url('assets/img/post/') . $postDetail['banner']; ?>" alt="banner <?= $postDetail['judul']; ?>" class="img-thumbnail w-25" id="previewBannerArtikel">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="judulPost">Judul Postingan Pekerjaan<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judulPost" name="judulPost" value="<?= $postDetail['judul']; ?>" autocomplete="off" maxlength="200" autofocus>
                                    <?= form_error('judulPost', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tarif">Tarif Kerja<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tarif" name="tarif" value="<?= format_rupiah($postDetail['tarif']); ?>" autocomplete="off" onkeyup="convertToRupiah(this);">
                                    <?= form_error('tarif', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bannerArtikel">Foto Pekerjaan <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bannerArtikel" name="bannerArtikel">
                                        <label class="custom-file-label" for="bannerArtikel" data-browse="Browse">Pilih file</label>
                                    </div>
                                    <?= form_error('bannerArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="text">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="text" name="text" rows="3"><?= $postDetail['text']; ?></textarea>
                                    <?= form_error('text', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenPost" value="<?= base64_encode('edit'); ?>">
                                    <input type="hidden" name="bannerOldPost" value="<?= $postDetail['banner']; ?>">
                                    <input type="hidden" name="post_id" value="<?= $postDetail['post_id']; ?>">
                                    <button type="submit" class="btn btn-block btn-primary">Edit</button>
                                </div>
                            <?php else : ?>
                                <div class="form-group mb-3 text-center">
                                    <img src="<?= base_url('assets/img/default-banner-infaq-online-4x4.jpg'); ?>" alt="banner artikel" class="img-thumbnail w-25" id="previewBannerArtikel">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="judulPost">Judul Postingan Pekerjaan<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judulPost" name="judulPost" autocomplete="off" maxlength="200" autofocus>
                                    <?= form_error('judulPost', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tarif">Tarif Kerja <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tarif" name="tarif" autocomplete="off" onkeyup="convertToRupiah(this);">
                                    <?= form_error('tarif', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bannerArtikel">Foto Pekerjaan <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bannerArtikel" name="bannerArtikel">
                                        <label class="custom-file-label" for="bannerArtikel" data-browse="Browse">Pilih file</label>
                                    </div>
                                    <?= form_error('bannerArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="text">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="text" name="text" rows="3"></textarea>
                                    <?= form_error('text', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenPost" value="<?= base64_encode('posting'); ?>">
                                    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                                </div>
                            <?php endif; ?>
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

<script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('text');
</script>

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