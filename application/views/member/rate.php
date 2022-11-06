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
        <!-- list review -->
        <div class="col-lg-12">
            <!-- Collapsable -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listReview" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="listReview">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Review</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="listReview">
                    <div class="card-body">
                        <table class="table table-hover table-striped dtableResponsiveOnly">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Post</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rate as $s) : ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $no; ?></th>
                                        <td class="text-center">
                                            <img src="<?= base_url('assets/img/post/') . $s['banner']; ?>" alt="Profile <?= $s['banner']; ?>" class="img-thumbnail" style="width: 30px;">&nbsp;
                                            <?= $s['judul']; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('home/product/') . $s['post_id']; ?>" class="btn btn-sm mb-1 btn-secondary" target="_blank">Lihat</a>
                                            <a href="" class="btn btn-sm mb-1 btn-success" data-reviewid="<?= $s['review_id']; ?>" data-judul="<?= $s['judul']; ?>" data-review="<?= $s['user_review']; ?>" data-toggle="modal" data-target="#editReviewModal" id="editReview">Edit</a>
                                            <a href="" data-href="<?= base_url('member/deletereview/') . $s['review_id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delArtikel" data-target="#deleteArtikelModal">Delete</a>
                                        </td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Post</th>
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

<!-- Modal edit rate -->
<div class="modal fade" id="editReviewModal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewModalLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('member/updatereview'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="inputIdReview" id="inputIdReview">
                        <textarea class="form-control" id="inputEditReview" name="inputEditReview"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>