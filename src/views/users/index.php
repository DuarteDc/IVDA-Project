<?php
$this->section('Dashboard - Usuarios', '"./../css/styles.css"');
$this->authLayout();
?>

<?php $this->getSessionMessage(); ?>

<h1 class="py-5 text-center text-4xl">
    Lista de usuarios
</h1>



<section class="px-md-2 card">
    <div class="mt-2 md:mt-5 lg:mt-10 w-full d-flex justify-content-end py-4">
        <a href="/auth/users/create" class="btn btn-info">
            <i class="fas fa-plus"></i>
            Crear usuario
        </a>
    </div>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead class="thead-dark text-center">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!isset($data->users)) {
                    echo '<tr><td colspan="6" class="py-4 text-center"> No hay usuarios disponibles </td></tr>';
                } else {
                    foreach ($data->users as $user) {
                        echo "<tr class='text-center'>
                            <td>
                                <img src='https://ui-avatars.com/api/?name={$user->name} {$user->last_name}' alt='{$user->name}' loading='lazy' class='img-profile'>
                            </td>
                            <td>{$user->name}</td>
                            <td>{$user->last_name}</td>
                            <td>{$user->email}</td>
                            <td>
                            <span class=" . ($user->status ? ("'bg-success px-2 rounded-lg'") : ("'bg-warning px-2 rounded-lg'")) . ">
                                " . ($user->status ?  "Activo" : "Inactivo") .
                            "</span>
                            </td>
                            <td class='d-flex justify-content-center'>
                                <a href='/auth/users/{$user->id}' class='mx-1 btn btn-primary' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a>
                                ". ($user->status 
                                ? "<form method='POST' action='/auth/users/{$user->id}/delete'><button class='mx-1 btn btn-danger' title='Desativar'><i class='fa-solid fa-trash'></i></button></form>"
                                : "<form method='POST' action='/auth/users/{$user->id}/active'><button class='mx-1 btn btn-success' title='Activar'><i class='fa-solid fa-check'></i></button></form>") ."
                            </td>
                    </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        </div>
        <?php if (isset($data->users)) {
            echo '<div class="d-flex justify-content-end">
            <ul class="pagination">
                <li class="page-item ' . ($data->page <= 1 ?  "disabled" : "") . ' ">
                    <a class="page-link" href="?page=' . $data->page - 1 . '" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                ';
            for ($i = 1; $i <= $data->totalPages; $i++) {
                echo '<li class="page-item ' . ($data->page == $i ?  "active" : "") . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            };
            echo '
                <li class="page-item ' . ($data->page >= $data->totalPages ?  'disabled' : '') . '">
                    <a class="page-link" href="?page=' . $data->page + 1  . '" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>';
        } ?>
    
</section>
<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/dashboard.js"') ?>
<?php $this->endSection(); ?>