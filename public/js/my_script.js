// Toggle Sidebar
const hamburger = document.getElementById('hamburger');
const sidebar = document.getElementById('sidebar');

hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Toggle Dropdown Submenu
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const parent = toggle.parentElement;
        parent.classList.toggle('active');
    });
});

function formatCurrency(input) {
    let angka = angkaBersih(input.value);
    input.value = angka ? angka.toLocaleString('id-ID') : '';
}

function hanyaAngka(event) {
    const charCode = event.charCode;
    return charCode >= 48 && charCode <= 57;
}

function angkaBersih(value) {
    return parseInt(value.replace(/[^0-9]/g, '')) || 0
}

function formatRupiah(angka) {
    return 'Rp. ' + angka.toLocaleString('id-ID')
}

function hitungHargaJual() {
    const hpp = angkaBersih(document.getElementById('hpp').value);
    const margin = angkaBersih(document.getElementById('margin').value);

    const total = hpp + margin;

    document.getElementById('harga_jual').value =
        total ? total.toLocaleString('id-ID') : '';
}

