<?php
$this->section('Dashboard', '"./../../css/styles.css"');
$this->authLayout();
?>
<h1 class="text-center text-bold pt-5 text-6xl">Nuevo Usuario</h1>

<?php $this->getSessionMessage(); ?>

<div class="py-8">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body [&>form>div>input]:text-white">
                <form method="POST" id="update-user" action="/auth/users/<?php echo $data->user->id ?>/update">
                    <div class="form-group">
                        <span for="name">Nombre</span>
                        <input type="text" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" placeholder="Nombre" name="name" autocomplete="current-passowrd" id="name" value="<?php echo $data->user->last_name ?>" >
                    </div>
                    <div class="form-group">
                        <span for="last_name">Apellido</span>
                        <input type="text" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" id="last_name" placeholder="Apellido" name="last_name" value="<?php echo $data->user->last_name ?>" >
                    </div>
                    <div class="form-group">
                        <span for="email">Correo</span>
                        <input type="email" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" id="email" name="email" placeholder="Correo" value="<?php echo $data->user->email ?>" >
                    </div>
                    <div class="form-group">
                        <span for="password">Contraseña</span>
                        <input type="password" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" id="password" name="password" placeholder="Contraseña" value="" >
                    </div>
                    <button class="rounded-md w-full py-4 lg:py-2 font-bold bg-blue-600 hover:bg-blue-500 transition-all duration-300 ease-in text-white">
                        Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../../js/dashboard.js"') ?>
<?php $this->endSection(); ?>