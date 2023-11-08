<?php
$this->section('Dashboard', '"./../css/styles.css"');
$this->authLayout();
?>
<section class="container-fluid mx-auto">
  <div class="row justify-content-center mt-5">
    <div class=" col-11 home-card py-5 px-5 position-relative">
      <div class="info-box-content row">
        <h1>Hola,</h1>
        <h2><?php echo "{$this->auth()->name} {$this->auth()->last_name}"; ?></h2>
        <img src="/assets/home.svg" alt="Home" class="home-img">
      </div>
    </div>

    <div class="col-11 d-flex justify-content-end my-5">
      <button class="btn btn-info"><i class="fas fa-plus"></i> Crear inventario </button>
    </div>
    <div class="card-container col-11">
      <div class="small-box bg-info mt-lg-5 p-0 w-100 pt-5">
        <div class="inner">
          <h3>1</h3>
          <p>Inventarios Pendientes</p>
        </div>
        <div class="icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <a href="/auth/inventory" class="small-box-footer">
          Ver <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>

      <div class="small-box bg-gradient-success mt-lg-5 p-0 w-100 pt-5">
        <div class="inner">
          <h3><?php echo $data->userCount; ?></h3>
          <p>Total de usuarios</p>
        </div>
        <div class="icon">
          <i class="fa-solid fa-users"></i>
        </div>
        <a href="/auth/users" class="small-box-footer">
          Ver <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>

      <div class="small-box bg-gradient-warning mt-lg-5 p-0 w-100 pt-5">
        <div class="inner">
          <h3><?php echo $data->userCount; ?></h3>
          <p>Total de usuarios</p>
        </div>
        <div class="icon">
          <i class="fas fa-user-plus"></i>
        </div>
        <a href="/auth/users" class="small-box-footer">
          Ver <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./js/dashboard.js"') ?>
<?php $this->endSection(); ?>