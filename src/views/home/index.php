<?php
$this->section('Dashboard');
$this->authLayout();
?>
<section class="lg:mt-28 md:mt-15 mt-10 w-full lg:px-20 mx-auto px-5  transition-all duration-500 ease-in">
  <div class="w-full bg-blue-600 lg:h-[300px]  h-[150px] rounded-lg text-white relative px-5 lg:px-10 grid grid-cols-1 md:grid-cols-2 flex items-center shadow-2xl">
    <span>
      <h1 class="text-xl lg:text-4xl xl:text-6xl font-bold my-4"><b class="text-2xl lg:text-5xl xl:text-7xl">Hola</b>, Eduardo Duarte</h1>
      <p class="text-xs md:text-md lg:text-base">Bienvenido al Inventario General de Archivo</p>
    </span>
    <span class="flex justify-end">
      <img src="./assets/home.svg" alt="home-image" srcset="" width="400" height="200" class="w-[200px] md:w-[250px] lg:w-[300px] xl:w-[600px] hidden md:block -mt-10">
    </span>
  </div>
  <div class="mt-2 md:mt-5 lg:mt-10 w-full">
    <a href="/auth/inventario" class="float-right py-2 px-3 text-xs md:text-sm lg:text-base lg:py-4 lg:px-5 bg-blue-700 text-white rounded-full mt-10 cursor-pointer font-bold hover:bg-blue-600 transition-all ease-in duration-300 flex items-center">
      <span class="text-xl py-0 px-2 bg-blue-800 flex items-center justify-center rounded-lg mr-2 border-2 border-blue-600/40">
        +
      </span>
      Generar Inventario
    </a>
  </div>
  <!-- <div class="mt-40 grid grid-cols-3 gap-10 transition-all duration-500 ease-in">
    <div class="bg-white w-full border-blue-600/80 border-4 rounded-xl flex flex-col items-center py-10 text-2xl">
      Inventarios Creados
      <p class="text-4xl py-10">40</p>
    </div>
  </div> -->
<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./js/dashboard.js"') ?>
<?php $this->endSection(); ?>