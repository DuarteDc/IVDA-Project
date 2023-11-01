(() => {
    const $d = document;

    $d.addEventListener('DOMContentLoaded', () => {
        const nav = $d.querySelector('nav');
        const icon = $d.querySelector('.icon-tabler-menu-2');
        const aside = $d.querySelector('aside');
        
        icon.addEventListener('click', () => {
                const navbarStatus = JSON.parse(nav.getAttribute('aria-toggle')) || false;
                if ( navbarStatus ) {
                    aside.classList.add('hidden')
                    return nav.setAttribute('aria-toggle', !navbarStatus);
                }
                aside.classList.remove('hidden')
                nav.setAttribute('aria-toggle', !navbarStatus);
            })
    });
})();