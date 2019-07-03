<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $page_title }} | Test App</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ url('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet"
        href="{{ url('bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{ url('bower_components/admin-lte/dist/css/skins/skin-app.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/build/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/sweetalert.css') }}">
    <link href="//www.fuelcdn.com/fuelux/3.13.0/css/fuelux.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/custom.css') }}">

    @yield('section_css')
    <script>
    var base_url = "{{url('')}}";
    var route_url = "{{url('')}}";
    </script>
</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Header -->
        @include('layouts.header')
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    {{ $page_title}}
                    <small>{{ $page_description}}</small>
                </h1>
                <!-- You can dynamically generate breadcrumbs here -->
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">{{$page_title}}</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        @include('layouts.footer')

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{url('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ url('js/toastr.js') }}"></script>
    <script src="{{ url('js/sweetalert.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ url('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ url('bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.js') }}">
    </script>
    <!-- SlimScroll -->
    <script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ url('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- CK Editor -->
    <script src="{{ url('bower_components/ckeditor/ckeditor.js') }}"></script>
    <!-- Validation -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="{{ url('js/bootstrap3-typeahead.min.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ url('js/custom.js') }}"></script>
    <script src="//www.fuelcdn.com/fuelux/3.13.0/js/fuelux.min.js"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_API_KEY')}}">
    </script> -->
    <script type="text/javascript">
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif

    function AjaxUploadImage(obj, id) {

        var file = obj.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            $('#DisplayImage').attr('src', "");
            $.notify("@lang('messages.Invalid file type.Please select image only')");
            return false;
        } else {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
        }
    }


    function imageIsLoaded(e) {
        $('#DisplayImage').css("display", "block");
        $('#DisplayImage').attr('src', e.target.result);
    };
    </script>
    @yield('section_js')

</body>

</html>