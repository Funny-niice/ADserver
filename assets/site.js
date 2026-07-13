(function () {
    'use strict';

    var toggle = document.querySelector('[data-nav-toggle]');
    var header = document.querySelector('[data-site-header]');

    if (!toggle || !header) {
        return;
    }

    header.dataset.open = 'false';
    toggle.setAttribute('aria-expanded', 'false');

    toggle.addEventListener('click', function () {
        var isOpen = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
        header.dataset.open = isOpen ? 'false' : 'true';
    });
}());
