<?php
$this->section('Dashboard - Perfil', '"./../css/styles.css"');
$this->authLayout();
?>

<?php $this->getSessionMessage(); ?>

<section class="py-20 flex justify-center flex-col w-full lg:w-9/12 mx-auto">
    <div class="flex items-center">
        <img src="https://ui-avatars.com/api/?name=<?php echo $this::auth()->name ." ". $this::auth()->last_name ?>" alt="<?php $this::auth()->name ?>" loading="lazy" class="w-[18rem] lg:w-[22rem] lg:h-[22rem] rounded-full" width="50" heigth="50">
        <div class="flex flex-col mx-2 md:mx-4">
            <h1 class="text-4xl font-bold"><?php echo $this::auth()->name . " " . $this::auth()->last_name ?></h1>
            <h2><?php echo $this::auth()->email ?></h2>
        </div>
    </div>
    <div class="mt-10">
        <div class="card-body [&>form>div>div>input]:text-white">
            <form method="POST" id="update-user" action="/auth/profile/update">
            <div class="grid grid-col-1 lg:grid-cols-2">
                <div class="form-group">
                    <span for="name">Nombre</span>
                    <input type="text" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" placeholder="Nombre" name="name" autocomplete="current-passowrd" id="name" value="<?php echo $this::auth()->name ?>">
                </div>
                <div class="form-group">
                    <span for="last_name">Apellido</span>
                    <input type="text" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" id="last_name" placeholder="Apellido" name="last_name" value="<?php echo $this::auth()->last_name ?>">
                </div>
            </div>
            <div class="grid grid-col-1 md:grid-cols-2">
                <div class="form-group">
                    <span for="email">Correo</span>
                    <input type="email" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" id="email" name="email" placeholder="Correo" value="<?php echo $this::auth()->email ?>">
                </div>
                <div class="form-group">
                    <span for="password">Contraseña</span>
                    <input type="password" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" id="password" name="password" placeholder="Contraseña" value="">
                </div>
            </div>
                <button class="rounded-md w-full py-4 lg:py-2 font-bold bg-blue-600 hover:bg-blue-500 transition-all duration-300 ease-in text-white mt-10">
                    Guardar
                </button>
            </form>
        </div>
    </div>
</section>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/profile.js"') ?>
<?php $this->endSection(); ?>