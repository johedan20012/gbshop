<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
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
                                        <div style="margin-top:10px; margin-bottom:10px;"><img src="<?php echo e(asset('storage/imagenesLayout/logo2.png')); ?>" alt="" width="200px" /></div>
                                    </td>
                                    <td>
                                        <table style="width:100%; font-size:12px; font-family:Arial;" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td style="color: #565656;; text-align:right">Numero de pedido:</td>
                                                <td style="text-align:left">&nbsp;&nbsp;<?php echo e($pedido->clave); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;; text-align:right">Fecha: </td>
                                                <td style="text-align:left">&nbsp;&nbsp;<?php echo e($pedido->created_at); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;; text-align:right">Status del pedido: </td>
                                                <td style="text-align:left">&nbsp;
                                                    <?php if($pedido->estatus == 1): ?>
                                                        En espera de pago
                                                    <?php elseif($pedido->estatus == 2): ?>
                                                        Pagado
                                                    <?php elseif($pedido->estatus == 3): ?>
                                                        En proceso de envio
                                                    <?php elseif($pedido->estatus == 4): ?>
                                                        Enviado
                                                    <?php else: ?>
                                                        Cancelado
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#bf2546; font-family:Arial; text-align:center; color:#FFFFFF; padding-top:10px; padding-bottom:10px;">
                                <tr>
                                    <td>
                                        <p style="text-align:center"><strong>Estimado(a): <?php echo e($pedido->usuario->nombreCompleto); ?></strong></p>
                                        <div style="text-align:center: font-size:12px">Por medio del presente correo, confirmamos tu orden y te damos las gracias por elegirnos como tu tienda de preferencia.</div>
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
                                                <td><?php echo e($pedido->nombreCompleto.' '.$pedido->aPaterno.' '.$pedido->aMaterno); ?> </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Teléfono:</td>
                                                <td ><?php echo e($pedido->telefono); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Estado:</td>
                                                <td ><?php echo e($pedido->estado); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Deleg/Mun:</td>
                                                <td ><?php echo e($pedido->municipio); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Colonia:</td>
                                                <td ><?php echo e($pedido->colonia); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">CP:</td>
                                                <td ><?php echo e($pedido->cp); ?></td>
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
                                                <td ><?php echo e($pedido->calle); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Entre Calle:</td>
                                                <td ><?php echo e($pedido->entreCalle); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Número ext:</td>
                                                <td ><?php echo e($pedido->nExt); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Número int:</td>
                                                <td ><?php echo e($pedido->nInt); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #565656;">Referencias del domicilio:</td>
                                                <td><?php echo e($pedido->referencia_domicilio); ?> </td>
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
                                    <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr style="font-size:11px;">
                                            <td style="border:1px solid #3c3b3b;padding:5px;margin:5px;">
                                                <img src="<?php echo e(asset('storage/imagenesProductos/'.$detalle->producto->foto->nombre)); ?>" alt="" align="left" width="50" style="margin-right:5px;">
                                                <?php echo e($detalle->producto->nombre); ?><br>
                                                <div>
                                                Marca: <?php echo e($detalle->producto->marca->nombre); ?>

                                                </div>
                                            </td>
                                            <td style="border:1px solid #3c3b3b;padding:10px;margin:10px;"><?php echo e($detalle->cantidad); ?></td>
                                            <td style="border:1px solid #3c3b3b;padding:10px;margin:10px;">$<?php echo e($detalle->precio); ?></td>
                                            <td style="border:1px solid #3c3b3b;padding:10px;margin:10px;">$<?php echo e($detalle->precio*$detalle->cantidad); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <td style="text-align:right; color:#bf2546; ">$<?php echo e($pedido->subtotal); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;"></td>
                                    <td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">
                                        <div>Gastos de Envío</div>
                                    </td>
                                    <?php if($pedido->costo_envio == 0): ?>
                                        <td style="text-align:right; color:#359902; ">Envío Gratis</td>
                                    <?php else: ?>
                                        <td style="text-align:right; color:#359902; "><?php echo e($pedido->costo_envio); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php if($pedido->costo_meses > 0): ?>
                                    <tr>
                                        <td style="width: 50%;"></td>
                                        <td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">Costo meses sin intereses</td>
                                        <td style="text-align:right; color:#bf2546; ">$<?php echo e($pedido->costo_meses); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="width: 50%;"></td>
                                    <td style="text-align:right;font-size:14px;font-weight:bold;padding-right:10px; font-family:Arial,Helvetica;">TOTAL</td>
                                    <td style="text-align:right; color:#bf2546; font-size:20px ">$<?php echo e($pedido->total); ?></td>
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
                                                    <strong>MÉTODO DE PAGO: </strong> <?php echo e($pedido->tipoPago); ?>     
                                                    <?php if($pedido->tipoPago == "Paypal"): ?>
                                                        <img src="<?php echo e(asset('storage/imagenesLayout/paypal.png')); ?>" alt="PaypalLogo" width=160>
                                                    <?php elseif($pedido->tipoPago == "ConektaTarjeta"): ?>
                                                        <img src="<?php echo e(asset('storage/imagenesLayout/credits.png')); ?>" alt="Tarjetas" width=160>
                                                    <?php elseif($pedido->tipoPago == "ConektaOXXO"): ?>
                                                        <img src="<?php echo e(asset('storage/imagenesLayout/oxxopay.png')); ?>" alt="OXXOPay" width=160>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="float:right; padding-right: 10%;">
                                                    <strong >Status del pago:</strong>
                                                    <?php if($pedido->estatus == 0): ?>
                                                        <button class="btn btn-danger" disabled style="opacity:1;">Cancelado</button>
                                                    <?php elseif($pedido->estatus == 1): ?>
                                                        <button class="btn btn-info" disabled style="opacity:1;">En proceso de pago</button>
                                                    <?php elseif($pedido->estatus == 2 || $pedido->estatus == 3 || $pedido->estatus == 4): ?>
                                                        <button class="btn btn-success" disabled style="opacity:1;">Pagado</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($pedido->tipoPago == "ConektaOXXO" && $pedido->estatus == 1): ?>
                                            <table width='100%'>
                                                <tr>
                                                    <td width="50%" style="padding-right: 5px;">
                                                        <div class="opps-instructions" style="color: #7C7C7C; font-family: 'Arial'; font-size: 12px; ">
                                                            <h3 style="margin-bottom: 2px;">Instrucciones</h3>
                                                            <ol style="padding:0px 0px 0px 10px;">
                                                                <li style="padding-bottom: 12px;">Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
                                                                <li style="padding-bottom: 12px;">Indica en caja que quieres ralizar un pago de <strong>OXXOPay</strong>.</li>
                                                                <li style="padding-bottom: 12px;">Dicta al cajero el número de referencia en esta ficha para que tecleé directamente en la pantalla de venta.</li>
                                                                <li style="padding-bottom: 12px;">Realiza el pago correspondiente con dinero en efectivo.</li>
                                                                <li style="padding-bottom: 12px;">Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
                                                            </ol>
                                                            <h3 style="margin-bottom: 2px;">*Recuerda pagar antes de <?php echo e(date_format(date_create($pedido->fechaExpPago), 'd/m/Y H:i:s')); ?></h3>
                                                            <div class="opps-footnote" style="color: #108f30;  border:1px solid #108f30; margin-bottom:20px; padding-top:5px; padding-bottom: 5px; text-align: center;">Al completar estos pasos recibirás un correo de <strong>ventas@gbroute.com.mx</strong> confirmando tu pago.</div>
                                                        </div>
                                                    </td>
                                                    <td width="50%" valign="top" style="padding-left: 5px;">
                                                        <div class="opps-header">
                                                            <div class="opps-reminder" style="background: #000; color: #FFF;text-align: center; padding-top: 8px; padding-bottom: 8px; font-size: 11px; font-family: 'Arial' "><br><p>FICHA DIGITAL. NO ES NECESARIO IMPRIMIR.</p><br></div>
                                                            <div class="opps-info" style="font-family: 'Arial'">
                                                                                
                                                                                <div class="opps-ammount">
                                                                                    <h3>MONTO A PAGAR</h3>
                                                                                    <h2 style="margin-bottom: 2px; font-size: 28px">$<?php echo e($pedido->total); ?> <sup style="color: #000; font-size: 18px">MXN</sup></h2>
                                                                                    <p style="color: #7C7C7C; font-size: 10px; margin-top: 0px;">OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                                                                                </div>
                                            

                                                            </div>
                                                            <div class="opps-reference" style="font-family:'Arial'">
                                                                <h3 style="margin-bottom: 2px;">REFERENCIA</h3>
                                                                <h1 style="border: 1px solid #7C7C7C; text-align: center; padding: 4px 0; margin-top: 0px;"><?php echo e($pedido->referOXXO); ?></h1>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
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
													(777)311-2741 
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