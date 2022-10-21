<section class="mobile-apps pt-5 pb-1">
    <div class="container">
        <div class="h4 font-weight-bold text-center mb-4 text-primary">PRODUCT DETAIL</div>
    </div>
</section>
<section class="product-page pb-4 pt-5">
    <div class="container">
        <div class="row product-detail-inner" style="min-height: 710px !important;">
            <div class="col-lg-6 col-md-6 col-12 mb-5 mb-md-0">
                <div id="product-images" class="carousel slide" data-ride="carousel">
                    <!-- slides -->
                    <div class="carousel-inner">
                        <div class="carousel-item active"> <img src="<?= base_url(); ?>assets/img/post/<?= $product['banner']; ?>" alt="Gambar <?= $product['judul']; ?>"> </div>
                    </div> <!-- Left right -->
                    <a class="carousel-control-prev" href="#product-images" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#product-images" data-slide="next"> <span class="carousel-control-next-icon"></span> </a><!-- Thumbnails -->
                    <ol class="carousel-indicators list-inline">
                        <li class="list-inline-item active"> <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#product-images"> <img src="<?= base_url(); ?>assets/img/post/<?= $product['banner']; ?>" class="img-fluid"> </a> </li>
                    </ol>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mt-5 mt-md-0">
                <div class="product-detail">
                    <h2 class="product-name"><?= $product['judul']; ?></h2>
                    <div class="product-price">
                        <span class="price">IDR <?= format_rupiah($product['tarif']); ?></span>
                    </div>
                    <div class="product-short-desc" style="overflow-y: auto;">
                        <?= substr(strip_tags($product['text']), 0, 150); ?>
                    </div>
                    <div class="product-categories mt-3">
                        <ul>
                            <li class="categories-title">
                                <img src="<?= base_url(); ?>assets/img/profile/<?= $product['image']; ?>" alt="Profil <?= $product['nama_usaha']; ?>" class="rounded-circle mr-n1" style="height: 25px; width: 25px;">
                            </li>
                            <li><a href="#"><?= $product['nama_usaha']; ?></a></li>
                        </ul>
                    </div>
                    <div class="product-categories mt-3">
                        <ul>
                            <li class="categories-title">Categories :</li>
                            <li><a href="<?= base_url('home/search/') . $product['kategori']; ?>"><?= $product['kategori']; ?></a></li>
                        </ul>
                    </div>
                    <div class="product-categories mt-n3">
                        <ul>
                            <li class="categories-title">Address :</li>
                            <li><a href="<?= base_url('home/search/') . $product['alamat']; ?>"><?= $product['alamat']; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-details">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">Reviews</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                    <?= $product['text']; ?>
                                </div>
                                <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                    <div class="review-form">
                                        <h3>Write a review</h3>
                                        <form>
                                            <div class="form-group">
                                                <label>Your Name</label>
                                                <input type="text" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Your Review</label>
                                                <textarea cols="4" class="form-control"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" disabled>Submit (in development)</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="other-products pb-4 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <?php foreach ($others as $p) : ?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
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