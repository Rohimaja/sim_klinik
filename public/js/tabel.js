$(document).ready(function () {
    const table = $('#dataTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        dom: '<"flex justify-between items-center mb-3 text-sm"l><"overflow-x-auto"t><"flex flex-col items-center mt-4 space-y-2"ip>',
        language: {
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "«",
                last: "»",
                next: "›",
                previous: "‹"
            },
            infoEmpty: "Tidak ada data",
            emptyTable: "Belum ada data dokter"
        }
    });

    // Fitur pencarian manual
    $('#tableSearch').on('keyup', function () {
        table.search(this.value).draw();
    });
});
