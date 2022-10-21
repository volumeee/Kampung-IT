<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-3 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- if ada pesan -->
    <?= $this->session->flashdata('message'); ?>

    <div class="row mb-3">

        <!-- form add new role -->
        <div class="col-lg-3">
            <form action="<?= base_url('menu'); ?>" method="post" class="mb-3">
                <div class="form-row">
                    <div class="col-auto mb-2">
                        <label class="sr-only" for="menu">Tambah Menu Baru</label>
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Tambah menu baru...">
                        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>

            <table class="table table-hover table-striped dtableResponsiveNoSearch">
                <thead>
                    <tr class="text-center">
                        <th scope="col">menu_id</th>
                        <th scope="col">Nama</th>
                        <!-- <th scope="col">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row" class="text-center"><?= $m['id']; ?></th>
                            <td><?= $m['menu']; ?></td>
                            <!-- <td>
                                <a href="" data-href="<?= base_url('menu/deletemenu/') . $m['id']; ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMenuModal" id="delMenu">Delete</a>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <!-- show all menu usr -->
        <div class="col-lg-9">
            <table class="table  table-hover table-striped dtableExportResponsive">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">User Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($menuAllUser as $mau) : ?>
                        <tr>
                            <th scope="row" class="text-center"><?= $no++; ?></th>
                            <td><?= $mau['menu']; ?></td>
                            <td><?= $mau['role']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">User Akses</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Delete Modal-->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Are You sure to delete this?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Delete" below if you sure to delete.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="cDelMenu">Delete</a>
            </div>
        </div>
    </div>
</div>