(() => {
  const $d = document;


  const fetchData = async (endpoint, data, method = 'GET') => {

    let res;

    if (method === 'GET') {
      res = await fetch(endpoint);
      return await res.json();
    } else {
      res = fetch(endpoint, {
        method,
        body: JSON.stringify(data)
      });

      return res.json();
    }

  };


  $d.addEventListener('DOMContentLoaded', () => {
    const $div = $d.createElement('div');

    const $btnModal = $d.querySelector('#btn-modal');

    $btnModal.addEventListener('click', async () => {


      const data = await fetchData('/auth/subsecretaries-api');
      console.log(data);

      $div.innerHTML = `<div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
              <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg px-5 py-3">
                  <h2 class="text-center">Crear Unidad Administrativa</h2>
                  <form>
                  <div class="[&>input]:text-white">
                    <span for="name">Nombre</span>
                    <input type="text" class="placeholder:text-zinc-400 w-full border border-1 rounded-md px-3 py-3 lg:py-2 focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-0 bg-slate-800" placeholder="Nombre" name="name" autocomplete="current-passowrd" id="name">
                  </div>
                  <div class="[&>input]:text-white">
                    <span for="name">Subsecretaria</span>
                    <select>
                      ${data.map((el) => (
                        `<option>${el.name}</option>`
                      ))}
                    </select>
                  </div>
                  <button class="w-full my-3 rounded-lg bg-blue-600 hover:bg-blue-500 transition-all duration-300 py-3 text-white ease-in">
                    Guardar
                  </button>
                  </form>
                </div>
              </div>
            </div>
          </div>`;
      $d.body.append($div);

      const $btnCancel = $d.querySelector('#btn-cancel');
      $btnCancel.addEventListener('click', () => {
        $d.body.removeChild($div);
      })

    })

  });

})();

