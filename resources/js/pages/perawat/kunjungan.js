const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

$(document).ready(function () {
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
            emptyTable: "Belum ada data dokter",
        },
    });

    // Fitur pencarian manual
    $("#tableSearch").on("keyup", function () {
        table.search(this.value).draw();
    });

    // $("#status, #tgl_kunjungan").on("change", function () {
    //     const status = $("#status").val();
    //     const tgl = $("#tgl_kunjungan").val();
    //     if (status || tgl) {
    //         fetch(
    //             `/perawat/getFilterKunjungan?status=${status}&tgl_kunjungan=${tgl}`
    //         )
    //             .then((response) => response.json())
    //             .then((data) => {
    //                 table.clear();

    //                 data.forEach((item, index) => {
    //                     table.row.add([
    //                         `<div style="text-align:left;">${index + 1}</div>`,
    //                         item.pasien.no_rm,
    //                         item.pasien.nama,
    //                         item.pasien.jenis_kelamin === "L"
    //                             ? "Laki-laki"
    //                             : "Perempuan",
    //                         item.email,
    //                         `${item.prodi?.nama_prodi ?? ""}` || "-",
    //                         item.semester,
    //                         `<div class="flex gap-2 justify-center">
    //                             <button @click="openView = true; $nextTick(() => loadMahasiswaDetail(${item.id}))"
    //                                     class="cursor-pointer px-2 py-1 bg-gray-600 hover:bg-gray-700 active:bg-gray-800 text-white rounded-md">
    //                                 <i class="bi bi-eye text-lg"></i>
    //                             </button>
    //                             <a href="/admin/master-mahasiswa/${item.id}/edit" class="cursor-pointer px-2 py-1 bg-yellow-600 hover:bg-yellow-700 active:bg-yellow-800 text-white rounded-md">
    //                                 <i class="bi bi-pencil-square text-lg"></i>
    //                             </a>
    //                             <form action="/admin/master-mahasiswa/${item.id}" method="POST" class="form-hapus inline-block">
    //                                 <input type="hidden" name="_token" value="${csrfToken}">
    //                                 <input type="hidden" name="_method" value="DELETE">
    //                                 <button type="submit" class="px-2 py-1 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-md">
    //                                     <i class="bi bi-trash text-lg"></i>
    //                                 </button>
    //                             </form>
    //                           </div>`,
    //                     ]);
    //                 });

    //                 table.draw();
    //             })
    //             .catch((error) => console.error("Error fetching data:", error));
    //     }
    // });

    $("#status, #tgl_kunjungan").on("change", function () {
        const status = $("#status").val();
        const tgl = $("#tgl_kunjungan").val();

        fetch(
            `/perawat/getFilterKunjungan?status=${status}&tgl_kunjungan=${tgl}`
        )
            .then((response) => response.json())
            .then((data) => {
                table.clear();

                data.forEach((item, index) => {
                    // ===== STATUS BADGE =====
                    let statusBadge = "";
                    switch (item.status) {
                        case "menunggu":
                            statusBadge = `
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30
                                text-yellow-800 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                Menunggu Skrining
                            </span>`;
                            break;
                        case "dipanggil":
                            statusBadge = `
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                text-xs font-semibold bg-blue-100 dark:bg-blue-900/30
                                text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                Sedang Periksa
                            </span>`;
                            break;
                        case "selesai":
                            statusBadge = `
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                text-xs font-semibold bg-green-100 dark:bg-green-900/30
                                text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                                Selesai
                            </span>`;
                            break;
                        case "dibatalkan":
                            statusBadge = `
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                text-xs font-semibold bg-red-100 dark:bg-red-900/30
                                text-red-800 dark:text-red-400 border-red-200 dark:border-red-800">
                                Batal
                            </span>`;
                            break;
                    }

                    // ===== AKSI TOMBOL =====
                    let actionButtons = `
                    <div class="flex items-center justify-center gap-2">

                        <button
                            @click="viewModal = true; $nextTick(() => loadKunjunganDetail(${item.id}))"
                            class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700
                                   text-white rounded-lg transition-colors text-xs font-medium">
                            <i class="fa-solid fa-eye mr-1"></i> Detail
                        </button>
                `;

                    if (item.skrining) {
                        // Sudah skrining → tombol Edit
                        actionButtons += `
                        <a href="/perawat/kunjungan/${item.skrining.id}/edit"
                            class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg
                                   transition-colors text-xs font-medium">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Skrining
                        </a>
                    `;
                    } else {
                        // Belum skrining → tombol Panggil
                        actionButtons += `
                        <form action="/perawat/kunjungan/${item.id}/panggil" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit"
                                class="px-3 py-1.5 bg-purple-500 hover:bg-purple-600 text-white
                                       rounded-lg transition-colors text-xs font-medium">
                                <i class="fa-solid fa-file-medical mr-1"></i> Panggil
                            </button>
                        </form>
                    `;
                    }

                    actionButtons += `</div>`;

                    // ===== TAMBAH KE DATATABLE =====
                    table.row.add([
                        `<div>${index + 1}</div>`,
                        item.pasien?.no_rm ?? "",
                        item.pasien?.nama ?? "",
                        `${item.umur} Tahun`,
                        item.keluhan_awal ?? "",
                        statusBadge,
                        actionButtons,
                    ]);
                });

                table.draw();
            })
            .catch((error) => console.error("Error fetching data:", error));
    });
});

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
