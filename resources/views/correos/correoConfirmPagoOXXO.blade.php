<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
	</head>
	<body style="margin:0; padding:0;">
		<div style="background-color: #F5F5F2; font-family:Arial,Helvetica;" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
            <table style="border: 1px solid #3c3b3b; background-color:#fff;color:#373737;font-size:12px; font-weight: bolder;font-family:Arial,Helvetica;" width="90%" cellspacing="0" cellpadding="0" align="center" data-bgcolor="light-gray-bg">
                <tbody>
                    <tr>
                        <td style="padding:0px 20px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                        <div style="margin-top:10px; margin-bottom:10px;"><img src="{{asset('storage/imagenesLayout/logo2.png') }}" alt="" width="200px" /></div>
                                    </td>
                                    <td>
                                        <table style="width:100%; font-size:12px; font-family:Arial;" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td style="color: #565656;; text-align:right">Numero de pedido:</td>
                                                <td style="text-align:left">&nbsp;&nbsp;{{$pedido->clave}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;; text-align:right">Fecha: </td>
                                                <td style="text-align:left">&nbsp;&nbsp;{{$pedido->created_at}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;; text-align:right">Status del pedido: </td>
                                                <td style="text-align:left">&nbsp;
                                                    @if($pedido->estatus == 1)
                                                        En espera de pago
                                                    @elseif($pedido->estatus == 2)
                                                        Pagado
                                                    @elseif($pedido->estatus == 3)
                                                        En proceso de envio
                                                    @elseif($pedido->estatus == 4)
                                                        Enviado
                                                    @else
                                                        Cancelado
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#bf2546; font-family:Arial; text-align:center; color:#FFFFFF; padding-top:10px; padding-bottom:10px;">
                                <tr>
                                    <td>
                                        <p style="text-align:center"><strong>Estimado(a): {{$pedido->usuario->nombreCompleto}}</strong></p>
                                        <div style="text-align:center: font-size:12px">Por medio del presente correo,le informamos que recibimos su pago por OXXO del siguiente pedido.</div>
                                                                                        </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 20px">
                            <table width="100%" style=" font-size:12px; font-family:Arial;" cellspacing="0" cellpadding="0" border="0" >
                                <tr>
                                    <td width="50%" valign="top" style="padding-bottom:10px;">
                                        <table style="color:#FFFFFF; background:#bf2546; width:100%; font-family:Arial;  font-size:12px;">
                                            <tr>
                                                <td style="padding:5px 10px; "><div><strong>DATOS DE ENTREGA</strong></div></td>
                                            </tr>
                                        </table><br>
                                        <table width="100%" style=" font-size:12px; font-family:Arial;" cellspacing="1" cellpadding="1" border="0" >
                                            <tr>
                                                <td style="color: #565656;">Nombre:</td>
                                                <td>{{$pedido->nombreCompleto.' '.$pedido->aPaterno.' '.$pedido->aMaterno}} </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Teléfono:</td>
                                                <td >{{$pedido->telefono}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Estado:</td>
                                                <td >{{$pedido->estado}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Deleg/Mun:</td>
                                                <td >{{$pedido->municipio}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Colonia:</td>
                                                <td >{{$pedido->colonia}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">CP:</td>
                                                <td >{{$pedido->cp}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="50%" valign="top" style="padding-bottom:10px;">
                                        <table style="color:#FFFFFF; background:#bf2546; width:100%; font-family:Arial;  font-size:12px;">
                                            <tr>
                                                <td style="padding:5px 10px; "><div><strong>|</strong></div></td>
                                            </tr>
                                        </table><br>
                                        <table width="100%" style=" font-size:12px; font-family:Arial;" cellspacing="1" cellpadding="1" border="0" >
                                            <tr>
                                                <td style="color: #565656;">Calle:</td>
                                                <td >{{$pedido->calle}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Entre Calle:</td>
                                                <td >{{$pedido->entreCalle}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Número ext:</td>
                                                <td >{{$pedido->nExt}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Número int:</td>
                                                <td >{{$pedido->nInt}}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Referencias del domicilio:</td>
                                                <td>{{$pedido->referencia_domicilio}} </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="width:100%">
                        <td style="padding: 0px 20px;"> 
                            <div style="margin-top:10px;">
                                <table cellspacing="0" style="border-collapse: collapse; width:100%; font-family:Arial,Helvetica; font-size:12px; ">
                                    <tr>
                                        <th style="border:1px solid #3c3b3b;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Producto</th>
                                        <th style="border:1px solid #3c3b3b;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Cantidad</th>
                                        <th style="border:1px solid #3c3b3b;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Precio</th>
                                        <th style="border:1px solid #3c3b3b;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Subtotal</th>
                                    </tr>
                                    @foreach($pedido->detalles as $detalle)

                                        <tr style="font-size:11px;">
                                            <td style="border:1px solid #3c3b3b;padding:5px;margin:5px;">
                                                <img src="{{ asset('storage/imagenesProductos/'.$detalle->producto->foto->nombre) }}" alt="" align="left" width="50" style="margin-right:5px;">
                                                {{$detalle->producto->nombre}}<br>
                                                <div>
                                                Marca: {{$detalle->producto->marca->nombre}}
                                                </div>
                                            </td>
                                            <td style="border:1px solid #3c3b3b;padding:10px;margin:10px;">{{$detalle->cantidad}}</td>
                                            <td style="border:1px solid #3c3b3b;padding:10px;margin:10px;">${{$detalle->precio}}</td>
                                            <td style="border:1px solid #3c3b3b;padding:10px;margin:10px;">${{$detalle->precio*$detalle->cantidad}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr style="width:100%;">
                        <td style="padding:15px 20px 30px 20px;">
                            <table style="width:100%; font-family:Arial,Helvetica; font-size:12px;" >
                                <tbody>
                                <tr>
                                    <td style="width: 50%;"></td>
                                    <td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">Subtotal</td>
                                    <td style="text-align:right; color:#bf2546; ">${{$pedido->subtotal}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;"></td>
                                    <td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">
                                        <div>Gastos de Envío</div>
                                    </td>
                                    @if($pedido->costo_envio == 0)
                                        <td style="text-align:right; color:#359902; ">Envío Gratis</td>
                                    @else
                                        <td style="text-align:right; color:#359902; ">{{$pedido->costo_envio}}</td>
                                    @endif
                                </tr>
                                @if($pedido->costo_meses > 0)
                                    <tr>
                                        <td style="width: 50%;"></td>
                                        <td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">Costo meses sin intereses</td>
                                        <td style="text-align:right; color:#bf2546; ">${{$pedido->costo_meses}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="width: 50%;"></td>
                                    <td style="text-align:right;font-size:14px;font-weight:bold;padding-right:10px; font-family:Arial,Helvetica;">TOTAL</td>
                                    <td style="text-align:right; color:#bf2546; font-size:20px ">${{$pedido->total}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
						<td style="padding: 0px 20px">
							<table cellspacing="1" cellpadding="0" border="0" style="width:100%;">
								<tr>
									<td style="font-family:Arial; font-size:12px;">
                                        <div class="row" style="padding-bottom: 1%">
                                            <div class="col-md-6">
                                                <div style="padding-left: 10%;">
                                                    <strong>MÉTODO DE PAGO: </strong> {{$pedido->tipoPago}}     
                                                    @if($pedido->tipoPago == "ConektaOXXO")
                                                        <img src="{{ asset('storage/imagenesLayout/oxxopay.png')}}" alt="OXXOPay" width=160>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="float:right; padding-right: 10%;">
                                                    <strong >Status del pago:</strong>
                                                    @if($pedido->estatus == 2 || $pedido->estatus == 3 || $pedido->estatus == 4)
                                                        <button class="btn btn-success" disabled style="opacity:1;">Pagado</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:0px 20px 20px 20px;">
							<table width="100%" CELLSPACING="0" CELLPADDING="0" border="0" >
								<tr>
									<td style=" padding: 15px 10px; color:#aaaaaa; font-family:Arial; border-top:3px solid #bf2546; background:#2A2A2A; font-size:12px; font-style: italic; width:100%; height:100%;">
										Para cualquier duda o aclaración escribenos a <a href="mailto:ventas@gbroute.com.mx" style="color:#bf2546">ventas@gbroute.com.mx</a><br> indicándonos tu número de pedido.<br><br>
										<table  style="width:100%; font-family:Arial,Helvetica; font-size:12px; font-style: italic;">
											<tr>
												<td style="color:#bf2546; font-size:23px; font-style:normal;">
													(777)629-0048
												</td>
												<td style=" font-style:normal;">
													Muchas gracias por tu confianza,<br>
													Atentamente<br>
													GB Route<br>
													<a href="https://gbroute.com.mx/" style="color:#FFFFFF">https://gbroute.com.mx/</a><br>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<table width="100%" CELLSPACING="0" CELLPADDING="0">
								<tr>
									<td style=" padding: 15px 10px; background:#1C1C1C;color:#aaaaaa; font-family:Arial; font-size:12px; border-top:2px solid #000000; text-align:center; width:100%; height:100%; ">
										Copyright © 2019 <a href="https://gbroute.com.mx/" style="color:#bf2546">https://gbroute.com.mx/</a> Todos los derechos reservados
									</td>
								</tr>
							</table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>