<?php $this->section('Dashboard'); ?>

<main class="flex relative overflow-hidden">
  <aside class="lg:w-[400px] md:w-[200px] w-[100px] bg-blue-700 min-h-screen text-center text-white z-20 top-0 shadow-xl">
    <div class="border-b-2 w-full py-7">
      Home
    </div>
    <ul class="[&>li]:py-6 [&>li]:transition-all [&>li]:duration-500 [&>li]:ease-in font-bold lg:px-5 px-2 py-4 [&>li]:rounded-3xl [&>li]:my-4 [&>li]:flex [&>li]:items-center [&>li]:justify-center [&>li]:lg:px-4 [&>li]:lg:justify-start">
      <li class="hover:bg-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
          <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
          <path d="M10 12h4v4h-4z"></path>
        </svg>
        <span class="hidden md:block mx-2">Inicio</span>
      </li>
      <li class="hover:bg-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
          <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
          <path d="M9 9l1 0"></path>
          <path d="M9 13l6 0"></path>
          <path d="M9 17l6 0"></path>
        </svg>
        <span class="hidden md:block mx-2">Reportes</span>
      </li>
      <li class="hover:bg-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
          <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
        </svg>
        <span class="hidden md:block mx-2">Usuarios</span>
      </li>
    </ul>
  </aside>
  <section class="w-full">
    <nav class="w-full top-0 py-4 font-bold px-5 flex justify-between items-center max-w-screen static overflow-hidden text-black" aria-toggle="true">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M4 6l16 0"></path>
          <path d="M4 12l16 0"></path>
          <path d="M4 18l16 0"></path>
        </svg>
      </span>
      <div class="flex items-center">
        <span class="text-xs md:text-sm lg:text-base">Eduardo Duarte</span>
        <div class="rounded-full overflow-hidden w-12 h-12 mx-4">
          <img src="https://ui-avatars.com/api/?name=EduardoDuarte" alt="user" loading="lazy">
        </div>
      </div>
    </nav>
    <section class="mt-28 w-full lg:px-20 mx-auto px-5 static">
      <div class="w-full bg-blue-600 h-[300px] rounded-lg text-white relative px-2 lg:px-20 grid grid-cols-2 flex items-center shadow-2xl">
        <span>
          <h1 class="text-xl lg:text-6xl font-bold my-4"><b class="text-2xl lg:text-7xl">Hola</b>, Eduardo Duarte</h1>
          <p class="text-xs md:text-md lg:text-base">Bienvenido al Inventario General de Archivo</p>
        </span>
        <span class="absolute lg:right-40 lg:w-[40rem] lg:h-[20rem] md:-top-10 w-[10rem]">
          <img src="./assets/home.svg" alt="home-image" srcset="" width="400" height="200" class="w-full h-full">
        </span>
      </div>
      <div class="mt-10 w-full">
        <h2>Opciones</h2>
        <a href="/auth/inventario" class="float-right py-4 px-5 bg-blue-700 text-white rounded-full mt-10 cursor-pointer font-bold hover:bg-blue-600 transition-all ease-in duration-300 flex items-center">
          <span class="text-xl py-0 px-2 bg-blue-800 flex items-center justify-center rounded-lg mr-2 border-2 border-blue-600/40">
            +
          </span>
          Generar Inventario
        </a>
      </div>
      <div class="mt-40 grid grid-cols-3 gap-10">
        <div class="bg-white w-full border-blue-600/80 border-4 rounded-xl flex flex-col items-center py-10 text-2xl">
          Inventarios Creados
          <p class="text-4xl py-10">40</p>
        </div>
      </div>
      <!-- </section> -->
</main>

<?php $this->scripts('"./js/dashboard.js"') ?>
<?php $this->endSection(); ?>