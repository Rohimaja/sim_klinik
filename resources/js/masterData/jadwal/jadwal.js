
// view jadwal
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tableSearch');
    const filterRole = document.getElementById('filterRole');
    const filterPoli = document.getElementById('filterPoli');
    const filterHari = document.getElementById('filterHari');
    const tableRows = document.querySelectorAll('#dataTable tbody tr');

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const roleValue = filterRole.value;
        const poliValue = filterPoli.value;
        const hariValue = filterHari.value;

        tableRows.forEach((row, index) => {
            const nama = row.getAttribute('data-nama');
            const role = row.getAttribute('data-role');
            const poli = row.getAttribute('data-poli');
            const hari = row.getAttribute('data-hari');

            const matchSearch = nama.includes(searchValue);
            const matchRole = roleValue === '' || role === roleValue;
            const matchPoli = poliValue === '' || poli === poliValue;
            const matchHari = hariValue === '' || hari === hariValue;

            if (matchSearch && matchRole && matchPoli && matchHari) {
                row.style.display = '';
                // Update nomor urut
                row.cells[0].textContent = Array.from(tableRows)
                    .filter(r => r.style.display !== 'none')
                    .indexOf(row) + 1;
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event listeners
    searchInput.addEventListener('keyup', filterTable);
    filterRole.addEventListener('change', filterTable);
    filterPoli.addEventListener('change', filterTable);
    filterHari.addEventListener('change', filterTable);
});

// form jadwal

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const jamMulai = document.querySelector('input[name="jam_mulai"]');
    const jamSelesai = document.querySelector('input[name="jam_selesai"]');

    form.addEventListener('submit', function(e) {
        // Validasi jam
        if (jamMulai.value && jamSelesai.value) {
            if (jamMulai.value >= jamSelesai.value) {
                e.preventDefault();
                alert('Jam selesai harus lebih besar dari jam mulai!');
                jamSelesai.focus();
                return false;
            }
        }

        // Validasi minimal 1 hari dipilih
        const hariCheckboxes = document.querySelectorAll('input[name="hari[]"]:checked');
        if (hariCheckboxes.length === 0) {
            e.preventDefault();
            alert('Pilih minimal 1 hari untuk jadwal!');
            return false;
        }
    });
});