<?php
$this->section('Inventario');
$this->authLayout();
?>

<h1 class="pt-5 text-center">
    Lista de inventarios
</h1>
<section class="px-md-2 card">
    <div class="overflow-auto">
    <div class="mt-2 md:mt-5 lg:mt-10 w-full d-flex justify-content-end py-4">
            <a href="/auth/users/create" class="btn btn-info">
                <i class="fas fa-plus"></i>
                Generar inventario
            </a>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Fecha de inicio</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Fecha de termino</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$data->invetories) {
                    echo '<tr><td colspan="6" class="py-5"> No hay inventarios disponibles </td></tr>';
                } else {
                    foreach ($data->invetories as $inventory) {
                        echo "<tr class='hover:bg-gray-100 text-center'>
                            <td>{$inventory->id}</td>
                            <td>{$inventory->name}</td>
                            <td>{$inventory->start_date}</td>
                            <td class='[&>span]:px-4 [&>span]:rounded-full [&>span]:text-white'>
                            <span class=" . ($inventory->status ? 'bg-emerald-700' : 'bg-amber-600') . ">
                                " . ($inventory->status ?  "Completado" : "Finalizado") .
                            "</span>
                            </td>
                            <td>{$inventory->end_date}</td>
                            <td class='flex items-center justify-center'>
                            <div class='btn btn-danger' title='Generar reporte'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-file-type-pdf' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                                    <path d='M14 3v4a1 1 0 0 0 1 1h4'></path>
                                    <path d='M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4'></path>
                                    <path d='M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6'></path>
                                    <path d='M17 18h2'></path>
                                    <path d='M20 15h-3v6'></path>
                                    <path d='M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z'></path>
                                </svg>
                                </div>
                            </td>
                    </tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <ul class="pagination">
                <li class="page-item <?php echo ($data->page <= 1) ?  'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $data->page - 1   ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($i = 1; $i <= $data->totalPages; $i++) {
                    echo '<li class="page-item ' . ($data->page == $i ? "active" : "") . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                ?>
                <li class="page-item <?php echo ($data->page >= $data->totalPages) ?  'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $data->page + 1   ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>
<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/dashboard.js"') ?>
<?php $this->endSection(); ?>