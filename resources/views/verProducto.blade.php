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
    <h2>Categoria: {{$producto->categoria->nombre}}</h2>
    <h2>Marca: {{$producto->marca->nombre}}</h2>
    @if(isset($producto->foto))
        <h2>FOTO</h2>
            <img width="500px" height="500px" src="{{ asset('storage/imagenesProductos/'.$producto->foto->nombre) }}" alt="" title=""></a>
        <hr>
    @endif
    <h2>FOTOS</h2>
    @foreach($producto->fotos as $foto)
        <img width="500px" height="500px" src="{{ asset('storage/imagenesProductos/'.$foto->nombre) }}" alt="" title=""></a>
    @endforeach
    
</body>
</html>