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

        <div class="col-md-5">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseProgram" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseProgram">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-folder fa-sm"></i> Kategori</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProgram">
                    <div class="card-body">
                        <!-- form add new program -->
                        <form action="<?= base_url('admin/kategori'); ?>" method="post" class="mb-3">
                            <div class="form-row">
                                <div class="col-12 mb-2">
                                    <label class="sr-only" for="kategori">Tambah Kategori</label>
                                    <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Tambah kategori baru...">
                                    <?= form_error('kategori', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form> <!-- end of form add new program -->
                        <!-- list program -->
                        <table class="table table-hover table-striped dtableResponsiveNoSearch">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($kategori as $r) : ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $no++; ?></th>
                                        <td><?= $r['kategori']; ?></td>
                                        <td>
                                            <a href="" class="btn btn-sm mb-1 btn-success" data-idprogram="<?= $r['kategori_id']; ?>" data-program="<?= $r['kategori']; ?>" data-toggle="modal" data-target="#editProgramModal" id="editProgram">Edit</a>
                                            <a href="" data-href="<?= base_url('admin/deletekategori/') . $r['kategori_id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delProgram" data-target="#deleteProgramModal">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table> <!-- end of list program -->
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

<!-- Modal edit program -->
<div class="modal fade" id="editProgramModal" tabindex="-1" role="dialog" aria-labelledby="editProgramModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProgramModalLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/updateprogram'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="inputIdProgram" id="inputIdProgram">
                        <input type="text" class="form-control" id="inputEditProgram" name="inputEditProgram" placeholder="Edit program name...">
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

<!-- Modal delete program -->
<div class="modal fade" id="deleteProgramModal" tabindex="-1" role="dialog" aria-labelledby="deleteProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProgramModalLabel">Are You sure to delete this?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Delete" below if you sure to delete.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="cDelProgram">Delete</a>
            </div>
        </div>
    </div>
</div>