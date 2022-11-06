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
                        <?= $inbox['inbox_id']; ?>
                    </h6>
                    <div class="ml-auto">
                        <a href="<?= base_url('admin/inbox'); ?>" class="btn btn-sm btn-primary shadow-sm mb-1 mb-md-0">
                            <i class="fas fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- workspace reply -->
        <div class="col-lg-12 mb-3">
            <!-- Collapsable role -->
            <div class="card shadow">
                <!-- Card Header - Accordion -->
                <a href="#workspaceShowPesan" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="workspaceShowPesan">
                    <h6 class="m-0 font-weight-bold text-primary">Isi Pesan</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="workspaceShowPesan">
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="font-weight-bold" width="10px">Nama</td>
                                <td width="5px">:</td>
                                <td><?= $inbox['nama']; ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold" width="10px">Email</td>
                                <td width="5px">:</td>
                                <td><?= $inbox['email']; ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold" width="10px">Waktu</td>
                                <td width="5px">:</td>
                                <td>
                                    <?= date('d', strtotime($inbox['datetime'])) . ' ' . month(date('n', strtotime($inbox['datetime'])), 'mmmm') . ' ' . date('Y', strtotime($inbox['datetime'])) . ', ' . date('H:i', strtotime($inbox['datetime'])); ?>
                                </td>
                            </tr>
                        </table>
                        <p><?= $inbox['pesan']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- workspace reply -->
        <div class="col-lg-12">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#workspaceReply" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="workspaceReply">
                    <h6 class="m-0 font-weight-bold text-primary">Balas Pesan</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="workspaceReply">
                    <div class="card-body">
                        <form action="<?= base_url('admin/inboxreply'); ?>" method="post">
                            <div class="form-group mb-3">
                                <textarea class="form-control" id="balas_pesan" name="balas_pesan" rows="3"></textarea>
                                <?= form_error('balas_pesan', '<small class="text-danger pl-1">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="inbox_id" value="<?= $inbox['inbox_id']; ?>">
                                <input type="hidden" name="email" value="<?= $inbox['email']; ?>">
                                <input type="hidden" name="pesan_singkat" value="<?= substr($inbox['pesan'], 0, 50); ?>">
                                <input type="hidden" name="waktu" value="<?= date('d', strtotime($inbox['datetime'])) . ' ' . month(date('n', strtotime($inbox['datetime'])), 'mmm') . ' ' . date('Y', strtotime($inbox['datetime'])) . ', ' . date('H:i', strtotime($inbox['datetime'])); ?>">
                                <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                            </div>
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
    CKEDITOR.replace('balas_pesan');
</script>