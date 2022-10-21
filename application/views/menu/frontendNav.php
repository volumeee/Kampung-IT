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

        <!-- list menu -->
        <div class="col-md-5">
            <!-- Collapsable menufe -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseFrontMenu" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseFrontMenu">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-folder fa-sm"></i> Menu</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseFrontMenu">
                    <div class="card-body">
                        <!-- btn modal trigger -->
                        <a href="" class="btn btn-primary mb-3 d-block" data-toggle="modal" data-target="#newMenuModal">Form Menu Baru</a>
                        <!-- list user -->
                        <table class="table table-striped table-hover dtableExportResponsive">
                            <thead class="text-center">
                                <th style="width: 5%;">#</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($menu as $uwr) : ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $uwr['title']; ?></td>
                                        <td><?= $uwr['url']; ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-<?= ($uwr['is_active'] > 0) ? 'info' : 'warning'; ?>"><?= ($uwr['is_active'] > 0) ? 'Aktif' : 'Non-aktif'; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-sm mb-1 btn-success" data-idmf="<?= $uwr['mf_id']; ?>" data-title="<?= $uwr['title']; ?>" data-url="<?= $uwr['url']; ?>" data-isactive="<?= $uwr['is_active']; ?>" data-strisactive="<?= ($uwr['is_active'] > 0) ? 'Aktif' : 'Non-aktif'; ?>" data-toggle="modal" data-target="#EditMenuModal" id="editMenuFront">Edit</a>
                                            <a href="" data-href="<?= base_url('menu/deletemenufe/') . $uwr['mf_id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delFrontendNav" data-target="#deleteFrontendNavModal">Delete</a>
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

        <!-- list submenu -->
        <div class="col-md-7">
            <!-- Collapsable submenufe -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseFrontSubMenu" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseFrontSubMenu">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-folder-open fa-sm"></i> Sub Menu</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseFrontSubMenu">
                    <div class="card-body">
                        <!-- btn modal trigger -->
                        <a href="" class="btn btn-primary mb-3 d-block" data-toggle="modal" data-target="#newSubmenuModal">Form Submenu Baru</a>
                        <!-- list user -->
                        <table class="table table-striped table-hover dtableExportResponsive">
                            <thead class="text-center">
                                <th style="width: 5%;">#</th>
                                <th>Title</th>
                                <th>Parent Menu</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($submenu as $uwr) : ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $uwr['title']; ?></td>
                                        <td>
                                            <span class="badge badge-light"><?= $uwr['parent_menu']; ?></span>
                                        </td>
                                        <td><?= $uwr['url']; ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-<?= ($uwr['is_active'] > 0) ? 'info' : 'warning'; ?>"><?= ($uwr['is_active'] > 0) ? 'Aktif' : 'Non-aktif'; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-sm mb-1 btn-success" data-idmfd="<?= $uwr['mfd_id']; ?>" data-title="<?= $uwr['title']; ?>" data-url="<?= $uwr['url']; ?>" data-parent="<?= $uwr['parent_menu']; ?>" data-isactive="<?= $uwr['is_active']; ?>" data-strisactive="<?= ($uwr['is_active'] > 0) ? 'Aktif' : 'Non-aktif'; ?>" data-toggle="modal" data-target="#EditSubmenuModal" id="editSubmenuFront">Edit</a>
                                            <a href="" data-href="<?= base_url('menu/deletesubmenufe/') . $uwr['mfd_id']; ?>" class="btn btn-sm mb-1 btn-danger" data-toggle="modal" id="delFrontendNav" data-target="#deleteFrontendNavModal">Delete</a>
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

        <!-- preview menu submenu frontend -->
        <div class="col-md-12">
            <!-- Collapsable preview fe -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapsePreviewFrontendNav" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapsePreviewFrontendNav">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Frontend Navbar</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapsePreviewFrontendNav">
                    <div class="card-body">
                        <?php if (count($frontendNav) > 0) : ?>
                            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
                                <a class="navbar-brand" href="#"><?= $identitas['nama_instansi']; ?></a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                    <ul class="nav ml-auto">
                                        <?php foreach ($frontendNav['menu'] as $m) : ?>
                                            <?php if (count($m['submenu']) > 0) : ?>
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="<?= $m['url_menu']; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?= $m['title_menu']; ?></a>
                                                    <div class="dropdown-menu">
                                                        <?php foreach ($m['submenu'] as $sm) : ?>
                                                            <a class="dropdown-item" href="<?= $sm['url_submenu']; ?>"><?= $sm['title_submenu']; ?></a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </li>
                                            <?php else : ?>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="<?= $m['url_menu']; ?>"><?= $m['title_menu']; ?></a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </nav>
                        <?php else : ?>
                            <p class="text-center">Kosong</p>
                        <?php endif; ?>
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

<!-- Modal tambah menu -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog scrollable" role="document" data-backdrop="static" data-keyboard="false">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Tambah Menu</h5>
                <button type="button" class="close closeAddMenuFeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/menuFrontendAction'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body" style="height: 280px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="titleMenuFe">Title <span class="text-danger">*</span></label>
                        <input type="text" name="titleMenuFe" id="titleMenuFe" class="form-control" placeholder="Title menu.." autocomplete="off" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="urlMenuFe">URL
                            <span class="text-danger">*</span>
                            <abbr title="Jika menu memiliki submenu cukup masukkan #" class="initialism">
                                <i class="fas fa-question-circle"></i>
                            </abbr>
                        </label>
                        <input type="text" name="urlMenuFe" class="form-control" id="urlMenuFe" placeholder="URL tujuan.." autocomplete="off" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="d-block" for="aktifMenuFe">Is Aktif? <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="isActiveMenuFe" id="aktifMenuFe" value="1">
                            <label class="form-check-label" for="aktifMenuFe">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="isActiveMenuFe" id="nonaktifMenuFe" value="0">
                            <label class="form-check-label" for="nonaktifMenuFe">Non-aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="token" value="<?= base64_encode('addMenuFe'); ?>">
                    <button type="button" class="btn btn-secondary closeAddMenuFeModal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal tambah submenu -->
<div class="modal fade" id="newSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubmenuModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog scrollable" role="document" data-backdrop="static" data-keyboard="false">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubmenuModalLabel">Tambah Submenu</h5>
                <button type="button" class="close closeAddSubmenuFeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/menuFrontendAction'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body" style="height: 370px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="parent_idSubmenuFe">Menu Parent <span class="text-danger">*</span></label>
                        <select name="parent_idSubmenuFe" id="parent_idSubmenuFe" class="form-control">
                            <option value="#" selected disabled>Pilih menu parent</option>
                            <?php foreach ($menu as $r) : ?>
                                <option value="<?= $r['mf_id'] ?>"><?= $r['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="titleSubmenuFe">Title <span class="text-danger">*</span></label>
                        <input type="text" name="titleSubmenuFe" id="titleMenuFe" class="form-control" placeholder="Title submenu.." autocomplete="off" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="urlSubmenuFe">URL
                            <span class="text-danger">*</span>
                            <abbr title="Jika menu memiliki submenu cukup masukkan #" class="initialism">
                                <i class="fas fa-question-circle"></i>
                            </abbr>
                        </label>
                        <input type="text" name="urlSubmenuFe" class="form-control" id="urlSubmenuFe" placeholder="URL tujuan.." autocomplete="off" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="d-block" for="aktifSubmenuFe">Is Aktif? <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="isActiveSubmenuFe" id="aktifSubmenuFe" value="1">
                            <label class="form-check-label" for="aktifSubmenuFe">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="isActiveSubmenuFe" id="SubmenuFe" value="0">
                            <label class="form-check-label" for="SubmenuFe">Non-aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="token" value="<?= base64_encode('addSubmenuFe'); ?>">
                    <button type="button" class="btn btn-secondary closeAddSubmenuFeModal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit menu -->
<div class="modal fade" id="EditMenuModal" tabindex="-1" role="dialog" aria-labelledby="EditMenuModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog scrollable" role="document" data-backdrop="static" data-keyboard="false">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditMenuModalLabel">Edit Menu</h5>
                <button type="button" class="close closeEditMenuFeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/menuFrontendAction'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body" style="height: 300px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="titleMenuFeEdit">Title <span class="text-danger">*</span></label>
                        <input type="text" name="titleMenuFeEdit" id="titleMenuFeEdit" class="form-control" placeholder="Title menu.." autocomplete="off" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="urlMenuFeEdit">URL
                            <span class="text-danger">*</span>
                            <abbr title="Jika menu memiliki submenu cukup masukkan #" class="initialism">
                                <i class="fas fa-question-circle"></i>
                            </abbr>
                        </label>
                        <input type="text" name="urlMenuFeEdit" class="form-control" id="urlMenuFeEdit" placeholder="URL tujuan.." autocomplete="off" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="d-block" for="isActiveMenuFeEdit">Is Aktif? <span class="text-danger">*</span></label>
                        <select name="isActiveMenuFeEdit" id="isActiveMenuFeEdit" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Non-aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="token" value="<?= base64_encode('editMenuFe'); ?>">
                    <input type="hidden" name="hiddenTitleMfOld" id="hiddenTitleMfOld">
                    <input type="hidden" name="hiddenMfId" id="hiddenMfId">
                    <button type="button" class="btn btn-secondary closeEditMenuFeModal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit submenu -->
<div class="modal fade" id="EditSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="EditSubmenuModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog scrollable" role="document" data-backdrop="static" data-keyboard="false">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditSubmenuModalLabel">Edit Submenu</h5>
                <button type="button" class="close closeEditSubmenuFeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/menuFrontendAction'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body" style="height: 390px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="parent_idSubmenuFeEdit">Menu Parent <span class="text-danger">*</span></label>
                        <select name="parent_idSubmenuFeEdit" id="parent_idSubmenuFeEdit" class="form-control">
                            <option value="#" selected disabled>Pilih menu parent</option>
                            <?php foreach ($menu as $r) : ?>
                                <option value="<?= $r['mf_id'] ?>"><?= $r['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="titleSubmenuFeEdit">Title <span class="text-danger">*</span></label>
                        <input type="text" name="titleSubmenuFeEdit" id="titleSubmenuFeEdit" class="form-control" placeholder="Title submenu.." autocomplete="off" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="urlSubmenuFeEdit">URL
                            <span class="text-danger">*</span>
                            <abbr title="Jika menu memiliki submenu cukup masukkan #" class="initialism">
                                <i class="fas fa-question-circle"></i>
                            </abbr>
                        </label>
                        <input type="text" name="urlSubmenuFeEdit" class="form-control" id="urlSubmenuFeEdit" placeholder="URL tujuan.." autocomplete="off" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="d-block" for="isActiveSubmenuFeEdit">Is Aktif? <span class="text-danger">*</span></label>
                        <select name="isActiveSubmenuFeEdit" id="isActiveSubmenuFeEdit" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Non-aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="token" value="<?= base64_encode('editSubmenuFe'); ?>">
                    <input type="hidden" name="hiddenTitleMfdOld" id="hiddenTitleMfdOld">
                    <input type="hidden" name="hiddenMfdId" id="hiddenMfdId">
                    <button type="button" class="btn btn-secondary closeEditSubmenuFeModal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal-->
<div class="modal fade" id="deleteFrontendNavModal" tabindex="-1" role="dialog" aria-labelledby="deleteFrontendNavModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFrontendNavModalLabel">Are You sure to delete this?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Delete" below if you sure to delete.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="cDelFrontendNav">Delete</a>
            </div>
        </div>
    </div>
</div>