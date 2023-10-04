<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title','CRUD') - @setting('app_name')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/screenLoader.css') }}">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/icheck/skin/all.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/crud-style.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatable/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{asset('plugins/datepicker/css/bootstrap-datepicker.standalone.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.css" integrity="sha512-QmxybGIvkSI8+CGxkt5JAcGOKIzHDqBMs/hdemwisj4EeGLMXxCm9h8YgoCwIvndnuN1NdZxT4pdsesLXSaKaA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- DevExtreme theme -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.3/css/dx.light.css">
    <script src="{{asset('plugins/sweetalert/js/sweetalert.min.js')}}"></script>
    @yield('css')

    <!-- FAVICON -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{asset('favicon/site.webmanifest')}}">
  <link rel="mask-icon" href="{{asset('favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <!-- FAVICON -->
  @yield('style')
  <style>
    :root{
      --theme: {{setting("app_navbar")}}
    }
    .navbar {
      background-color: var(--theme);
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: #007bff;
      }
  </style>
<!-- Matomo Tag Manager -->
<script type="text/javascript">
var _mtm = window._mtm = window._mtm || [];
_mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
_mtm.push({'uid':'{{Auth::user()?Auth::user()->username:""}}' });
var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
g.type='text/javascript'; g.async=true; g.src='https://webanalytics-khdn.vinaphone.vn/js/container_ORu3WpZO.js'; s.parentNode.insertBefore(g,s);
</script>
<!-- End Matomo Tag Manager -->

</head>
<body class="hold-transition sidebar-mini dx-viewport">
  @include('sweet::alert')
  <!-- Preloader -->
  <div class="payment-loader">
    <div class="loader-pendulums"></div>
  </div>
  <!-- /Preloader -->
<div class="wrapper">
@if(!Auth::guest())
  @include('layouts.sidebar')

  <div class="content-wrapper">
    @yield('content')
  </div>

  <footer class="main-footer text-center">
    <strong>Copyright &copy; {{date('Y')}} <a href="{{env('APP_URL')}}">{{setting('app_name')}}</a>.</strong> All rights
    reserved.
  </footer>
</div>
@else
<meta http-equiv="refresh" content="0; URL='/login'"/>
@endif
<!-- ./wrapper -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/theme.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{asset('plugins/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js" integrity="sha512-1zzZ0ynR2KXnFskJ1C2s+7TIEewmkB2y+5o/+ahF7mwNj9n3PnzARpqalvtjSbUETwx6yuxP5AJXZCpnjEJkQw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- DevExtreme library -->
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.all.js"></script>
<!-- <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.web.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.viz.js"></script> -->
<script>
(function(){
  var cache = {};
   
  this.tmpl = function tmpl(str, data){
    // Figure out if we're getting a template, or if we need to
    // load the template - and be sure to cache the result.
    var fn = !/\W/.test(str) ?
      cache[str] = cache[str] ||
        tmpl(document.getElementById(str).innerHTML) :
       
      // Generate a reusable function that will serve as a template
      // generator (and which will be cached).
      new Function("obj",
        "var p=[],print=function(){p.push.apply(p,arguments);};" +
         
        // Introduce the data as local variables using with(){}
        "with(obj){p.push('" +
         
        // Convert the template into pure JavaScript
        str
          .replace(/[\r\t\n]/g, " ")
          .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'")
      + "');}return p.join('');");
     
    // Provide some basic currying to the user
    return data ? fn( data ) : fn;
  };
})();
</script>

@yield('script')
@stack('scripts')
</body>
</html>
