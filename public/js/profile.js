(() => {
    const $d = document;

    $d.addEventListener('DOMContentLoaded', () => {
        const alert = $d.querySelector(".alert");
        if (!alert) return;
        setTimeout(() => alert.classList.add('opacity-0', 'transition-all', 'duration-500', 'ease-out'), 1500);
        setTimeout(() => alert.remove(), 3000);

        $('#update-user').validate({
            rules: {
                email: {
                    required: false
                },
                password: {
                    minlength: 8
                }
            },
            messages: {
                email: {
                    email: 'El corro no es valido',
                },
                password: {
                    minlength: 'La contraseña debe contener al menos 8 caracteres',
                }
            }
        });

    });
})()