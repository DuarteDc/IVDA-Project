(() => {

    const $d = document;

    $d.addEventListener('DOMContentLoaded', () => {
        const alert = $d.querySelector(".alert");
        if (!alert) return;
        setTimeout(() => alert.classList.add('opacity-0', 'transition-all', 'duration-500', 'ease-out'), 1500);
        setTimeout(() => alert.remove(), 3000);

        $('#signin').validate({
            rules: {
                email: {
                    required:true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
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
