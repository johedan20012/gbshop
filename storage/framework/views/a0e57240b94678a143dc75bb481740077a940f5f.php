<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/auth/login.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
Login - Clientes
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h1 style="color:#c5171f"><i class="fa fa-user"></i></h1>
        </div>

        <?php if(Session::has('Error')): ?>
            <p class="text-danger"><?php echo e(Session::get('Error')); ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <form class="form-horizontal" method="POST" action="<?php echo e(route('loginCliente')); ?>">
            <?php echo e(csrf_field()); ?>

            <input type="text" id="user" class="fadeIn second" name="username" placeholder="Usuario" autocomplete="off" value="<?php echo e(old('username')); ?>">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Contraseña" autocomplete="new-password">

            <label>
                <input type="checkbox" name="remember" value="<?php echo e(old('remember') ? 'checked' : ''); ?>"> Recuerdame
            </label>

            <input type="submit" id="iniciar" class="fadeIn fourth" value="Iniciar Sesión">
        </form>
        
        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="#" onclick="alert('favor de pasar con Gerry, jajajaja')">¿Olvidaste usuario y/o contraseña?</a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>