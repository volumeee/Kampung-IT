<footer class="footer bg-primary">
    <div class="footer-top mb-n4">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-12 mb-4 mb-md-0">
                    <!-- Single Widget -->
                    <div class="single-footer about">
                        <div class="logo-footer">
                            <?php if ($identitas['logo'] != '') : ?>
                                <img class="img-fluid" src="<?= base_url('assets/img/logo/') . $identitas['logo']; ?>" alt="<?= $identitas['nama_instansi']; ?>">
                            <?php else : ?>
                                <i class="fa fa-shopping-bag fa-3x"></i> <span class="logo"><?= $identitas['nama_instansi']; ?></span>
                                <p class="font-italic mt-2"><?= $identitas['deskripsi']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-2 col-md-6 col-12 mb-4 mb-md-0">
                    <!-- Single Widget -->
                    <div class="single-footer links">
                        <h4 class="mb-2">Quick Menu</h4>
                        <ul>
                            <li><a href="<?= base_url(); ?>">Home</a></li>
                            <li><a href="<?= base_url('home/artikel'); ?>">Artikel</a></li>
                            <li><a href="<?= base_url('home/contact'); ?>">Contact Us</a></li>
                            <li><a href="<?= base_url('home/artikel/about-us'); ?>">About Us</a></li>
                        </ul>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-2 col-md-6 col-12 mb-4 mb-md-0">
                    <!-- Single Widget -->
                    <div class="single-footer links">
                        <h4 class="mb-2">Information</h4>
                        <ul>
                            <li><a href="<?= base_url('home/artikel/registrasi-akun'); ?>">Registrasi Akun</a></li>
                            <li><a href="<?= base_url('home/artikel/registrasi-merchant-penyedia-jasa'); ?>">Penyedia Jasa</a></li>
                        </ul>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer social">
                        <h4 class="mb-2">Get In Touch</h4>
                        <!-- Single Widget -->
                        <div class="contact">
                            <ul>
                                <li><?= $identitas['alamat']; ?></li>
                                <li><i class="fa fa-envelope"></i> <?= $identitas['email']; ?></li>
                                <li><i class="fa fa-phone"></i> <?= $identitas['no_telp']; ?></li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                        <ul>
                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                            <li><a href="#"><i class="ti-twitter"></i></a></li>
                            <li><a href="#"><i class="ti-flickr"></i></a></li>
                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                        </ul>
                    </div>
                    <!-- End Single Widget -->
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="copyright-inner border-top">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="left">
                            <p>© 2022 Made With <i class="fa fa-heart text-danger"></i> <?= $identitas['nama_instansi']; ?> - Theme by. <a href="http://indokoding.net" target="_blank">IndoKoding.net</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Core -->
<script src="<?= base_url(); ?>assets/vendor/theme-indomarket/js/core/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/theme-indomarket/js/core/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/theme-indomarket/js/core/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/theme-indomarket/js/core/jquery-ui.min.js"></script>

<!-- Optional plugins -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Argon JS -->
<script src="<?= base_url(); ?>assets/vendor/theme-indomarket/js/argon-design-system.js"></script>

<!-- Main JS-->
<script src="<?= base_url(); ?>assets/vendor/theme-indomarket/js/main.js"></script>
</body>

</html>