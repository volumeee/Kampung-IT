// ambil dari accordionSidebar
const windowOrigin = $('body').data('baseurl');

// ubah tombol logout jadi loading
$('#logOut').on('click', function () {
    $('#logOut').addClass('disabled').html(`<div class="spinner-border spinner-border-sm text-light" role="status"><span class="sr-only">Loading...</span></div>`);
});

// ganti input ke teks ketika show passowrd di  klik
$('#showPass').on('click', function (event) {
    event.preventDefault();
    if ($('#password').attr("type") == "text") {
        $('#password').attr('type', 'password');
        $('#toggle').removeClass('fa-eye text-primary');
        $('#toggle').addClass('fa-eye');
    } else if ($('#password').attr("type") == "password") {
        $('#password').attr('type', 'text');
        $('#toggle').removeClass('fa-eye');
        $('#toggle').addClass('fa-eye text-primary');
    }
});

// modify iput name file upload
$('.custom-file-input').on('change', function () {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass('selected').html(fileName);
});

// show hdie pass on /user
$('#showPass').on('click', function (event) {
    event.preventDefault();
    if ($('#current_password').attr("type") == "text") {
        $('#current_password').attr('type', 'password');
        $('#toggle').removeClass('fa-eye text-primary');
        $('#toggle').addClass('fa-eye');
    } else if ($('#current_password').attr("type") == "password") {
        $('#current_password').attr('type', 'text');
        $('#toggle').removeClass('fa-eye');
        $('#toggle').addClass('fa-eye text-primary');
    }
})

// show hdie pass on /user
$('#showPass1').on('click', function (event) {
    event.preventDefault();
    if ($('#new_password1').attr("type") == "text") {
        $('#new_password1').attr('type', 'password');
        $('#toggle1').removeClass('fa-eye text-primary');
        $('#toggle1').addClass('fa-eye');
    } else if ($('#new_password1').attr("type") == "password") {
        $('#new_password1').attr('type', 'text');
        $('#toggle1').removeClass('fa-eye');
        $('#toggle1').addClass('fa-eye text-primary');
    }
})

// show hdie pass on /user
$('#showPass2').on('click', function (event) {
    event.preventDefault();
    if ($('#new_password2').attr("type") == "text") {
        $('#new_password2').attr('type', 'password');
        $('#toggle2').removeClass('fa-eye text-primary');
        $('#toggle2').addClass('fa-eye');
    } else if ($('#new_password2').attr("type") == "password") {
        $('#new_password2').attr('type', 'text');
        $('#toggle2').removeClass('fa-eye');
        $('#toggle2').addClass('fa-eye text-primary');
    }
});

// admin/role changeacces user
$('.toChangeRoleAccess').on('click', function () {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
        url: `${windowOrigin}admin/changeaccess`,
        type: "post",
        data: {
            menuId: menuId,
            roleId: roleId
        },
        success: function () {
            document.location.href = `${windowOrigin}admin/roleaccess/${roleId}`;
        }
    });
});

// admin editRole
$(document).on('click', '#editRole', function () {
    $('#inputEditRole').val($(this).data('role'));
    $('#inputIdRole').val($(this).data('idrole'));
});

// admin deleteRole
$(document).on('click', '#delRole', function () {
    $('#cDelRole').attr('href', $(this).data('href'));
});

// admin editUser
$(document).on('click', '#editUser', function () {
    $('#inputEditRoleUser option:contains("' + $(this).data('idrole') + '")').text($(this).data('idrole') + ' (terakhir dipilih)').attr('selected', true);
    $('#hiddenInputEmail, #inputEditEmail').val($(this).data('email'));
    $('#hiddenInputUsername, #inputEditUsername').val($(this).data('ussname'));
    $('#inputEditFullname').val($(this).data('fullname'));
});

// admin onclose modal edit user
$('.closeEditUserModal').click(function () {
    let selectedRole = $('#inputEditRoleUser option:contains(" (terakhir dipilih)")');
    let textRoleSelected = $('#inputEditRoleUser option:contains(" (terakhir dipilih)")').text().split(' (terakhir dipilih)')[0];
    selectedRole.text(textRoleSelected).attr('selected', false);
    $('#inputEditPassword').val('');
});

// admin deleteUser
$(document).on('click', '#delUser', function () {
    $('#cDelUser').attr('href', $(this).data('href'));
});

// admin editUser nyalakan edit password
$('#enablePass').change(function () {
    $('#inputEditPassword').prop('disabled', false);
    $(this).prop('checked', true).parent().slideUp('slow');
});

// ketika modal edit user diclose
$('#editUserModal').on('hidden.bs.modal', function () {
    $('#inputEditPassword').prop('disabled', true);
    $('#enablePass').prop('checked', false).parent().show();
});

// preview logo in identitas
$('#logoInstansi').change(function (e) {
    let allowedTypes = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
    let allowedSize = ['8388608']; //8 MB limit

    let file = e.target.files[0];
    let fileType = file.type;
    let fileSize = file.size;

    // jika format file diluar kriteria
    if (!allowedTypes.includes(fileType)) {
        $('#logoInstansi').next('.custom-file-label').removeClass('selected').html('Pilih file');
        document.getElementById('previewLogoInstansi').src = `${windowOrigin}assets/img/default-banner-infaq-online-4x4.jpg`;
        $('#isiErrorNotifModal').html(`Maaf ya, silakan pilih file yang valid (<strong>${allowedTypes.join(', ')}</strong>). File Anda : ${fileType}`);
        $('#errorNotifModal').modal('show');
        return false;
    }
    // jika file lebih besar dari ketentuan size
    else if (fileSize > allowedSize) {
        $('#logoInstansi').next('.custom-file-label').removeClass('selected').html('Pilih file');
        document.getElementById('previewLogoInstansi').src = `${windowOrigin}assets/img/default-banner-infaq-online-4x4.jpg`;
        $('#isiErrorNotifModal').html(`Ukuran file terlalu besar, maksimal ukuran yg disarankan <stong>${formatBytes(alloweSize)}</strong>`);
        $('#errorNotifModal').modal('show');
        return false;
    }
    // tampilkan preview gambar jika syarat terpenuhi 
    else {
        let reader = new FileReader();
        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById('previewLogoInstansi').src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    }
});

// menu/editMenu
$(document).on('click', '#editMenu', function () {
    $('#editMenu_id').val($(this).data('menuid'));
    $('#judul').val($(this).data('menu'));
});

// admin deleteMenu
$(document).on('click', '#delMenu', function () {
    $('#cDelMenu').attr('href', $(this).data('href'));
});

// admin deleteSubmenu
$(document).on('click', '#delSubmenu', function () {
    $('#cDelSubmenu').attr('href', $(this).data('href'));
});

// admin/artikelaction make a slug url
$('#judulArtikel').keyup(function () {
    let title = $(this).val();
    $('#linkUrlSlug').val(generateSlug(title).substring(0, 150)).change();
});

// admin/artikelaction cek ketersediaan link url
$(document).on('keyup, change', '#linkUrlSlug', function () {
    const linkSlug = $(this).val();
    if (linkSlug != '')
        $.ajax({
            url: `${windowOrigin}admin/isLinkAvailable`,
            type: "post",
            data: {
                linkSlug: linkSlug
            },
            success: function (resp) {
                if (resp == 'ok') $('#linkUrlSlug').removeClass('is-invalid').addClass('is-valid').attr('title', 'Link aman, belum terpakai');
                else $('#linkUrlSlug').removeClass('is-valid').addClass('is-invalid').attr('title', 'Error, link sudah terpakai');
            }
        });
    else $('#linkUrlSlug').removeClass('is-valid').addClass('is-invalid').attr('title', 'Inputan tidak boleh kosong');
});

// tampilkan gambar banner artikel sehabis pilih file
$('#bannerArtikel').change(function (e) {
    let allowedTypes = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
    let allowedSize = ['8388608']; //8 MB limit

    let file = e.target.files[0];
    let fileType = file.type;
    let fileSize = file.size;

    // jika format file diluar kriteria
    if (!allowedTypes.includes(fileType)) {
        $('#bannerArtikel').next('.custom-file-label').removeClass('selected').html('Pilih file');
        document.getElementById('previewBannerArtikel').src = `${windowOrigin}assets/img/default-banner-infaq-online-4x4.jpg`;
        $('#isiErrorNotifModal').html(`Maaf ya, silakan pilih file yang valid (<strong>${allowedTypes.join(', ')}</strong>). File Anda : ${fileType}`);
        $('#errorNotifModal').modal('show');
        return false;
    }
    // jika file lebih besar dari ketentuan size
    else if (fileSize > allowedSize) {
        $('#bannerArtikel').next('.custom-file-label').removeClass('selected').html('Pilih file');
        document.getElementById('previewBannerArtikel').src = `${windowOrigin}assets/img/default-banner-infaq-online-4x4.jpg`;
        $('#isiErrorNotifModal').html(`Ukuran file terlalu besar, maksimal ukuran yg disarankan <stong>${formatBytes(alloweSize)}</strong>`);
        $('#errorNotifModal').modal('show');
        return false;
    }
    // tampilkan preview gambar jika syarat terpenuhi 
    else {
        let reader = new FileReader();
        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById('previewBannerArtikel').src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    }
});

// admin/artikel delartikel
$(document).on('click', '#delArtikel', function () {
    $('#cDelArtikel').attr('href', $(this).data('href'));
});

// admin/program editProgram
$(document).on('click', '#editProgram', function () {
    $('#inputIdProgram').val($(this).data('idprogram'));
    $('#inputEditProgram').val($(this).data('program'));
});

// admin/program deleteProgram
$(document).on('click', '#delProgram', function () {
    $('#cDelProgram').attr('href', $(this).data('href'));
});

// member/historyRate editReview
$(document).on('click', '#editReview', function () {
    $('#editReviewModalLabel').html($(this).data('judul'))
    $('#inputIdReview').val($(this).data('reviewid'));
    $('#inputEditReview').html($(this).data('review'));
});

// admin/inbox showInbox
$(document).on('click', '#showInbox', function () {
    $('#showInboxModalLabel').html($(this).data('inboxid'))
    $('#namaInbox').html($(this).data('nama'));
    $('#emailInbox').html($(this).data('email'));
    $('#waktuInbox').html($(this).data('datetime'));
    $('#pesanInbox').html($(this).data('pesan'));
});