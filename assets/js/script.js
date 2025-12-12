// assets/js/script.js

document.addEventListener('DOMContentLoaded', () => {
    // 1. Dropdown Menu (Menu Hamburger)
    const menuButton = document.querySelector('.menu-toggle');
    const menuDropdown = document.querySelector('.dropdown-menu'); // Asumsikan ada menu

    if (menuButton && menuDropdown) {
        menuButton.addEventListener('click', () => {
            menuDropdown.classList.toggle('active');
        });
    }

    // 2. Map Accordion (untuk maps.php)
    const mapHeaders = document.querySelectorAll('.map-header');

    mapHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const card = header.closest('.map-card');

            // Tutup semua konten map
            document.querySelectorAll('.map-content.active').forEach(item => {
                if (item !== content) {
                    item.classList.remove('active');
                    item.closest('.map-card').style.backgroundImage = 'none';
                    item.closest('.map-card').style.backgroundRepeat = 'initial';
                    item.closest('.map-card').style.backgroundSize = 'initial';
                    item.closest('.map-card').style.backgroundColor = 'var(--color-secondary)';
                }
            });

            // Buka/Tutup konten yang diklik
            if (content.classList.contains('active')) {
                content.classList.remove('active');
                card.style.backgroundImage = 'none';
                card.style.backgroundColor = 'var(--color-secondary)';
            } else {
                content.classList.add('active');
                // Ganti: Lakukan perubahan background di sini
                // Untuk demo, kita ganti background card jadi warna solid saat aktif
                card.style.backgroundColor = '#E0FFE0'; // Warna latar saat aktif
                
                // Jika ingin ganti background gambar map, Anda bisa menggunakan data attribute
                // const mapBgUrl = header.getAttribute('data-bg-url'); // Gantii
                // if(mapBgUrl) {
                //     card.style.backgroundImage = `url(${mapBgUrl})`;
                //     card.style.backgroundSize = 'cover';
                //     card.style.backgroundRepeat = 'no-repeat';
                // }
            }
        });
    });
});