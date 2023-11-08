<?php $this->loginLayout(); ?>
    <main class="min-h-screen flex flex-col items-center w-full justify-center relative overflow-hidden px-5">
        <?php $this->getSessionMessage(); ?>
        <span class="w-[200px] h-[100px] lg:w-[400px] lg:h-[200px] rounded-3xl -rotate-45 bg-blue-600/10 shadow-[0_10px_150px_20px_rgba(30,64,175,0.5)] absolute bottom-0 -left-20 lg:-left-24"></span>
        <span class="w-[50px] h-[50px] lg:w-[100px] lg:h-[100px] rounded-md rotate-45 bg-blue-600/80  absolute lg:bottom-48 lg:left-40 bottom-20 left-16"></span>
        
        <span class="w-[200px] h-[200px] lg:w-[600px] lg:h-[600px] rounded-3xl rotate-45 border-blue-600/50 border-2 absolute top-10 -right-20 lg:-right-40"></span>
        <span class="w-[200px] h-[200px] lg:w-[600px] lg:h-[600px] rounded-3xl rotate-45 bg-blue-600/10 shadow-[0_10px_150px_20px_rgba(30,64,175,0.5)] absolute top-0 -right-20 lg:-right-40 z-10"></span>
        <span class="w-[100px] h-[100px] lg:w-[200px] lg:h-[200px] rounded-md rotate-45 bg-blue-600/80  absolute lg:top-40 top-10 lg:right-80 right-16 z-20"></span>

        <div class="w-full lg:w-5/12 py-40 rounded-md z-20 xl:px-20 px-0 max-w-[1200px] text-white [&>form>div>span]:text-black [&>form>div>span]:font-bold [&>form>div>label]:text-red-600  [&>form>div>label]:text-sm [&>form>div>label]:font-bold  [&>form>div]:mb-4">
            <h1 class="text-4xl lg:text-6xl xl:text-7xl font-extrabold text-center mb-20 text-black">Iniciar Sesión</h1>
            <form action="/signin" method="post" id="signin">   
                <div>
                    <span for="email">Correo electronico</span>                         
                    <input 
                        type="email" 
                        class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-5 py-5 lg:py-6 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800"
                        placeholder="Correo electronico"
                        name="email"
                        autocomplete="off"
                        >
                </div>
                <div>
                    <span for="password">Contraseña</span>                         
                    <input 
                        type="password" 
                        class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-5 py-5 lg:py-6 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800"
                        placeholder="Contraseña"
                        name="password"
                        autocomplete="current-passowrd"
                    >
                </div>
                <p class="text-right text-gray-500 font-bold mb-3">olvide mi contraseña</p>
                <button class="rounded-md w-full py-5 lg:py-6 font-bold bg-blue-600 hover:bg-blue-500 transition-all duration-300 ease-in">
                    Iniciar Sesíon
                </button>
            </form>
        </div>
    </main>

<?php $this->scripts('"./js/signin.js"') ?>
<?php $this->endSection(); ?>