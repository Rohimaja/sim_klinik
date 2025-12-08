const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

$(document).ready(function () {
    // ========================================
    // INIT DATATABLE
    // ========================================
    const table = $("#data-kunjungan").DataTable({
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
                previous: "‹",
            },
            infoEmpty: "Tidak ada data",
            emptyTable: "Belum ada kunjungan pasien",
        },
    });

    // ========================================
    // MANUAL SEARCH
    // ========================================
    $("#tableSearch").on("keyup", function () {
        table.search(this.value).draw();
    });

    // ========================================
    // SET DEFAULT TANGGAL = HARI INI
    // ========================================
    const today = new Date().toLocaleDateString("en-CA");
    $("#tgl_kunjungan").val(today);

    // ========================================
    // EVENT FILTER TANGGAL & STATUS
    // ========================================
    $("#status, #tgl_kunjungan").on("change", applyFilters);

    // ========================================
    // MAIN FILTER FUNCTION
    // ========================================
    function applyFilters() {
        const status = $("#status").val();
        const tgl = $("#tgl_kunjungan").val();

        fetch(
            `/perawat/getFilterKunjungan?status=${status}&tgl_kunjungan=${tgl}`
        )
            .then((response) => response.json())
            .then((data) => updateTable(data))
            .catch((error) => console.error("Error fetching data:", error));
    }

    function generateRow(item, index) {
        return `
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                ${index + 1}
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.pasien?.no_rm ?? ""}
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.pasien?.nama ?? ""}
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.umur} Tahun
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.tgl_kunjungan ?? ""}
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.keluhan_awal ?? ""}
            </td>

            <td class="px-6 py-4">
                ${generateStatusBadge(item.status)}
            </td>

            <td class="px-6 py-4 text-center">
                ${generateActionButtons(item)}
            </td>
        </tr>
    `;
    }

    function updateTable(data) {
        let html = "";
        // Jika data kosong
        if (!data || data.length === 0) {
            html = `
            <tr>
                <td colspan="8" class="px-6 py-6 text-center text-gray-600 dark:text-gray-300">
                    Tidak ada kunjungan ditemukan
                </td>
            </tr>
        `;
            $("#data-kunjungan tbody").html(html);
            return; // Jangan lanjutkan render baris
        }

        data.forEach((item, index) => {
            html += generateRow(item, index);
        });

        $("#data-kunjungan tbody").html(html);
    }

    // ========================================
    // UPDATE DATATABLE
    // ========================================
    // function updateTable(data) {
    //     table.clear();

    //     data.forEach((item, index) => {
    //         table.row.add([
    //             `<div>${index + 1}</div>`,
    //             item.pasien?.no_rm ?? "",
    //             item.pasien?.nama ?? "",
    //             `${item.umur} Tahun`,
    //             item.tgl_kunjungan ?? "",
    //             item.keluhan_awal ?? "",
    //             generateStatusBadge(item.status),
    //             generateActionButtons(item),
    //         ]);
    //     });

    //     table.draw();
    // }

    // function updateTable(data) {
    //     let html = "";

    //     data.forEach((item, index) => {
    //         html += `
    //         <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
    //             <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">${
    //                 index + 1
    //             }</td>
    //             <td class="px-6 py-4 text-sm">${item.pasien?.no_rm ?? ""}</td>
    //             <td class="px-6 py-4 text-sm">${item.pasien?.nama ?? ""}</td>
    //             <td class="px-6 py-4 text-sm">${item.umur} Tahun</td>
    //             <td class="px-6 py-4 text-sm">${item.tgl_kunjungan}</td>
    //             <td class="px-6 py-4 text-sm">${item.keluhan_awal ?? ""}</td>
    //             <td class="px-6 py-4">${generateStatusBadge(item.status)}</td>
    //             <td class="px-6 py-4 text-center">
    //                 ${generateActionButtons(item)}
    //             </td>
    //         </tr>
    //     `;
    //     });

    //     $("#data-kunjungan tbody").html(html);

    //     table.draw();
    // }

    // ========================================
    // GENERATE STATUS BADGE
    // ========================================
    function generateStatusBadge(status) {
        const badges = {
            "tidak hadir": `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                text-xs font-semibold bg-red-100 dark:bg-red-900/30
                text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                    Tidak Hadir
                </span>`,

            menunggu: `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30
                text-yellow-800 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                    Menunggu Skrining
                </span>`,

            dipanggil: `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                text-xs font-semibold bg-blue-100 dark:bg-blue-900/30
                text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                    Sedang Periksa
                </span>`,

            selesai: `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                text-xs font-semibold bg-green-100 dark:bg-green-900/30
                text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                    Selesai
                </span>`,

            dibatalkan: `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                text-xs font-semibold bg-red-100 dark:bg-red-900/30
                text-red-800 dark:text-red-400 border-red-200 dark:border-red-800">
                    Batal
                </span>`,
        };

        return badges[status] ?? "";
    }

    // ========================================
    // GENERATE ACTION BUTTONS
    // ========================================
    function generateActionButtons(item) {
        let html = `
            <div class="flex items-center justify-center gap-2">
                <button
                    @click="viewModal = true; $nextTick(() => loadKunjunganDetail(${item.id}))"
                    class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700
                           text-white rounded-lg transition-colors text-xs font-medium">
                    <i class="fa-solid fa-eye mr-1"></i> Detail
                </button>
        `;

        // Sudah skrining → Edit
        if (item.skrining) {
            html += `
                <a href="/perawat/kunjungan/${item.skrining.id}/edit"
                    class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg
                           transition-colors text-xs font-medium">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Skrining
                </a>`;
        }
        // Belum → Panggil
        else {
            html += `
                <form action="/perawat/kunjungan/${item.id}/update-status" method="POST">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit"
                        class="px-3 py-1.5 bg-purple-500 hover:bg-purple-600 text-white
                               rounded-lg transition-colors text-xs font-medium">
                        <i class="fa-solid fa-file-medical mr-1"></i> Panggil
                    </button>
                </form>`;
        }

        html += `</div>`;
        return html;
    }

    // ========================================
    // LOAD DATA AWAL (default hari ini)
    // ========================================
    applyFilters();
});

// $(document).ready(function () {
//     const table = $("#data-kunjungan").DataTable({
//         pageLength: 5,
//         lengthMenu: [5, 10, 25, 50, 100],
//         dom: '<"flex justify-between items-center mb-3 text-sm"l><"overflow-x-auto"t><"flex flex-col items-center mt-4 space-y-2"ip>',
//         language: {
//             lengthMenu: "Tampilkan _MENU_ data per halaman",
//             info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
//             paginate: {
//                 first: "«",
//                 last: "»",
//                 next: "›",
//                 previous: "‹",
//             },
//             infoEmpty: "Tidak ada data",
//             emptyTable: "Belum ada data dokter",
//         },
//     });

//     // Fitur pencarian manual
//     $("#tableSearch").on("keyup", function () {
//         table.search(this.value).draw();
//     });

//     const today = new Date().toISOString().slice(0, 10);
//     $("#tgl_kunjungan").val(today);

//     $("#status, #tgl_kunjungan").on("change", function () {
//         const status = $("#status").val();
//         const tgl = $("#tgl_kunjungan").val();

//         fetch(
//             `/perawat/getFilterKunjungan?status=${status}&tgl_kunjungan=${tgl}`
//         )
//             .then((response) => response.json())
//             .then((data) => {
//                 table.clear();

//                 data.forEach((item, index) => {
//                     // ===== STATUS BADGE =====
//                     let statusBadge = "";
//                     switch (item.status) {
//                         case "tidak hadir":
//                             statusBadge = `
//                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
//                                 text-xs font-semibold bg-red-100 dark:bg-red-900/30
//                                 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
//                                 Tidak Hadir
//                             </span>`;
//                             break;
//                         case "menunggu":
//                             statusBadge = `
//                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
//                                 text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30
//                                 text-yellow-800 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
//                                 Menunggu Skrining
//                             </span>`;
//                             break;
//                         case "dipanggil":
//                             statusBadge = `
//                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
//                                 text-xs font-semibold bg-blue-100 dark:bg-blue-900/30
//                                 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
//                                 Sedang Periksa
//                             </span>`;
//                             break;
//                         case "selesai":
//                             statusBadge = `
//                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
//                                 text-xs font-semibold bg-green-100 dark:bg-green-900/30
//                                 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
//                                 Selesai
//                             </span>`;
//                             break;
//                         case "dibatalkan":
//                             statusBadge = `
//                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
//                                 text-xs font-semibold bg-red-100 dark:bg-red-900/30
//                                 text-red-800 dark:text-red-400 border-red-200 dark:border-red-800">
//                                 Batal
//                             </span>`;
//                             break;
//                     }

//                     // ===== AKSI TOMBOL =====
//                     let actionButtons = `
//                     <div class="flex items-center justify-center gap-2">

//                         <button
//                             @click="viewModal = true; $nextTick(() => loadKunjunganDetail(${item.id}))"
//                             class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700
//                                    text-white rounded-lg transition-colors text-xs font-medium">
//                             <i class="fa-solid fa-eye mr-1"></i> Detail
//                         </button>
//                 `;

//                     if (item.skrining) {
//                         // Sudah skrining → tombol Edit
//                         actionButtons += `
//                         <a href="/perawat/kunjungan/${item.skrining.id}/edit"
//                             class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg
//                                    transition-colors text-xs font-medium">
//                             <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Skrining
//                         </a>
//                     `;
//                     } else {
//                         // Belum skrining → tombol Panggil
//                         actionButtons += `
//                         <form action="/perawat/kunjungan/${item.id}/panggil" method="POST">
//                             <input type="hidden" name="_token" value="${csrfToken}">
//                             <button type="submit"
//                                 class="px-3 py-1.5 bg-purple-500 hover:bg-purple-600 text-white
//                                        rounded-lg transition-colors text-xs font-medium">
//                                 <i class="fa-solid fa-file-medical mr-1"></i> Panggil
//                             </button>
//                         </form>
//                     `;
//                     }

//                     actionButtons += `</div>`;

//                     // ===== TAMBAH KE DATATABLE =====
//                     table.row.add([
//                         `<div>${index + 1}</div>`,
//                         item.pasien?.no_rm ?? "",
//                         item.pasien?.nama ?? "",
//                         `${item.umur} Tahun`,
//                         item.tgl_kunjungan ?? "",
//                         item.keluhan_awal ?? "",
//                         statusBadge,
//                         actionButtons,
//                     ]);
//                 });

//                 table.draw();
//             })
//             .catch((error) => console.error("Error fetching data:", error));
//     });
// });

window.loadKunjunganDetail = function (id) {
    $.ajax({
        url: "/perawat/kunjungan/" + id,
        // url: `/admin/master-dokter/${id}`,

        method: "GET",
        success: function (res) {
            $("#nama").text(res.nama);
            $("#jenis_kelamin").html(
                res.jenis_kelamin === "L"
                    ? '<i class="fa-solid fa-mars text-blue-500 mr-1"></i> Laki-laki'
                    : '<i class="fa-solid fa-venus text-pink-500 mr-1"></i> Perempuan'
            );
            $("#tgl_lahir").text(`${res.tgl_lahir} (${res.umur} tahun)`);
            $("#email").text(res.email ?? "-");
            $("#nik").text(res.nik ?? "-");
            $("#no_telp").text(res.no_telp ?? "-");
            $("#no_rm").text(res.no_rm);
            $("#keluhan_awal").text(res.keluhan_awal ?? "-");
            // 🟢 Status aktif / non-aktif
            if (res.status === "menunggu") {
                $("#statusDetail").html("Menunggu");
            } else if (res.status === "tidak hadir") {
                $("#statusDetail")
                    .html("Tidak Hadir")
                    .removeClass("text-yellow-600 dark:text-yellow-400")
                    .addClass("text-red-600 dark:text-red-400");
            } else if (res.status === "dipanggil") {
                $("#statusDetail")
                    .html("Sedang Skrining")
                    .removeClass("text-yellow-600 dark:text-yellow-400")
                    .addClass("text-blue-600 dark:text-blue-400");
            } else if (res.status === "selesai") {
                $("#statusDetail")
                    .html("Selesai")
                    .removeClass("text-yellow-600 dark:text-yellow-400")
                    .addClass("text-green-600 dark:text-green-400");
            } else {
                $("#statusDetail")
                    .html("Di Batalkan")
                    .removeClass("text-yellow-600 dark:text-yellow-400")
                    .addClass("text-red-600 dark:text-red-400");
            }
        },
        error: function () {
            alert("Gagal mengambil data dokter");
        },
    });
};
