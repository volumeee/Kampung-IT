<section class="mobile-apps pt-5 pb-5">
    <div class="container">
        <div class="h4 font-weight-bold text-center mb-4 text-primary">CONTACT</div>
        <div class="card p-3">
            <div class="card-body">
                <!-- if ada pesan -->
                <?= $this->session->flashdata('message'); ?>
                <form action="<?= base_url('home/contact'); ?>" method="POST" class="mb-n3">
                    <div class="form-group mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" placeholder="Nama Anda" name="nama" class="form-control" autocomplete="off" required autofocus>
                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Contoh@email.com" autocomplete="off" required>
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="message">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Ketik pesan di sini ..." autocomplete="off" required></textarea>
                        <?= form_error('message', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-plane"></i>
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>