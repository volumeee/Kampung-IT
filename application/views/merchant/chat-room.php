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

        <!-- bqck chat all -->
        <div class="col-lg-12 mb-3">
            <div class="card shadow">
                <div class="my-auto card-body py-3 d-sm-flex align-items-center justify-content-between">
                    <h6 class="mb-2 font-weight-bold text-primary">
                        <?= $userChatting['name']; ?>
                    </h6>
                    <div class="ml-auto">
                        <a href="<?= base_url('merchant/chat'); ?>" class="btn btn-sm btn-primary shadow-sm mb-1 mb-md-0">
                            <i class="fas fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row" style="height: 320px; overflow-y: auto;">
                    <?php foreach ($chat as $c) :
                        if ($c['identify'] == $merchant['merchant_id']) : ?>
                            <div class="col-lg-12">
                                <div class="card bg-secondary text-white float-right mb-3 ml-5">
                                    <div class="card-body">
                                        <?= $c['text']; ?>
                                        <p class="mt-2 mb-n2 text-white text-monospace text-right"><?= date('d', strtotime($c['datetime'])) . ' ' . month(date('n', strtotime($c['datetime'])), 'mmm') . ' ' . date('Y', strtotime($c['datetime'])) . ', ' . date('H:i', strtotime($c['datetime'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="col-lg-12">
                                <div class="card bg-success text-white float-left mb-3 mr-5">
                                    <div class="card-body">
                                        <?= $c['text']; ?>
                                        <p class="mt-2 mb-n2 text-white text-monospace text-right"><?= date('d', strtotime($c['datetime'])) . ' ' . month(date('n', strtotime($c['datetime'])), 'mmm') . ' ' . date('Y', strtotime($c['datetime'])) . ', ' . date('H:i', strtotime($c['datetime'])); ?></p>
                                    </div>
                                </div>
                            </div>
                    <?php endif;
                    endforeach; ?>
                </div>
                <div class="card-footer">
                    <form action="<?= base_url('merchant/sendchat'); ?>" method="POST" class="row">
                        <div class="col-12 col-sm-10 col-md-10 col-lg-10 mb-2"><input type="text" name="pesan" id="pesan" class="form-control" autocomplete="off" maxlength="300" required autofocus></div>
                        <div class="col-12 col-sm-2 col-md-2 col-lg-2">
                            <input type="hidden" name="receiver_id" value="<?= $merchant['merchant_id']; ?>">
                            <input type="hidden" name="sender_id" value="<?= $userChatting['email']; ?>">
                            <button type="submit" class="btn btn-primary btn-block">Kirim</button>
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