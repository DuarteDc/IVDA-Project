<?php
$this->section('Inventario');
$this->authLayout();
?>

<h1 class="text-center text-xl md:text-4xl font-bold">
    Lista de inventarios
</h1>
<div class="container mx-auto mt-20 overflow-auto px-2">
    <div class="mt-2 md:mt-5 lg:mt-10 w-full flex justify-end">
        <a href="/auth/inventario" class="w-6/12 lg:w-2/12 py-2 px-3 text-xs md:text-sm lg:text-base lg:py-4 lg:px-5 bg-blue-700 text-white rounded-full mt-10 cursor-pointer font-bold hover:bg-blue-600 transition-all ease-in duration-300 flex items-center">
            <span class="text-xl py-0 px-2 bg-blue-800 flex items-center justify-center rounded-lg mr-2 border-2 border-blue-600/40">
                +
            </span>
            Generar Inventario
        </a>
    </div>
    <table class="w-full mt-10">
        <thead class="bg-blue-600 text-white [&>tr>th]:px-4 [&>tr>th]:text-xs [&>tr>th]:md:text-sm [&>tr>th]:text-base [&>tr>th]:py-4">
            <tr>
                <th class="rounded-tl-lg">ID</th>
                <th>Nombre</th>
                <th>Fecha de inicio</th>
                <th>Estatus</th>
                <th>Fecha de termino</th>
                <th class="rounded-tr-lg">Acciones</th>
            </tr>
        </thead>
        <tbody class="[&>tr>td]:py-4 [&>tr>td]:text-center [&>tr]:bg-white [&>tr>td]:text-xs [&>tr>td]:md:text-sm [&>tr>td]:text-base [&>tr]:cursor-pointer font-semibold">
            <?php
            if (!$data->invetories) {
                print '<th colspan="6" class="py-5"> No hay inventarios disponibles </th>';
            } else {
                foreach ($data->invetories as $inventory) {
                    echo "<tr class='hover:bg-gray-100'>
                            <td>{$inventory->id}</td>
                            <td>{$inventory->name}</td>
                            <td>{$inventory->start_date}</td>
                            <td class=''>Pendiente</td>
                            <td>{$inventory->end_date}</td>
                            <td>xD</td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/dashboard.js"') ?>
<?php $this->endSection(); ?>