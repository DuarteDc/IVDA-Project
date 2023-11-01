(() => {
    const $d = document;

    $d.addEventListener('DOMContentLoaded', async () => {
        switch (window.location.pathname) {
            case '/':
                const { deleteAlert } = await import('./signin.js');
                deleteAlert();
                break
            default:
        }
    }, false);

})();