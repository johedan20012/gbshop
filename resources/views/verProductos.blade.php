<!DOCTYPE HTML>
<html>
<head>
    <title>Productos gbshop</title>
</head>
<body>
    @foreach($productos as $producto)
    <h1>{{$producto->nombre}}</h1>
    <hr>
    @endforeach
</body>
</html>