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

        <!-- add artiekl -->
        <div class="col-lg-12 mb-3">
            <div class="card shadow">
                <div class="my-auto card-body py-3 d-sm-flex align-items-center justify-content-between">
                    <h6 class="mb-2 font-weight-bold text-primary">Form Tambah Postingan</h6>
                    <div class="ml-auto">
                        <a href="<?= base_url('merchant/postaction'); ?>" class="btn btn-sm btn-primary shadow-sm mb-1 mb-md-0">
                            <i class="fas fa-plus-circle"></i> Buat Postingan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- list artikel -->
        <div class="col-lg-12">
            <!-- Collapsable -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listArtikel" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="listArtikel">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Postingan</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="listArtikel">
                    <div class="card-body">
                        <table class="table table-hover table-striped dtableExportResponsive">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Banner</th>
                                    <th scope="col">Tgl. Publikasi</th>
                                    <th scope="col">Dilihat</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($postingan as $s) : ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $no; ?></th>
                                        <td><?= $s['judul']; ?></td>
                                        <td class="text-center">
                                            <img src="<?= base_url('assets/img/post/') . $s['banner']; ?>" alt="banner <?= $s['judul']; ?>" class="img-thumbnail" style="width: 100px;">
                                        </td>
                                        <td><?= date('d', strtotime($s['datetime'])) . ' ' . month(date('n', strtotime($s['datetime'])), 'mmm') . ' ' . date('Y', strtotime($s['datetime'])) . ' ' . date('H:i', strtotime($s['datetime'])); ?></td>
                                        <td class="text-center"><?= number_format($s['dilihat'], 0, ",", "."); ?>x</td>
                                        <td class="text-center">
                                            <a href="<?= base_url('merchant/postaction/') . $s['post_id']; ?>" class="btn btn-sm mb-1 btn-success" id="editPasien">Edit</a>
                                            <a href="" data-href="<?= base_url('merchant/deletepost/') . $s['post_id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delArtikel" data-target="#deleteArtikelModal">Delete</a>
                                        </td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Banner</th>
                                    <th scope="col">Tgl. Publikasi</th>
                                    <th scope="col">Dilihat</th>
                                    <th scope="col">Action</th>
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