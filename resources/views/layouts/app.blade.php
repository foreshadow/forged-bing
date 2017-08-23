<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name'))</title>

  <!-- Styles -->
  <link href="/css/app.css" rel="stylesheet">

  <!-- jQuery confirm -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.0.3/jquery-confirm.min.css">
  @stack('stylesheets')

  <!-- Scripts -->
  <script>window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?></script>
</head>

<body>
  @section('navbar')
  <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-infinity">
      <div class="navbar-header">

        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Branding Image -->
        <a class="navbar-brand" href="/">
          {{ config('app.name', 'Laravel') }}
        </a>
      </div>

      <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
          <li><a href="/">Home</a></li>
        </ul>
      </div>
    </div>
  </nav>
  @show
  @if (session('alert') !== null)
  <div class="alert alert-fluid alert-dismissible alert-{{ session('alert')['type'] }}">
    <div class="container">
      <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <span>
      @if (isset(session('alert')['icon']))
        <span class="glyphicon glyphicon-{{ session('alert')['icon'] }}"></span>&emsp;{{ session('alert')['message'] }}
      @else
      {{ session('alert')['message'] }}
      @endif
      </span>
    </div>
  </div>
  @endif

  <div class="container-infinity">
    @yield('content')
  </div>

  <!-- Scripts -->
  <!-- <script src="/js/app.js"></script> -->

  <!-- jQuery -->
  <script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
  <!-- jQuery Extension -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.0.3/jquery-confirm.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $('a[href*="//"]').each(function() {
          $(this).attr('target', '_blank');
      });
      $('[data-toggle="tooltip"]').tooltip({
          html: true
      });
      jconfirm.defaults = {
          theme: 'infinity'
      };
      $('[data-confirm]').click(function() {
          event.preventDefault();
          var form = $(this).parent();
          $.confirm({
              title: '删除',
              content: $(this).attr('data-confirm'),
              buttons: {
                  confirm: {
                      text: '删除',
                      btnClass: 'btn-danger',
                      action: function () {
                          form.submit();
                      }
                  },
                  cancel: {
                      text: '取消',
                      action: function () {
                          event.preventDefault();
                      }
                  }
              }
          });
      });
  });
  </script>
  @stack('scripts')
</body>

</html>
