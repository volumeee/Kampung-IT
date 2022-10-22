<!-- Slider -->
<section class="slider-section pt-4 pb-4">
    <div class="container">
        <div class="slider-inner">
            <div class="row">
                <div class="col-md-3">
                    <nav class="nav-category">
                        <h2>Categories</h2>
                        <ul class="menu-category" style="height: 200px; overflow-y: auto; margin-bottom: 10px;">
                            <?php if (count($kategori) == 0) : ?>
                                <li>Tidak ada data.</li>
                                <?php else :  foreach ($kategori as $k) : ?>
                                    <li><a href="<?= base_url('home/search/') . $k['kategori']; ?>"><?= $k['kategori']; ?></a></li>
                            <?php endforeach;
                            endif; ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-9">
                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php for ($i = 0; $i < count($carousel); $i++) : ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i; ?>" <?= ($i == 0) ? 'class="active"' : ''; ?>></li>
                            <?php endfor; ?>
                        </ol>
                        <div class="carousel-inner shadow-sm rounded">
                            <?php for ($i = 0; $i < count($carousel); $i++) : ?>
                                <a href="<?= base_url('home/artikel/') . $carousel[$i]['link']; ?>" class="carousel-item  <?= ($i == 0) ? 'active' : ''; ?>" title="<?= $carousel[$i]['judul']; ?>">
                                    <img class="d-block w-100" style="height: 230px;" src="<?= base_url(); ?>assets/img/artikel/<?= $carousel[$i]['banner']; ?>" alt="<?= $carousel[$i]['judul']; ?>">
                                    <div class="carousel-caption d-none d-md-block">
                                        <div class="text-white shadow-sm h6"><?= $carousel[$i]['judul']; ?></div>
                                    </div>
                                </a>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of Slider -->
<!-- Product -->
<section class="products-grids trending pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Products</h2>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <?php foreach ($products as $p) : ?>
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
    </div>
</section>
<!-- end of Product -->