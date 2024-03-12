<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
     <!-- Core CSS -->
     <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}">
    <!-- //icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <div id="app-vue"></div>


  <!-- build:js assets/vendor/js/core.js -->
  
  <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ url('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/hammer/hammer.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/i18n/i18n.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
  <script src="{{ url('assets/vendor/js/menu.js') }}"></script>



    @vite('resources/js/app.js')





</body>
</html>