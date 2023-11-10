<?php
$this->section('Dashboard - Inventario', '"./../../../css/styles.css"');
$this->authLayout();
?>

<section>
    <h1 class="text-center text-6xl py-20">INVENTARIO GENERAL DE ARCHIVO</h1>
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="[&>span]:flex [&>span]:my-5 [&>span>*:first-child]:font-bold [&>span>*:first-child]:px-2">
            <span>
                <p>DEPENDENCiA:</p>
                <p>Secretaría de Finanzas</p>
            </span>
            <span>
                <p>CODIFICACIÓN ESTRUCTURAL:</p>
                <p></p>
            </span>
            <span>
                <p>UNIDAD ADMINISTRATIVA:</p>
                <p>Secretaría de Finanzas</p>
            </span>
            <span>
                <p>DEPENDENCiA:</p>
                <p>Secretaría de Finanzas</p>
            </span>
        </div>
        <div class="[&>span]:flex [&>span]:my-5 [&>span>*:first-child]:font-bold [&>span>*:first-child]:px-2">
            <span>
                <p>FECHA DE ELABORACIÓN:</p> 
                <p><?php echo $data->inventory->start_date ?></p>
            </span>
            <span>
                <p>TIPO DE ARCHIVO:</p>
                <p>Archivo de trámite</p>
            </span>
            <span>
                <p>UBICACIÓN FÍSICA:</p>
            </span>
        </div>
    </div>
</section>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/dashboard.js"') ?>
<?php $this->endSection(); ?>