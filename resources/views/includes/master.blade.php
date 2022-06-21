<html lang="en">
<head>
    <script src="bootstrap/jquory.js"></script>
    <script src="js/router.js"></script>
    <!--- font Awosome --->
    <script src="font/all.min.js"></script>
    
    <!--- bootstrap --->
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="font/all.css">

    <link rel="stylesheet" href="css/mainClasses.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page</title>
</head>
<body>
    {{View::make('includes/header')}}
    @yield('content')
    {{View::make('includes/footer')}}
</body>
</html>
