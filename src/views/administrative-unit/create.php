<?php
$this->section('Dashboard - Inventario', '"./../../../css/styles.css"');
$this->authLayout();
?>
<section class="mx-auto py-20 overflow-x-auto relative">
    <h1 class="text-center text-3xl lg:text-6xl font-bold pb-10 text-blue-600">Crear Unidad Administrativa</h1>
    <span class="flex text-lg items-center my-5">
        <a href="/" class="font-bold text-blue-600 hover:text-blue-500"><i class="fa-solid fa-house mr-2"></i>Inicio></a>
        <a href="/auth/administrative-unit" class="font-bold text-blue-600 hover:text-blue-500">Unidad Administrativa></a>
        <p class="font-thin text-gray-600">Crear</p>
    </span>

    <div class="card-body [&>form>div>div>input]:text-white">
        <form method="POST" id="update-user" action="/auth/administrative-unit/save">
            <div class="grid grid-col-1 lg:grid-cols-2">
                <div class="form-group">
                    <span for="name">Nombre</span>
                    <input type="text" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-4 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" placeholder="Nombre" name="name" autocomplete="current-passowrd" id="name">
                </div>
                <div class="form-group">
                    <span for="subsecretary_id">Apellido</span>
                    <select name="subsecretary_id" class="block text-white w-full border border-2 rounded-md px-4 py-4 lg:py-3 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800 ">
                      <?php
                        foreach($data->subsecretaries as $subsecretary) {
                            echo '<option class="py-5" value="'.$subsecretary->id.'">'.$subsecretary->name.'</option>';
                        }
                      ?>
                    </select>
                </div>
            </div>
            <button class="rounded-md w-full py-4 lg:py-2 font-bold bg-blue-600 hover:bg-blue-500 transition-all duration-300 ease-in text-white mt-10">
                Guardar
            </button>
        </form>
    </div>
</section>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/model-administrative-unit.js"') ?>
<?php $this->endSection(); ?>