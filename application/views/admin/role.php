<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-3 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- if ada pesan -->
    <?= $this->session->flashdata('message'); ?>
    <?= validation_errors('<small class="text-danger d-block">', '</small>'); ?>

    <!-- Content Row -->
    <div class="row mb-3">

        <?php foreach ($countUserRole as $cur) : ?>
            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1"><?= $cur['role']; ?></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-600"><?= $cur['total_user']; ?> <small>akun</small></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="row">

        <div class="col-lg-3">
            <!-- Collapsable role -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseRole" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRole">
                    <h6 class="m-0 font-weight-bold text-primary">User Roles</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseRole">
                    <div class="card-body">
                        <!-- form add new role -->
                        <!-- <form action="<?= base_url('admin/role'); ?>" method="post" class="mb-3">
                            <div class="form-row">
                                <div class="col-12 mb-2">
                                    <label class="sr-only" for="role">Tambah Role Baru</label>
                                    <input type="text" class="form-control" id="role" name="role" placeholder="Tambah Role Baru...">
                                    <?= form_error('role', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form> -->

                        <table class="table table-hover table-striped dtableResponsiveNoSearch">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">role_id</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($role as $r) : ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $r['id']; ?></th>
                                        <td><?= $r['role']; ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="btn btn-sm mb-1 btn-warning">Access</a>
                                            <a href="" class="btn btn-sm mb-1 btn-success" data-role="<?= $r['role']; ?>" data-toggle="modal" data-target="#editRoleModal" data-idrole="<?= $r['id']; ?>" id="editRole">Edit</a>
                                            <!-- <a href="" data-href="<?= base_url('admin/deleterole/') . $r['id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delRole" data-target="#deleteRoleModal">Delete</a> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- user -->
        <div class="col-lg-9">
            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">User</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample">
                    <div class="card-body">
                        <!-- btn modal trigger -->
                        <a href="" class="btn btn-primary mb-3 d-block" data-toggle="modal" data-target="#newAkunModal">Buka Form Akun Baru</a>
                        <!-- list user -->
                        <table class="table table-striped table-hover dtableExportResponsive">
                            <thead class="text-center">
                                <th style="width: 5%;">#</th>
                                <th>Username</th>
                                <th>Fullname</th>
                                <th>Role Akses</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($userWithRole as $uwr) : ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $uwr['username']; ?></td>
                                        <td><?= $uwr['name']; ?></td>
                                        <td><?= $uwr['role']; ?></td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-sm mb-1 btn-success" data-fullname="<?= $uwr['name']; ?>" data-idrole="<?= $uwr['role']; ?>" data-email="<?= $uwr['email']; ?>" data-ussname="<?= $uwr['username']; ?>" data-toggle="modal" data-target="#editUserModal" id="editUser">Edit</a>
                                            <?php if ($uwr['username'] !== 'admin') : ?>
                                                <a href="" data-href="<?= base_url('admin/deleteuser/') . $uwr['email']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delUser" data-target="#deleteUserModal">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end of row -->


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal edit role -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/updaterole'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="inputIdRole" id="inputIdRole">
                        <input type="text" class="form-control" id="inputEditRole" name="inputEditRole" placeholder="Edit role name...">
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

<!-- Role Delete Modal-->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Are You sure to delete this?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Delete" below if you sure to delete.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="cDelRole">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah akun -->
<div class="modal fade" id="newAkunModal" tabindex="-1" role="dialog" aria-labelledby="newAkunModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog scrollable" role="document" data-backdrop="static" data-keyboard="false">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAkunModalLabel">Form Tambah Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/adduser'); ?>" method="post" id="formAddUser">
                <div class="modal-body" style="height: 450px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="role_id">Role <span class="text-danger">*</span></label>
                        <select name="role_id" id="role_id" class="form-control selectpicker" data-live-search="true">
                            <option value="#" selected disabled>Pilih Role</option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id'] ?>"><?= $r['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control" id="email" placeholder="email.." autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="username.." autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="fullname">Fullname <span class="text-danger">*</span></label>
                        <input type="text" id="fullname" class="form-control inputan-text-fullname" name="fullname" placeholder="Full name..">
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="input-group-text input-group-prepend" id="showPass" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: 0; cursor: pointer;">
                                <i class="fas fa-eye" id="toggle"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit user -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close closeEditUserModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/updateuser'); ?>" method="post">
                <div class="modal-body" style="height: 500px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="inputEditRoleUser">Role User <span class="text-danger">*</span></label>
                        <select name="inputEditRoleUser" id="inputEditRoleUser" class="form-control selectpicker" data-live-search="true">
                            <option value="#" disabled>Pilih Role</option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id'] ?>"><?= $r['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEditEmail">Email <span class="text-danger">*</span>
                            <abbr title="Bersifat Unique, jika email pernah digunakan maka edit data akan gagal" class="initialism">
                                <i class="fas fa-question-circle"></i>
                            </abbr>
                        </label>
                        <input type="text" class="form-control" id="inputEditEmail" name="inputEditEmail" placeholder="Edit email...">
                    </div>
                    <div class="form-group">
                        <label for="inputEditUsername">Username <span class="text-danger">*</span>
                            <abbr title="Bersifat Unique, jika username pernah digunakan maka edit data akan gagal" class="initialism">
                                <i class="fas fa-question-circle"></i>
                            </abbr>
                        </label>
                        <input type="text" class="form-control" id="inputEditUsername" name="inputEditUsername" placeholder="Edit No. Telp...">
                    </div>
                    <div class="form-group">
                        <label for="inputEditFullname">Fullname <span class="text-danger">*</span></label>
                        <input type="text" class="form-control inputan-text-inputEditFullname" id="inputEditFullname" name="inputEditFullname" placeholder="Edit full name...">
                    </div>
                    <div class="form-group mb-2">
                        <label for="inputEditPassword">New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="inputEditPassword" name="inputEditPassword" placeholder="New password..." disabled>
                            <span class="input-group-text input-group-prepend" id="showHidePass" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: 0; cursor: pointer;">
                                <i class="fas fa-eye" id="toggleShow"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="enablePass" id="enablePass" class="form-group ml-1">
                        <label for="enablePass">Nyalakan edit password</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hiddenInputUsername" id="hiddenInputUsername">
                    <input type="hidden" name="hiddenInputEmail" id="hiddenInputEmail">
                    <button type="button" class="btn btn-secondary closeEditUserModal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- User Delete Modal-->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Are You sure to delete this?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Delete" below if you sure to delete.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="cDelUser">Delete</a>
            </div>
        </div>
    </div>
</div>