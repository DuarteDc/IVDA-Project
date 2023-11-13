<?php
$this->section('Dashboard - Inventario', '"./../../../css/styles.css"');
$this->authLayout();
?>

<section class="mx-auto py-40">
    <h1>Subsecretaria - <?php echo $data->subsecretary->xd() ?></h1>
    <?php var_dump($data) ?>
</section>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./../js/subsecretary.js"') ?>
<?php $this->endSection(); ?>
