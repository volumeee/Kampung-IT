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
    for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}

function convertToAngka(rupiah) {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}

function terbilang(bilangan) {
    bilangan = String(bilangan);
    var angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
    var kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
    var tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');

    var panjang_bilangan = bilangan.length;

    /* pengujian panjang bilangan */
    if (panjang_bilangan > 15) {
        kaLimat = "Diluar Batas";
        return kaLimat;
    }

    /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
    for (i = 1; i <= panjang_bilangan; i++) {
        angka[i] = bilangan.substr(-(i), 1);
    }

    i = 1;
    j = 0;
    kaLimat = "";


    /* mulai proses iterasi terhadap array angka */
    while (i <= panjang_bilangan) {

        subkaLimat = "";
        kata1 = "";
        kata2 = "";
        kata3 = "";

        /* untuk Ratusan */
        if (angka[i + 2] != "0") {
            if (angka[i + 2] == "1") {
                kata1 = "Seratus";
            } else {
                kata1 = kata[angka[i + 2]] + " Ratus";
            }
        }

        /* untuk Puluhan atau Belasan */
        if (angka[i + 1] != "0") {
            if (angka[i + 1] == "1") {
                if (angka[i] == "0") {
                    kata2 = "Sepuluh";
                } else if (angka[i] == "1") {
                    kata2 = "Sebelas";
                } else {
                    kata2 = kata[angka[i]] + " Belas";
                }
            } else {
                kata2 = kata[angka[i + 1]] + " Puluh";
            }
        }

        /* untuk Satuan */
        if (angka[i] != "0") {
            if (angka[i + 1] != "1") {
                kata3 = kata[angka[i]];
            }
        }

        /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
        if ((angka[i] != "0") || (angka[i + 1] != "0") || (angka[i + 2] != "0")) {
            subkaLimat = kata1 + " " + kata2 + " " + kata3 + " " + tingkat[j] + " ";
        }

        /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
        kaLimat = subkaLimat + kaLimat;
        i = i + 3;
        j = j + 1;

    }

    /* mengganti Satu Ribu jadi Seribu jika diperlukan */
    if ((angka[5] == "0") && (angka[6] == "0")) {
        kaLimat = kaLimat.replace("Satu Ribu", "Seribu");
    }

    return kaLimat + "Rupiah";
}

// data tables
$('.dtableResponsiveOnly').DataTable({
    scrollY: 300,
    paging: false,
    responsive: true,
    columnDefs: [{
        responsivePriority: 1,
        targets: 1
    }],
    language: {
        "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
        "info": "_TOTAL_ data",
        "infoEmpty": "0 data",
        "infoFiltered": "(disaring dari _MAX_)",
        "infoThousands": "'",
        "lengthMenu": "Tampilkan _MENU_ data",
        "loadingRecords": "Sedang memuat...",
        "processing": "Sedang memproses...",
        "search": "Cari:",
        "zeroRecords": "Tidak ditemukan data yang sesuai",
        "thousands": "'",
        "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Lanjut",
            "previous": "Mundur"
        }
    }
});

$('.dtableResponsiveNoSearch').DataTable({
    scrollY: 300,
    filter: false,
    paging: false,
    responsive: true,
    columnDefs: [{
        responsivePriority: 1,
        targets: 1
    }],
    language: {
        "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
        "info": "_TOTAL_ data",
        "infoEmpty": "0 data",
        "infoFiltered": "(disaring dari _MAX_)",
        "infoThousands": "'",
        "lengthMenu": "Tampilkan _MENU_ data",
        "loadingRecords": "Sedang memuat...",
        "processing": "Sedang memproses...",
        "search": "Cari:",
        "zeroRecords": "Tidak ditemukan data yang sesuai",
        "thousands": "'",
        "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Lanjut",
            "previous": "Mundur"
        }
    }
});

// setting dom: 'Bfrtip' untuk datatables with button export
var buttonCommon = {
    init: function (dt, node, config) {
        var table = dt.table().context[0].nTable;
        if (table) this.title = $(table).data('export-title')
    },
    title: ''
};
$.extend($.fn.dataTable.defaults, {
    "buttons": [
        $.extend(true, {}, buttonCommon, {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            }
        }),
        $.extend(true, {}, buttonCommon, {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            exportOptions: {
                columns: ':visible'
            }
        }),
        $.extend(true, {}, buttonCommon, {
            extend: 'print',
            exportOptions: {
                columns: ':visible'
            },
            orientation: 'landscape'
        })
    ]
});

// dtbale with export button
$('.dtableExportResponsive').DataTable({
    dom: 'Bfrtip',
    scrollY: 300,
    paging: false,
    responsive: true,
    columnDefs: [{
        responsivePriority: 1,
        targets: 1
    }],
    language: {
        "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
        "info": "_TOTAL_ data",
        "infoEmpty": "0 data",
        "infoFiltered": "(disaring dari _MAX_)",
        "infoThousands": "'",
        "lengthMenu": "Tampilkan _MENU_ data",
        "loadingRecords": "Sedang memuat...",
        "processing": "Sedang memproses...",
        "search": "Cari:",
        "zeroRecords": "Tidak ditemukan data yang sesuai",
        "thousands": "'",
        "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Lanjut",
            "previous": "Mundur"
        }
    }
});

// membuat keluaran ukuran dan satuan besaran
function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

// membuat slug url
function generateSlug(text) {
    return text.toString().toLowerCase()
        .replace(/^-+/, '')
        .replace(/-+$/, '')
        .replace(/\s+/g, '-')
        .replace(/\-\-+/g, '-')
        .replace(/[^\w\-]+/g, '');
}