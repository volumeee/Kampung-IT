<section class="mobile-apps pt-5 pb-5">
    <div class="container">
        <div class="h4 font-weight-bold text-center mb-4 text-primary">ARTIKEL</div>
        <div class="row justify-content-center">
            <?php foreach ($artikel as $art) : ?>
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="card h-100 rounded-4 border-0 shadow overflow-hidden">
                        <div class="img-container">
                            <img src="<?= base_url(); ?>assets/img/artikel/<?= $art['banner']; ?>" class="img-thumbnail" alt="<?= $art['judul']; ?>">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title"><?= $art['judul']; ?></h5>
                            <p class="card-text text-muted"><?= strip_tags(substr($art['isi'], 0, 100)) . ' [...]'; ?></p>
                            <a href="<?= base_url(); ?>home/artikel/<?= $art['link']; ?>" class="btn btn-outline-primary d-block rounded-pill mx-5 mt-auto">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>