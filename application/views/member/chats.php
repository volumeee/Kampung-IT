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
        <!-- list chat -->
        <div class="col-lg-12">
            <!-- Collapsable -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listChat" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="listChat">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Chat</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="listChat">
                    <div class="card-body">
                        <table class="table table-hover table-striped dtableResponsiveOnly">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Merchant</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($chats as $s) : ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $no; ?></th>
                                        <td class="text-center">
                                            <img src="<?= base_url('assets/img/profile/') . $s['image']; ?>" alt="Profile <?= $s['nama_usaha']; ?>" class="img-thumbnail" style="width: 30px;">&nbsp;
                                            <?= $s['nama_usaha']; ?>
                                        </td>
                                        <td class="text-center text-danger"><?= ($s['belum_dibaca'] != 0) ? number_format($s['belum_dibaca'], 0, ",", ".") . ' pesan belum dibaca' : ''; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('member/chat/') . $s['merchant_id']; ?>" class="btn btn-sm mb-1 btn-success" id="editPasien">Buka</a>
                                            <!-- <a href="" data-href="<?= base_url('member/deletechat/') . $s['merchant_id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delArtikel" data-target="#deleteArtikelModal">Delete</a> -->
                                        </td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Merchant</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
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

<!-- delete artikel -->
<div class="modal fade" id="deleteArtikelModal" tabindex="-1" role="dialog" aria-labelledby="deleteArtikelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteArtikelModalLabel">Are You sure to delete this?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Delete" below if you sure to delete.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="cDelArtikel">Delete</a>
            </div>
        </div>
    </div>
</div>