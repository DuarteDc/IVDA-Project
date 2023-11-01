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
  <div class="mt-40 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 transition-all duration-500 ease-in">
  <div class="text-white w-full shadow-lg rounded-2xl flex flex-col justify-center items-center px-1 text-center md:px-4 lg:py-10 lg:text-2xl py-5 bg-rose-700/90 transition-all duration-200 ease-in hover:scale-[1.02]">
      <p class="text-4xl font-bold">1</p>
      <span class="text-sm md:text-base lg:text-xl xl:text-2xl">Inventarios Pendientes</span>
    </div>
    <div class="text-white w-full shadow-lg rounded-2xl flex flex-col justify-center items-center px-1 text-center md:px-4 lg:py-10 lg:text-2xl py-5 bg-blue-700/90 transition-all duration-200 ease-in hover:scale-[1.02]">
      <p class="text-4xl font-bold">40</p>
      <span class="text-sm md:text-base lg:text-xl xl:text-2xl">Inventarios Creados</span>
    </div>
  </div>
<?php $this->endAuthLayout() ?>
<?php $this->scripts('"./js/dashboard.js"') ?>
<?php $this->endSection(); ?>