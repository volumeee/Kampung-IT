<section class="mobile-apps pt-5 pb-1">
    <div class="container">
        <div class="h4 font-weight-bold text-center mb-4 text-primary">RESULTS "<?= urldecode($this->uri->segment(3)); ?>"</div>
    </div>
</section>
<section class="products-grid pb-4 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12 order-3 order-md-1">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <div class="widget-title">
                            <h3>Categories</h3>
                        </div>
                        <div class="widget-content widget-categories" style="height: 200px; overflow-y: auto;">
                            <ul>
                                <?php if (count($kategori) == 0) : ?>
                                    <li>Tidak ada data.</li>
                                    <?php else :  foreach ($kategori as $k) : ?>
                                        <li><a href="<?= base_url('home/search/') . $k['kategori']; ?>"><?= $k['kategori']; ?></a></li>
                                <?php endforeach;
                                endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12 order-1 order-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="products-top">
                            <div class="products-top-inner pb-4">
                                <div class="products-found">
                                    <p><span><?= format_rupiah($totalFound); ?></span> found</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($results as $p) : ?>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-12 mb-3">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="<?= base_url('home/product/') . $p['post_id']; ?>">
                                        <img src="<?= base_url(); ?>assets/img/post/<?= $p['banner']; ?>" alt="Gambar <?= $p['judul']; ?>" class="img-fluid" />
                                    </a>
                                </div>
                                <div class="product-content">
                                    <a href="<?= base_url('home/product/') . $p['post_id']; ?>"><?= $p['judul']; ?></a>
                                    <div class="product-price">
                                        <p class="text-muted mt-2"><?= $p['nama_usaha']; ?></p>
                                        <p class="text-muted mt-n3 font-italic"><i class="fa fa-map-marker text-success"></i> <?= $p['alamat']; ?></p>
                                    </div>
                                    <div class="product-price">
                                        <p class="text-muted font-weight-bold mt-n1">IDR <?= format_rupiah($p['tarif']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="pagination" style="overflow-x: auto;">
                            <?php for ($i = 1; $i < $totalPages + 1; $i++) : ?>
                                <li class="page-item <?= ($i == $pageNow) ? 'active' : ''; ?>"><a class="page-link" href="<?= base_url('home/search/'); ?><?= $this->uri->segment(3) . '/' . $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>