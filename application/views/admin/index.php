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

        <!-- last login akun -->
        <div class="col-lg-12 mb-3">
            <!-- Collapsable role -->
            <div class="card shadow">
                <!-- Card Header - Accordion -->
                <a href="#collapseLastLogin" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseLastLogin">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Akun</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseLastLogin">
                    <div class="card-body">
                        <table class="table table-hover table-striped dtableResponsiveOnly">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Fullname</th>
                                    <th scope="col">User Role</th>
                                    <th scope="col">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($lastLogin as $n) : ?>
                                    <tr>
                                        <td><?= $n['fullname']; ?></td>
                                        <td><?= $n['role']; ?></td>
                                        <td scope="row"><?= $n['last_login']; ?></td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th scope="col">Fullname</th>
                                    <th scope="col">User Role</th>
                                    <th scope="col">Waktu</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of last login akun -->

        <!-- bakup -->
        <div class="col-lg-6 mb-3">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseBackupDb" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseBackupDb">
                    <h6 class="m-0 font-weight-bold text-primary">Backup Database</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseBackupDb">
                    <div class="card-body">
                        <a href="<?= base_url('/admin/downloadBackupDb'); ?>" class="btn btn-sm btn-success shadow-sm">Download Backup</a>
                        <span>Format file (.zip)</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of bakup -->

        <!-- restore -->
        <div class="col-lg-6 mb-3">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseRestoreDb" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRestoreDb">
                    <h6 class="m-0 font-weight-bold text-primary">Restore Database</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseRestoreDb">
                    <div class="card-body">
                        <form action="<?= base_url('/admin/restoreDb'); ?>" method="POST" enctype="multipart/form-data" class="form-row">
                            <div class="col-md-10 mb-3 mb-md-0 form-group my-md-auto">
                                <label for="restoreDbFile">Upload file DbKampungIt (.sql)</label>
                                <input type="file" class="form-control-file" id="restoreDbFile" name="restoreDbFile" required>
                            </div>
                            <div class="col-md-2 my-md-auto">
                                <button type="submit" class="btn btn-primary shadow-sm btn-block">Restore</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of restore -->

    </div>
    <!-- end of row -->

</div>
<!-- .container-fluid -->

</div>
<!-- End of Main Content -->