<?php
$this->section('Dashboard', '"./../../css/styles.css"');
$this->authLayout();
?>
<h1 class="text-center text-bold py-5">Editar Usuario</h1>

<?php $this->getSessionMessage(); ?>

<div class="py-8">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="POST" id="update-user" action="/auth/users/<?php echo $data->user->id ?>/update">
                    <div class="form-group">
                        <span for="name">Nombre</span>  
                        <input type="text" class="form-control form-control-lg" id="name" name="name" value="<?php echo $data->user->name ?>" >
                    </div>
                    <div class="form-group">
                        <span for="last_name">Apellido</span>
                        <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" value="<?php echo $data->user->last_name ?>" >
                    </div>
                    <div class="form-group">
                        <span for="email">Correo</span>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?php echo $data->user->email ?>" >
                    </div>
                    <div class="form-group">          
                        <span for="password">Contraseña</span>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" >
                    </div>
                    <button type="submit" class="btn btn-info btn-lg w-100">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../../js/dashboard.js"') ?>
<?php $this->endSection(); ?>