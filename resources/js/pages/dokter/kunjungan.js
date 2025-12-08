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
    $("#filter-tanggal").val(today);

    // ========================================
    // EVENT FILTER TANGGAL & STATUS
    // ========================================
    $("#filter-status, #filter-tanggal").on("change", applyFilters);

    // ========================================
    // MAIN FILTER FUNCTION
    // ========================================
    function applyFilters() {
        const status = $("#filter-status").val();
        const tgl = $("#filter-tanggal").val();

        fetch(
            `/dokter/getFilterKunjungan?filter-status=${status}&filter-tanggal=${tgl}`
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
                ${item.kunjungan.pasien?.no_rm ?? ""}
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.kunjungan.pasien?.nama ?? ""}
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.umur} Tahun
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${item.kunjungan.tgl_kunjungan ?? ""}
            </td>

            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                ${
                    item.kunjungan?.skrining?.keluhan_utama ??
                    item.kunjungan.keluhan_awal ??
                    "-"
                }
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
    //             item.kunjungan.pasien?.no_rm ?? "",
    //             item.kunjungan.pasien?.nama ?? "",
    //             `${item.umur} Tahun`,
    //             item.kunjungan.tgl_kunjungan ?? "",
    //             item.kunjungan.keluhan_awal ?? "",
    //             generateStatusBadge(item.status),
    //             generateActionButtons(item),
    //         ]);
    //     });

    //     table.draw();
    // }

    // ========================================
    // GENERATE STATUS BADGE
    // ========================================
    function generateStatusBadge(status) {
        const badges = {
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
        if (item.pemeriksaan) {
            html += `
                <a href="/dokter/kunjungan/${item.pemeriksaan.id}/edit"
                    class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg
                           transition-colors text-xs font-medium">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Pemeriksaan
                </a>`;
        }
        // Belum → Panggil
        else {
            html += `
                <form action="/dokter/kunjungan/${item.id}/update-status" method="POST">
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

window.loadKunjunganDetail = function (id) {
    $.ajax({
        url: "/dokter/kunjungan/" + id,
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
            $("#keluhan").text(res.keluhan);
            $("#tensi").text(res.tensi);
            $("#suhu").text(res.suhu);
            $("#berat_badan").text(res.bb);
            $("#tinggi_badan").text(res.tb);
            $("#no_rm").text(res.no_rm);
            // 🟢 Status aktif / non-aktif
            if (res.status === "menunggu") {
                $("#statusDetail").html("Menunggu");
            } else if (res.status === "dipanggil") {
                $("#statusDetail")
                    .html("Sedang Diperiksa")
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

// function dataPasien() {
//     return {
//         pasienList: [],
//         searchPasien: "",
//         pasienDipilih: null,

//         loadPasien() {
//             fetch("/petugas/list-pasien")
//                 .then((res) => res.json())
//                 .then((data) => {
//                     this.pasienList = data;
//                     console.log(data);
//                 })
//                 .catch(() => alert("Gagal mengambil data pasien"));
//         },
//     };
// }

function dataPasien() {
    return {
        modalOpen: false,
        pasienDipilih: null,

        pilihPasien(pasien) {
            this.pasienDipilih = pasien;
            this.modalOpen = false;
        },

        init() {
            const that = this;

            $("#tabelPasien").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/petugas/list-pasien",
                columns: [
                    { data: "DT_RowIndex", name: "DT_RowIndex" },
                    { data: "nama", name: "nama" },
                    { data: "rm", name: "rm" },
                    { data: "jk", name: "jk" },
                    { data: "alamat", name: "alamat" },
                    {
                        data: null,
                        render: function (data) {
                            return `
                                <button class="pilih-btn bg-indigo-600 text-white px-3 py-1 rounded"
                                data-pasien='${JSON.stringify(data)}'>
                                Pilih
                                </button>
                            `;
                        },
                    },
                ],
            });

            // ketika tombol pilih ditekan
            $(document).on("click", ".pilih-btn", function () {
                let pasien = JSON.parse($(this).attr("data-pasien"));
                that.pilihPasien(pasien);
            });
        },
    };
}

$(document).ready(function () {
    function loadDokter(poliId, tgl, oldDokterId = null) {
        if (poliId && tgl) {
            fetch(
                `/petugas/jadwal-dokter-by-date?poli_id=${poliId}&tanggal=${tgl}`
            )
                .then((response) => response.json())
                .then((data) => {
                    const dokterSelect = $("#dokter_id");

                    dokterSelect.empty();
                    dokterSelect.append(
                        '<option hidden value="">-- Pilih Dokter --</option>'
                    );

                    data.forEach((item) => {
                        dokterSelect.append(
                            `<option value="${item.dokter.id}" ${
                                item.dokter.id == oldDokterId ? "selected" : ""
                            }>${item.dokter.nama}</option>`
                        );
                    });

                    // Kalau mode edit → trigger jam
                    if (oldDokterId) {
                        $("#dokter_id").trigger("change");
                    }
                })
                .catch((error) => {
                    console.error("Error fetching Dokter:", error);
                });
        }
    }

    // Trigger saat memilih Poli & Tanggal
    $("#poli_id, #tgl_kunjungan").on("change", function () {
        const poliId = $("#poli_id").val();
        const tgl = $("#tgl_kunjungan").val();
        loadDokter(poliId, tgl);
    });

    // OLD VALUE (mode edit)
    const oldPoli = $("#poli_id").val();
    const oldTgl = $("#tgl_kunjungan").val();
    const oldDokter = $("#dokter_id").data("old"); // pastikan hidden id ada

    if (oldPoli && oldTgl) {
        loadDokter(oldPoli, oldTgl, oldDokter);
    }
});

// $(document).ready(function () {
//     function loadDokter(poliId, tgl, oldDokterId = null) {
//         if (poliId && tgl) {
//             fetch(`/petugas/jadwal-dokter-by-date?poli=${poliId}&tgl=${tgl}`)
//                 .then((response) => response.json())
//                 .then((data) => {
//                     const dokterSelect = $("#dokter_id");

//                     dokterSelect.empty();

//                     data.forEach((item) => {
//                         dokterSelect.append(
//                             `<option value="${e.dokter.id}" ${
//                                 e.dokter.id == oldDokterId ? "selected" : ""
//                             }>${e.dokter.nama}</option>`
//                         );
//                     });
//                 })
//                 .catch((error) => {
//                     console.error("Error fetching Dokter:", error);
//                 });
//         }
//     }

//     $("#poli_id, #tgl_kunjungan").on("change", function () {
//         const poliId = $("#poli_id").val();
//         const tgl = $("#tgl_kunjungan").val();
//         loadDokter(poliId, tgl);
//     });

//     const oldPoli = $("#poli_id").val();
//     const oldTgl = $("#tgl_kunjungan").val();
//     const oldDokter = $("#dokter_id").data("old");

//     if (oldPoli && oldTgl) {
//         loadDokter(oldPoli, oldTgl, oldDokter);
//     }
// });

// ketika pilih tanggal kunjungan
$("#tgl_kunjungan").on("change", function () {
    let tgl = $(this).val();

    // Ambil dokter lama dari hidden input
    let oldDokterId = $("#edit_dokter_id").val();

    $.ajax({
        url: "/petugas/jadwal-dokter-by-date",
        type: "GET",
        data: { tanggal: tgl },
        success: function (res) {
            $("#dokter_id")
                .empty()
                .append('<option hidden value="">-- Pilih Dokter --</option>');

            res.forEach((e) => {
                $("#dokter_id").append(
                    `<option value="${e.dokter.id}" ${
                        e.dokter.id == oldDokterId ? "selected" : ""
                    }>${e.dokter.nama}</option>`
                );
            });

            // Kalau edit → trigger change untuk load jam
            if ($("#is_edit").val() === "1") {
                $("#dokter_id").trigger("change");
            }
        },
    });
});

// // ketika pilih tanggal kunjungan
// $("#tgl_kunjungan").on("change", function () {
//     let tgl = $(this).val();
//     let oldDokterId = null;

//     $.ajax({
//         url: "/petugas/jadwal-dokter-by-date",
//         type: "GET",
//         data: { tanggal: tgl },
//         success: function (res) {
//             $("#dokter_id")
//                 .empty()
//                 .append('<option hidden value="">-- Pilih Dokter --</option>');

//             res.forEach((e) => {
//                 $("#dokter_id").append(
//                     `<option value="${e.dokter.id}"${
//                         e.dokter.id == oldDokterId ? "selected" : ""
//                     }>${e.dokter.nama}</option>`
//                 );
//             });
//         },
//     });
//     const oldMatkul = $("#matkul").data("old");
// });

// // ---- Ketika halaman finish load ----
// $(document).ready(function () {
//     if ($("#is_edit").val() === "1") {
//         // 1. panggil AJAX isi dokter berdasarkan tanggal lama
//         $("#tgl_kunjungan").trigger("change");

//         // delay sedikit agar dokter selesai dimuat
//         setTimeout(() => {
//             $("#dokter_id").val($("#edit_dokter_id").val()).trigger("change");
//         }, 300);
//     }
// });

// ketika pilih dokter → ambil jam jadwalnya
$("#dokter_id").on("change", function () {
    $.ajax({
        url: "/petugas/jam-dokter",
        type: "GET",
        data: {
            dokter_id: $("#dokter_id").val(),
            tanggal: $("#tgl_kunjungan").val(),
        },
        success: function (res) {
            $("#jam").empty();

            let jamValue = `${res.jam_mulai}-${res.jam_akhir}`;
            let jamText = `${res.jam_mulai} - ${res.jam_akhir}`;

            $("#jam").append(`<option value="${jamValue}">${jamText}</option>`);

            $("#jam_awal").val(res.jam_mulai);
            $("#jam_akhir").val(res.jam_akhir);

            // kalau mode edit - set jam yang lama
            if ($("#is_edit").val() === "1") {
                let oldJam =
                    $("#edit_jam_awal").val() +
                    "-" +
                    $("#edit_jam_akhir").val();
                $("#jam").val(oldJam);
            }
        },
    });
});

// window.loadPasien = function () {
//     $.ajax({
//         url: "/petugas/list-pasien",
//         // url: `/petugas/kunjungan/list-pasien`,

//         method: "GET",
//         success: function (res) {
//             console.log(res);
//             pasienList = res;
//         },

//         // success: function (res) {
//         //     $("#nama").text(res.nama);
//         //     $("#jenis_kelamin").html(
//         //         res.jenis_kelamin === "L"
//         //             ? '<i class="fa-solid fa-mars text-blue-500 mr-1"></i> Laki-laki'
//         //             : '<i class="fa-solid fa-venus text-pink-500 mr-1"></i> Perempuan'
//         //     );
//         //     $("#no_rm").text(res.tempat_lahir);
//         //     $("#tgl_lahir").text(`${res.tgl_lahir} (${res.umur} tahun)`);
//         // },
//         error: function () {
//             alert("Gagal mengambil data dokter");
//         },
//     });
// };
