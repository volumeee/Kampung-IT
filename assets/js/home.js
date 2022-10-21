const windowOrigin = $('body').data('baseurl');

function convertToRupiah(objek) {
    separator = ".";
    a = objek.value;
    b = a.replace(/[^\d]/g, "");
    c = "";
    panjang = b.length;
    j = 0;
    for (i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
            c = b.substr(i - 1, 1) + separator + c;
        } else {
            c = b.substr(i - 1, 1) + c;
        }
    }
    objek.value = c;
}

function convertToRupiahInt(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}

function convertToAngka(rupiah) {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}

// function checkRadio(event) {
//     const nominal = document.getElementById('nominal');
//     const listNominal = event.path[0];
//     if (nominal.value === listNominal.value) {
//         event.path[0].checked = false;
//         nominal.value = "";
//     } else {
//         nominal.value = listNominal.value
//     }
// }

// function checkNominal(event) {
//     const nominal = event.path[0];
//     const radio = [...document.querySelectorAll("[name='list-nominal']")];
//     if (parseInt(nominal.value) < 0 && nominal.value !== "") {
//         nominal.value = "10000";
//     }
//     radio.map((e) => {
//         if (e.value === nominal.value) {
//             e.checked = true;
//         } else {
//             e.checked = false;
//         }
//     })
// }

$(document).on('click', '#selectThisProgram', function () {
    // console.log($(this).data('program'));
    $('#nominal').attr('data-program', $(this).data('program'));
    $('#closeListProgramModal').click();
});

$('#pay-button').click(function () {
    if ($('#nominal').val() == '') {
        $(this).before(`<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;Maaf, mohon isi <strong>Nominal</strong> terlebih dahulu.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
    } else {
        let program = $('#nominal').data('program');
        let user_nama = $('#nominal').data('nama');
        let user_email = $('#nominal').data('email');
        let user_telp = $('#nominal').data('telp');
        let nominal = Number(convertToAngka($('#nominal').val()));
        $.ajax({
            url: `${windowOrigin}snap/token/${nominal}`,
            cache: false,
            success: function (data) {
                // console.log(data);
                snap.pay(data, {
                    onSuccess: function (result) {
                        // console.log('success');
                        // console.log(result);
                        $.ajax({
                            url: `${windowOrigin}post/addtransaksiMasuk`,
                            type: 'post',
                            data: {
                                payment_type: result.payment_type,
                                order_id: result.order_id,
                                tgl: result.transaction_time,
                                user_nama: (user_nama == '') ? 'Anonymous' : user_nama,
                                user_email: user_email,
                                user_telp: user_telp,
                                nominal: convertToRupiahInt(result.gross_amount.split('.')[0]),
                                status: result.transaction_status,
                                program: program,
                                pdf_url: (result.pdf_url) ? result.pdf_url : ''
                            },
                            success: function (resp) {
                                // console.log(resp);
                                if (resp.response.code == 201) $('#pay-button').before(`<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;Terima kasih telah mempercayakan donasi Anda kepada kami, semoga barokah.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
                            }
                        });
                    },
                    onPending: function (result) {
                        // console.log('pending');
                        // console.log(result);
                        $.ajax({
                            url: `${windowOrigin}post/addtransaksiMasuk`,
                            type: 'post',
                            data: {
                                payment_type: result.payment_type,
                                order_id: result.order_id,
                                tgl: result.transaction_time,
                                user_nama: (user_nama == '') ? 'Anonymous' : user_nama,
                                user_email: user_email,
                                user_telp: user_telp,
                                nominal: convertToRupiahInt(result.gross_amount.split('.')[0]),
                                status: result.transaction_status,
                                program: program,
                                pdf_url: (result.pdf_url) ? result.pdf_url : ''
                            },
                            success: function (resp) {
                                // console.log(resp);
                                if (resp.response.code == 201) $('#pay-button').before(`<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;Terima kasih, mohon untuk menyelesaikan proses sesuai dengan metode pembayaran yang dipilih.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
                            }
                        });
                    },
                    onError: function (result) {
                        // console.log('error');
                        // console.log(result);
                        $('#pay-button').before(`<div class="alert alert-warning alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i>&nbsp;Maaf terjadi kesalahan, mohon untuk mencoba lagi nanti.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
                    }
                });
            }
        });
    }
});

// ketika pilihan nominal di klik tulis di kolom nominal
$(document).on('click', "input[name='list-nominal']", function () {
    if (convertToAngka($('#nominal').val()) === $(this).val()) {
        $(this).attr('checked', false);
        $('#nominal').val('');
    } else {
        $('#nominal').val(convertToRupiahInt($(this).val()));
    }
});

// ketika nominal dikeitk nominal dan sama dengan list nominal maka trigger checked
$('#nominal').keyup(function () {
    if (parseInt($(this).val()) <= 0 && $(this).val() != '') {
        $(this).val('');
    }
    $.each($('input[name="list-nominal"]'), function () {
        if ($(this).val() == convertToAngka($('#nominal').val())) {
            $(this).prop('checked', true);
        } else {
            $(this).prop('checked', false);
        }
    });
});