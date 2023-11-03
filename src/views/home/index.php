<?php
$this->section('Dashboard');
$this->authLayout();
?>
<section class="lg:mt-28 md:mt-15 mt-10 w-full lg:px-20 mx-auto px-5  transition-all duration-500 ease-in">
  <div class="w-full bg-blue-600 lg:h-[300px]  h-[150px] rounded-lg text-white relative px-5 lg:px-10 grid grid-cols-1 md:grid-cols-2 flex items-center shadow-2xl">
    <span>
      <h1 class="text-xl lg:text-4xl xl:text-6xl font-bold my-4"><b class="text-2xl lg:text-5xl xl:text-7xl">Hola</b>, <?php echo "{$this->auth()->name} {$this->auth()->last_name}" ?></h1>
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
  <div class="mt-48 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-14 transition-all duration-500 ease-in">
    <div class="text-white w-full rounded-2xl flex flex-col justify-center items-center px-1 text-center md:px-4 lg:py-10 lg:text-2xl py-5 bg-rose-700/90 transition-all duration-200 ease-in hover:scale-[1.02] shadow-[0px_10px_40px_2px_rgba(255,29,72,0.5)]">
      <span class="lg:p-3 p-2 rounded-full bg-white text-rose-600 my-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-9 w-12 lg:w-20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
          <path d="M12 12h-3.5"></path>
          <path d="M12 7v5"></path>
        </svg>
      </span>
      <p class="text-4xl font-bold">1</p>
      <span class="text-sm md:text-base lg:text-xl xl:text-2xl">Inventarios Pendientes</span>
    </div>
    <div class="text-white w-full rounded-2xl flex flex-col justify-center items-center px-1 text-center md:px-4 lg:py-10 lg:text-2xl py-5 bg-blue-600 transition-all duration-200 ease-in hover:scale-[1.01] shadow-[0px_10px_40px_2px_rgba(30,64,175,0.5)]">
      <span class="lg:p-3 p-2 rounded-full bg-white text-blue-600 my-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-check w-12 lg:w-20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
          <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
          <path d="M9 14l2 2l4 -4"></path>
        </svg>
      </span>
      <p class="text-4xl font-bold">40</p>
      <span class="text-sm md:text-base lg:text-xl xl:text-2xl">Inventarios Creados</span>
    </div>
    <div class="text-white w-full rounded-2xl flex flex-col justify-center items-center px-1 text-center md:px-4 lg:py-10 lg:text-2xl py-5 bg-emerald-700 transition-all duration-200 ease-in hover:scale-[1.01] shadow-[0px_10px_40px_2px_rgba(4,120,87,0.5)]">
      <span class="lg:p-3 p-2 rounded-full bg-white text-emerald-700 my-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users w-12 lg:w-20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
          <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
        </svg>
      </span>
      <p class="text-4xl font-bold"><?php echo $data->userCount ?></p>
      <span class="text-sm md:text-base lg:text-xl xl:text-2xl">Total de usuarios</span>
    </div>
  </div>
  <?php $this->endAuthLayout() ?>
  <?php $this->scripts('"./js/dashboard.js"') ?>
  <?php $this->endSection(); ?>