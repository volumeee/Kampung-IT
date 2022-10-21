<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $title; ?></title>

    <!-- load favico -->
    <link rel="icon" href="<?= base_url('assets/img/favicon/') . $identitas['favicon']; ?>" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-12/css/all.min.css" integrity="sha512-pn4RwKFKdSvaTRSYO5WIUGz89e1tJvWWUGRIBym1/k467SuMMjKKw/X5TXJYp2+WLmHumHivCJ2JAJppXF9SoA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/vendor/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">

    <!-- dataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css" />

    <style>
        tr {
            cursor: default;
        }
    </style>

</head>

<body id="page-top" data-baseurl="<?= base_url(); ?>">

    <!-- Page Wrapper -->
    <div id="wrapper">