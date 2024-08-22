<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Adishakti |  @yield('title')</title>



         <!-- Google Font: Source Sans Pro -->
         <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
         <!-- Font Awesome -->
         <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css'); }}" />
         <!-- Ionicons -->
         <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
         <!-- Tempusdominus Bootstrap 4 -->
         <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); }}" />
         <!-- iCheck -->
         <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css'); }}" />
         <!-- JQVMap -->
         <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css'); }}" />
         <!-- Theme style -->
         <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css'); }}" />
         <!-- overlayScrollbars -->
         <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); }}" />
         <!-- Daterange picker -->
         <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css'); }}" />
         <!-- summernote -->
         <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css'); }}" />
         <!-- Select2 -->
         <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css'); }}" />
         <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); }}" />
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
         <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery -->

        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

        <style>

            div#customer_list_filter{

                float: right;

            }



            .tableimg{

                width: 7%;

            }

        </style>

    </head>

    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper">

            <!-- Navbar -->

            <nav class="main-header navbar navbar-expand navbar-white navbar-light">

                <!-- Left navbar links -->

                <ul class="navbar-nav">

                    <li class="nav-item">

                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

                    </li>

                </ul>

            </nav>



            @extends('admin.layout.sidebar')

            <!-- /.navbar -->

      

                @yield('content')

            <!-- /.content-wrapper -->

            <footer class="main-footer">

                <strong>Copyright &copy; 2024 <a href="">Adishakti</a>.</strong>

                All rights reserved.

            </footer>



            <!-- Control Sidebar -->

            <aside class="control-sidebar control-sidebar-dark">

                <!-- Control sidebar content goes here -->

            </aside>

            <!-- /.control-sidebar -->

        </div>

        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
        <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <!-- DataTables -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <!-- DataTables Buttons JS -->

        <!--sweet alert-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

        <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- daterange picker -->
        {{--  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>  --}}
        <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <!-- AdminLTE App -->
        {{--  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>  --}}
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.js') }}"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

        

        <script>

            $(function () {

                // Initialize Select2 Elements

                $(".select2").select2();



                // Initialize Select2 Elements with Bootstrap 4 theme

                $(".select2bs4").select2({

                    theme: "bootstrap4",

                });



                // DataTable initialization

                $("#customer_list").DataTable({

                    paging: true,

                    lengthChange: false,

                    searching: true,

                    ordering: false,

                    info: false,

                    autoWidth: false,

                    responsive: true,

                });



                // Delete and Status click handlers

                $(".delete, .status").click(function () {

                    Swal.fire({

                        title: 'Are you sure?',

                        text: "You won't be able to revert this!",

                        icon: 'warning',

                        showCancelButton: true,

                        confirmButtonColor: '#3085d6',

                        cancelButtonColor: '#d33',

                        confirmButtonText: 'Yes'

                        }).then((result) => {

                        if (result.isConfirmed) {



                            var id = $(this).data("id");

                            var token = $("meta[name='csrf-token']").attr("content");

                            var url = $(this).data("url");

                            var type = $(this).hasClass("delete") ? "DELETE" : "GET";

                            var data = {

                                id: id,

                                _token: token,

                            };

                            if (type === "GET") {

                                data.status = $(this).data("status");

                            }



                            $.ajax({

                                url: url,

                                type: type,

                                data: data,

                                success: function () {

                                    location.reload();

                                },

                            });

                            Swal.fire(

                            'success'

                            )

                        }

                    })

                });

            });

            

        </script>

    </body>

</html>

