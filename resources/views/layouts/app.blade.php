<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base_url" content="{{ $base_url }}">
  <title>CheevoHaus :)</title>
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="http://localhost:8888/cheevohausMothership/public/Skeleton-2.0.4/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="http://localhost:8888/cheevohausMothership/public/Skeleton-2.0.4/css/skeleton.css">
  <link rel="stylesheet" type="text/css" href="http://localhost:8888/cheevohausMothership/public/css/styles.css">
  <link rel="icon" type="image/png" href="http://localhost:8888/cheevohausMothership/public/favicon.ico">
  {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
</head>
<body>
  <nav>
    <div class="section">
      <div class='container'>
        <div class='row'>
          <div class="one column">
            <div id="menu-cell" class="btn" data-delegate="gamertag">Profile and Gamercard</div>
            <div id="menu-cell" class="btn" data-delegate="activity">Recent Activity</div>
          </div>
          <div class="one-half column"></div>
        </div>
        <div class='row'>
          <div class="one-half column">
            <div id="profile_container">
          </div>
          <div class="one-half column"></div>
        </div>
      </div>
    </div>
  </nav>

  @yield('content')

  <!-- JavaScripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="http://localhost:8888/cheevohausMothership/public/js/loadGamertag.js"></script>
  <script src="http://localhost:8888/cheevohausMothership/public/js/retrieveActivity.js"></script>
  <script src="http://localhost:8888/cheevohausMothership/public/js/index.js"></script>
  {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
