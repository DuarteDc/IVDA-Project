(() => {
    const $d = document;

    $d.addEventListener('DOMContentLoaded', () => {

        const alert = $d.querySelector(".alert");
        if (!alert) return;
        setTimeout(() => alert.classList.add('opacity-0', 'transition-all', 'duration-500', 'ease-out'), 2000);
        setTimeout(() => alert.remove(), 3000);

        $('#create-user').validate({
            rules: {
                name: {
                    required: true, 
                },
                last_name: {
                    required: true, 
                },
                email: {
                    required:true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                name: {
                    required: 'El nombre es requerido',
                },
                last_name: {
                    required: 'El apellido es requerido'
                },  
                email: {
                    required: 'El correo es requerido',
                    email: 'El corro no es valido',
                },
                password: {
                    required: 'La contraseña es requerida',
                    minlength: 'La contraseña debe contener al menos 8 caracteres',
                }
            }
        });

    });

})();
