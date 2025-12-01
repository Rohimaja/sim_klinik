// $(document).ready(function () {
//     table = $("#data-pasien").DataTable({
//         searching: true,
//         paging: true,
//         info: true,
//         scrollX: true,
//         autoWidth: false,
//     });
// });

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
