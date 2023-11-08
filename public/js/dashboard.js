(() => {
    const $d = document;

    $d.addEventListener('DOMContentLoaded', () => {

        $(document).ready(function() {
            $(".alert").delay(3000).slideUp(300);
        });

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
