<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('global.site_title') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/header.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/materialicons.css')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/coreui_font.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/font_icon.css')}}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- To keep buttons in row -->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <!-- To keep buttons in row -->
    @yield('styles')

</head>

<body class="app header-fisxed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full"><img src="{{url('/images/kingranch_logo.png')}}" height="50" width="160"
                    style="margin-bottom:3%">
                <span class="navbar-brand-minimized">K</span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav ml-auto">
            @if(count(config('panel.available_languages', [])) > 1)
            <li class="nav-item dropdown d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach(config('panel.available_languages') as $langLocale => $langName)
                    <a class="dropdown-item"
                        href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }}
                        ({{ $langName }})</a>
                    @endforeach
                </div>
            </li>
            @endif
        </ul>
        <div style="margin-right:5%">
            <div class="account-item clearfix js-item-menu show-dropdown">

                <div class="content content2">
                    <a href="#"><i
                            class="nav-icon fas fa-user-circle"></i>&nbsp;<?php echo session()->get('uname'); ?></a>
                </div>
                <div class="account-dropdown js-dropdown">
                    <div class="info clearfix">

                        <h5 class="name">
                            <p style="font-size: large;"><?php echo session()->get('uname'); ?></p>
                        </h5>
                        <p><?php echo session()->get('useremail'); ?></p>

                    </div>
                    <div class="account-dropdown__footer">
                        <a href="/logoutfromdashboard" style="text-align: center">
                            <i class="zmdi zmdi-power"></i>Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="app-body">

        @include('partials.menu')
        <main class="main">
            <div style="padding-top: 20px" class="container-fluid">
                @yield('content')
            </div>
        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>

    <!-- Dattablescripts -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="{{ url('/css/datatableimpJS.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <!-- Datatablesscrip -->


    <script>
    $(function() {
        let copyButtonTrans = '{{ trans('
        global.datatables.copy ') }}'
        let csvButtonTrans = '{{ trans('
        global.datatables.csv ') }}'
        let excelButtonTrans = '{{ trans('
        global.datatables.excel ') }}'
        let pdfButtonTrans = '{{ trans('
        global.datatables.pdf ') }}'
        let printButtonTrans = '{{ trans('
        global.datatables.print ') }}'
        let colvisButtonTrans = '{{ trans('
        global.datatables.colvis ') }}'

        let languages = {
            'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
            className: 'btn'
        })
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: languages. {
                    {
                        app() - > getLocale()
                    }
                }
            },
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                orderable: false,
                searchable: false,
                targets: -1
            }],
            select: {
                style: 'multi+shift',
                selector: 'td:first-child'
            },
            order: [],
            scrollX: true,
            pageLength: 100,
            dom: 'lBfrtip<"actions">',
            buttons: [{
                    extend: 'copy',
                    className: 'btn-default',
                    text: copyButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-default',
                    text: csvButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-default',
                    text: excelButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-default',
                    text: pdfButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-default',
                    text: printButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn-default',
                    text: colvisButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
        $.fn.dataTable.ext.classes.sPageButton = '';
    });
    </script>

    <script>
    $(function() {
        $("#demodate").datepicker();
        dateFormat: "mm-dd-yy"
    });
    </script>
    <script type="text/javascript" src="{{ url('/js/calenderdate.js') }}"></script>
    @yield('scripts')

</body>

</html>