<!DOCTYPE html>
<html>
  <head>
    @routes
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
  </head>
  <body class="control-sidebar-slide-open layout-navbar-fixed sidebar-collapse sidebar-mini layout-fixed"
  style="height: auto;">
    @inertia
  </body>
</html>
