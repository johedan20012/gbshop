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
															<td style="color: #565656;; text-align:right">Clave de compra:</td>
															<td style="text-align:left"><?php echo e($pedido->clave); ?></td>
														</tr>
														<tr>
															<td style="color: #565656;; text-align:right">Fecha: </td>
															<td style="text-align:left"><?php echo e($pedido->created_at); ?></td>
														</tr>
														<tr>
															<td style="color: #565656;; text-align:right">Status de la compra: </td>
                                                            <td style="text-align:left">
                                                                <?php if($pedido->estatus == 1): ?>
                                                                    Pendiente
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
															<td style="color: #565656;">Nombre</td>
															<td><?php echo e($pedido->nombreCompleto.' '.$pedido->aPaterno.' '.$pedido->aMaterno); ?> </td>
														</tr>
														<tr>
															<td style="color: #565656;">Teléfono</td>
															<td ><?php echo e($pedido->telefono); ?></td>
														</tr>
														<tr>
															<td style="color: #565656;">Estado</td>
															<td ><?php echo e($pedido->estado); ?></td>
														</tr>
														<tr>
															<td style="color: #565656;">Deleg/Mun</td>
															<td ><?php echo e($pedido->municipio); ?></td>
														</tr>
														<tr>
															<td style="color: #565656;">Colonia</td>
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
															<td style="color: #565656;">Referencias del domicilio</td>
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
                                                            <?php echo e($detalle->producto->nombre); ?><br><?php echo e($detalle->producto->codigo); ?>

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
                                </tr>
                            </tbody>
                        </table>
        </div>
    </body>
</html>