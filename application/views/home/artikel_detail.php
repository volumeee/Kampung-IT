<section class="mobile-apps pt-5 pb-5">
    <div class="h4 font-weight-bold text-center mb-4 text-primary"><?= $artikel['judul']; ?></div>
    <div class="container">
        <div class="card h-100 rounded-4 border-0 shadow overflow-hidden">
            <div class="rounded text-center">
                <img src="<?= base_url(); ?>assets/img/artikel/<?= $artikel['banner']; ?>" class="img-fluid img-thumbnail" alt="<?= $artikel['judul']; ?>" data-toggle="modal" data-target="#modalImageArtikel">
            </div>
            <div class="card-body d-flex flex-column p-4">
                <h6 class="text-muted"><i class="fa fa-calendar-alt"></i> <?= date('d', strtotime($artikel['tgl_upload'])) . ' ' . month(date('n', strtotime($artikel['tgl_upload'])), 'mmmm') . ' ' . date('Y', strtotime($artikel['tgl_upload'])) . ', ' . date('H:i', strtotime($artikel['tgl_upload'])); ?> | <i class="fa fa-eye"></i> <?= number_format($artikel['dilihat'], 0, ",", "."); ?></h6>
                <div class="mt-4">
                    <?= $artikel['isi']; ?>
                </div>
            </div>
        </div>
        <!-- modal image -->
        <div class="modal fade" id="modalImageArtikel" tabindex="-1" role="dialog" aria-labelledby="modalImageArtikelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="<?= base_url(); ?>assets/img/artikel/<?= $artikel['banner']; ?>" class="img-fluid" alt="<?= $artikel['judul']; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>