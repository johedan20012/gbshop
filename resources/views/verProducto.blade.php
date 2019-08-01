<!DOCTYPE HTML>
<html>
<head>
    <title>Productos gbshop</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"> <!--Bootstrap 4-->
</head>
<body>
    <h1>Nombre: {{$producto->nombre}}</h1>
    <h2>Descripcion: {{$producto->descripcion}}</h2>
    <h2>Precio: {{$producto->precio}}</h2>
    <h2>Stock: {{$producto->stock}}</h2>
    <h2>Categoria: {{$categoria->nombre}}</h2>
    @foreach($producto->fotos as $foto)
        <h2>Foto nombre: {{$foto->nombre}}</h2>
    @endforeach
    
</body>
</html>