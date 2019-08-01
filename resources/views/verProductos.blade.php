<!DOCTYPE HTML>
<html>
<head>
    <title>Productos gbshop</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"> <!--Bootstrap 4-->
</head>
<body>
    @foreach($productos as $producto)
    <h1>{{$producto->nombre}}</h1>
    <hr>
    @endforeach
</body>
</html>