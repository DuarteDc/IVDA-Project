<?php
$this->section('Dashboard - Inventario', '"./../../../css/styles.css"');
$this->authLayout();
?>

<section class="mx-auto py-20 overflow-x-auto relative">
    <h1 class="text-center text-3xl lg:text-6xl font-bold pb-10 text-blue-600">Unidades Administrativas</h1>
    <span class="flex text-lg items-center my-5">
        <a href="/" class="font-bold text-blue-600 hover:text-blue-500"><i class="fa-solid fa-house mr-2"></i>Inicio></a>
        <p class="font-thin text-gray-600 ml-2"> Subsecretarías</p>
    </span>

    <span class="flex w-full justify-end mb-5">
        <button id="btn-modal" class="px-3 py-2 text-sm lg:text-2xl flex items-center bg-blue-600 text-white rounded-full hover:bg-blue-500 transition-all ease-in duration-300" type="button"><i class="fa-solid fa-plus mr-1"></i> Crear unidad administrativa</button>
    </span>

    <div class="w-full mb-3 pl-1">
        <a href="?type=true" class="px-4 rounded-t-md py-4 <?php echo (!(isset($_GET['type'])) || $_GET['type'] == 'true' || $_GET['type'] != 'false' ? 'bg-blue-600 text-white' : '') ?>">Activos</a> 
        <a href="?type=false" class="px-4 rounded-t-md py-4 <?php echo (isset($_GET['type']) && $_GET['type'] == 'false' ? 'bg-blue-600 text-white' : '') ?>">Inactivos</a> 
    </div>

    <table class="w-full">
        <thead>
            <tr class="[&>*:first-child]:rounded-l-xl [&>*:last-child]:rounded-r-xl [&>th]:bg-blue-600 text-white [&>th]:py-5  [&>th]:px-2">
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Subsecretaria</th>
                <th scope="col">Estatus</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!isset($data->administrative_units)) {
                echo '<tr><td colspan="5" class="py-4 text-center"> No hay unidades administrativas disponibles </td></tr>';
            } else {
                foreach ($data->administrative_units as $unit) {
                    echo "<tr class='bg-white [&>td]:hover:bg-gray-100 [&>*:first-child]:rounded-l-xl [&>*:last-child]:rounded-r-xl [&>td]:px-5 [&>td]:py-6 border-1 cursor-pointer font-bold [&>*:first-child]:rounded-l-xl [&>*:last-child]:rounded-r-xl [&>td]:hover:duaration-500 [&>td]:hover:transition-all [&>td]:hover:ease-in'>
                            <td>{$unit->id}</td>
                            <td class='flex'><span class='bg-gray-100 rounded-full px-2 py-2 bg-gray-400 mx-2 text-gray-200'><i class='fa-regular fa-building mx-2'></i></span>
                                <span class='flex flex-col items-start'>
                                    {$unit->name}
                                    <p class='text-xs text-gray-500'>Unidad administrativa</p>
                                </span> 
                            </td>
                            <td>{$unit->subsecretary_id}</td>
                            <td class='[&>span]:px-4 [&>span]:rounded-full'>
                            <span class=" . ($unit->status ? '"bg-green-600/40 text-green-600 "' : '"bg-amber-400 text-amber-700"') . ">
                                " . ($unit->status ?  "Activo" : "Inactiva") .
                            "</span>
                            </td>                            
                            <td class='oveflow-hidden'>
                                <span class='flex items-center [&>a]:transition-all [&>a]:duration-300 [&>a]:ease-in'>
                                    <a class='bg-emerald-600/40 mx-1 rounded-xl px-2 py-2 shadow-md text-emerald-700 [&>i]:text-emerald-800 hover:bg-emerald-500 hover:text-white  [&>i]:hover:text-white'>Ver<i class='fa-solid fa-arrow-right mx-1'></i></a>
                                    <a class='bg-red-600/40 mx-1 rounded-xl px-2 py-2 shadow-md text-red-700 [&>i]:text-red-800 hover:bg-red-500 hover:text-white  [&>i]:hover:text-white'>Desactivar<i class='fa-solid fa-arrow-right mx-1'></i></a>
                               </span>
                            </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <?php if (isset($data->administrative_units)) {
            echo 
            '<div class="flex justify-end mt-2">
            <span class="flex items-center [&>*]:transition-all [&>*]:duration-300 [&>*]:ease-in text-black">
                    <a href="?page=' . ($data->page > 1 ? $data->page - 1 :  "$data->page")  . ' " class="py-2 px-3 border-blue-600 border-2 mr-1  rounded-lg ' . ($data->page > 1 ?  "hover:bg-blue-600 hover:text-white" : "disabled") . ' ">
                    <i class="fa-solid fa-chevron-left py-1"></i>
                    </a>
                ';
            for ($i = 1; $i <= $data->totalPages; $i++) {
                echo '<a  class="flex p-2 px-3 border-blue-600 border-2 mr-1  rounded-lg ' . ($data->page == $i ?  "bg-blue-600 text-white" : " hover:bg-blue-600 hover:text-white ") . '" href="?page=' . $i . '">' . $i . '</a>';
            };
            echo '
                <a href="?page=' . ($data->page < $data->totalPages ? $data->page + 1 :  "$data->page")  . ' " class="py-2 px-3 border-blue-600 border-2 mr-1  rounded-lg ' . ($data->page < $data->totalPages ?  "disabled" : "hover:bg-blue-600 hover:text-white") . ' ">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </ul>
        </span>';
        } ?>
        
</section>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/model-administrative-unit.js"') ?>
<?php $this->endSection(); ?>

