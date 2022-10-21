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
                        <a href="<?= base_url('admin/artikel'); ?>" class="btn btn-sm btn-primary shadow-sm mb-1 mb-md-0">
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
                <a href="#workspaceArtikel" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="workspaceArtikel">
                    <h6 class="m-0 font-weight-bold text-primary">What's going on?</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="workspaceArtikel">
                    <div class="card-body">
                        <form action="<?= base_url('admin/artikelaction'); ?>" method="post" enctype="multipart/form-data">
                            <?php if ($this->uri->segment(3)) : ?>
                                <div class="form-group mb-3 text-center">
                                    <img src="<?= base_url('assets/img/artikel/') . $artikelDetail['banner']; ?>" alt="banner <?= $artikelDetail['judul']; ?>" class="img-thumbnail w-25" id="previewBannerArtikel">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="judulArtikel">Judul <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judulArtikel" name="judulArtikel" value="<?= $artikelDetail['judul']; ?>" autocomplete="off" autofocus>
                                    <?= form_error('judulArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="linkUrlSlug">URL Slug
                                        <span class="text-danger">*</span>
                                        <abbr title="URL ini bersifat unique dan menjadi rujukan untuk memuat artikel" class="initialism">
                                            <i class="fas fa-question-circle"></i>
                                        </abbr>
                                    </label>
                                    <input type="text" class="form-control" id="linkUrlSlug" name="linkUrlSlug" autocomplete="off" maxlength="150" value="<?= $artikelDetail['link']; ?>">
                                    <?= form_error('linkUrlSlug', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bannerArtikel">Banner <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bannerArtikel" name="bannerArtikel">
                                        <label class="custom-file-label" for="bannerArtikel" data-browse="Browse">Pilih file</label>
                                    </div>
                                    <?= form_error('bannerArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="isiArtikel">Isi Artikel <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="isiArtikel" name="isiArtikel" rows="3"><?= $artikelDetail['isi']; ?></textarea>
                                    <?= form_error('isiArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenArtikel" value="<?= base64_encode('edit'); ?>">
                                    <input type="hidden" name="bannerOldArtikel" value="<?= $artikelDetail['banner']; ?>">
                                    <input type="hidden" name="LinkUrlSlugOldArtikel" value="<?= $artikelDetail['link']; ?>">
                                    <button type="submit" class="btn btn-block btn-primary">Edit</button>
                                </div>
                            <?php else : ?>
                                <div class="form-group mb-3 text-center">
                                    <img src="<?= base_url('assets/img/default-banner-infaq-online-4x4.jpg'); ?>" alt="banner artikel" class="img-thumbnail w-25" id="previewBannerArtikel">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="judulArtikel">Judul <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judulArtikel" name="judulArtikel" autocomplete="off" autofocus>
                                    <?= form_error('judulArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="linkUrlSlug">URL Slug
                                        <span class="text-danger">*</span>
                                        <abbr title="URL ini bersifat unique dan menjadi rujukan untuk memuat artikel" class="initialism">
                                            <i class="fas fa-question-circle"></i>
                                        </abbr>
                                    </label>
                                    <input type="text" class="form-control" id="linkUrlSlug" name="linkUrlSlug" autocomplete="off" maxlength="150">
                                    <?= form_error('linkUrlSlug', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bannerArtikel">Banner <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bannerArtikel" name="bannerArtikel">
                                        <label class="custom-file-label" for="bannerArtikel" data-browse="Browse">Pilih file</label>
                                    </div>
                                    <?= form_error('bannerArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="isiArtikel">Isi Artikel <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="isiArtikel" name="isiArtikel" rows="3"></textarea>
                                    <?= form_error('isiArtikel', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenArtikel" value="<?= base64_encode('posting'); ?>">
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
    CKEDITOR.replace('isiArtikel');
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