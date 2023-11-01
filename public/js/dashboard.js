(() => {
    const $d = document;

    $d.addEventListener('DOMContentLoaded', () => {
        const nav = $d.querySelector('nav');
        const icon = $d.querySelector('.icon-tabler-menu-2');
        const aside = $d.querySelector('aside');
        
        icon.addEventListener('click', () => {
                const navbarStatus = JSON.parse(nav.getAttribute('aria-toggle')) || false;
                if ( navbarStatus ) {
                    aside.classList.add('absolute', '-left-[600px]', 'z-50');
                    return nav.setAttribute('aria-toggle', !navbarStatus);
                }
                aside.classList.remove('-left-[600px]', 'absolute');
                nav.setAttribute('aria-toggle', !navbarStatus);
            })
    });
})();
