document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('.menu-toggle');
    const menuDropdown = document.querySelector('.dropdown-menu'); 

    if (menuButton && menuDropdown) {
        menuButton.addEventListener('click', () => {
            menuDropdown.classList.toggle('active');
        });
    }
    const mapHeaders = document.querySelectorAll('.map-header');

    mapHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const card = header.closest('.map-card');

            document.querySelectorAll('.map-content.active').forEach(item => {
                if (item !== content) {
                    item.classList.remove('active');
                    item.closest('.map-card').style.backgroundImage = 'none';
                    item.closest('.map-card').style.backgroundRepeat = 'initial';
                    item.closest('.map-card').style.backgroundSize = 'initial';
                    item.closest('.map-card').style.backgroundColor = 'var(--color-secondary)';
                }
            });

            if (content.classList.contains('active')) {
                content.classList.remove('active');
                card.style.backgroundImage = 'none';
                card.style.backgroundColor = 'var(--color-secondary)';
            } else {
                content.classList.add('active');
                card.style.backgroundColor = '#E0FFE0';
            }
        });
    });
});