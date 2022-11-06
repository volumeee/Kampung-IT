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
        <!-- list inbox -->
        <div class="col-lg-12">
            <!-- Collapsable -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listInbox" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="listInbox">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Inbox</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="listInbox">
                    <div class="card-body">
                        <table class="table table-hover table-striped dtableResponsiveOnly">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Inbox ID</th>
                                    <th scope="col" class="text-center">Pengirim</th>
                                    <th scope="col" class="text-center">Waktu</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inboxs as $s) : ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $s['inbox_id']; ?></th>
                                        <td><?= $s['nama']; ?></td>
                                        <td><?= date('d', strtotime($s['datetime'])) . ' ' . month(date('n', strtotime($s['datetime'])), 'mmm') . ' ' . date('Y', strtotime($s['datetime'])) . ', ' . date('H:i', strtotime($s['datetime'])); ?></td>
                                        <td class="text-center"><?= ($s['status'] == 0) ? '<i class="fas fa-clock text-danger"></i> Belum dibalas' : '<i class="fas fa-check-circle text-success"></i> Sudah dibalas'; ?></td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-sm mb-1 btn-secondary" data-inboxid="<?= $s['inbox_id']; ?>" data-nama="<?= $s['nama']; ?>" data-email="<?= $s['email']; ?>" data-pesan="<?= $s['pesan']; ?>" data-datetime="<?= date('d', strtotime($s['datetime'])) . ' ' . month(date('n', strtotime($s['datetime'])), 'mmmm') . ' ' . date('Y', strtotime($s['datetime'])) . ', ' . date('H:i', strtotime($s['datetime'])); ?>" data-toggle="modal" data-target="#showInboxModal" id="showInbox">Lihat</a>
                                            <a href="<?= base_url('admin/inbox/') . $s['inbox_id']; ?>" class="btn btn-sm mb-1 btn-success">Balas</a>
                                            <a href="" data-href="<?= base_url('admin/deleteinbox/') . $s['inbox_id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delArtikel" data-target="#deleteArtikelModal">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" class="text-center">Inbox ID</th>
                                    <th scope="col" class="text-center">Pengirim</th>
                                    <th scope="col" class="text-center">Waktu</th>
                                    <th scope="col" class="text-center">Status</th>
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

<!-- show inbox -->
<div class="modal fade" id="showInboxModal" tabindex="-1" role="dialog" aria-labelledby="showInboxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showInboxModalLabel">Inbox ID</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="height: 280px; overflow-y: auto;">
                <table class="table table-borderless">
                    <tr>
                        <td class="font-weight-bold" width="10px">Nama</td>
                        <td width="5px">:</td>
                        <td id="namaInbox"></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold" width="10px">Email</td>
                        <td width="5px">:</td>
                        <td id="emailInbox"></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold" width="10px">Waktu</td>
                        <td width="5px">:</td>
                        <td id="waktuInbox"></td>
                    </tr>
                </table>
                <p id="pesanInbox"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

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