@props(['bodyClass'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/logos/edflix-favicon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/logos/logo.png">
    <title>TMS</title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.bootstrap4.min.css">
    <link href="https://cdn.datatables.net/colreorder/1.6.1/css/colReorder.bootstrap4.min.css">
    <link href="https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.dataTables.min.css">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <link href="{{ asset('assets') }}/css/jquery-ui.multidatespicker.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <style>
        .align-middle .btn {
            padding: 0.8rem !important;
            margin-left: 10px !important;
        }

        .dt-buttons {
            margin-left: 20px;
        }

        .dt-buttons .btn {
            margin-right: 10px;
            border-radius: 3px !important;
        }

        #table_filter {
            margin-right: 20px;
        }

        #table_info {
            margin-left: 20px;
        }

        .paginate_button {
            border: 0 !important;
            background: transparent !important;
        }

        .ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        @media only screen and (min-width: 720px) {
            .dataTables_length {
                float: right !important;
                margin-right: 40px;
                padding-top: 3px;
            }
        }
    </style>
</head>
