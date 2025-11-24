window.loadKunjunganDetail = function (id) {
    $.ajax({
        url: "/petugas/kunjungan/" + id,
        // url: `/admin/master-dokter/${id}`,

        method: "GET",
        success: function (res) {
            $("#nama").text(res.nama);
            $("#jenis_kelamin").html(
                res.jenis_kelamin === "L"
                    ? '<i class="fa-solid fa-mars text-blue-500 mr-1"></i> Laki-laki'
                    : '<i class="fa-solid fa-venus text-pink-500 mr-1"></i> Perempuan'
            );
            $("#tempat_lahir").text(res.tempat_lahir);
            $("#tgl_lahir").text(`${res.tgl_lahir} (${res.umur} tahun)`);
            $("#email").text(res.email ?? "-");
            $("#no_telp").text(res.no_telp ?? "-");
            $("#alamat").text(res.alamat);
            $("#poli").text(res.poli);
            $("#no_telp").text(res.no_telp);
            $("#no_rm").text(res.no_rm);
            $("#dokter").text(res.dokter);
            $("#no_bpjs").text(res.no_bpjs);
            $("#jenis_pasien").text(res.jenis_pasien);
            $("#tgl_kunjungan").text(res.tgl_kunjungan);
            // 🟢 Status aktif / non-aktif
            if (res.status === "menunggu") {
                $("#status").html("Menunggu");
            } else if (res.status === "dipanggil") {
                $("#status")
                    .html("Di Panggil")
                    .removeClass("bg-yellow-100 text-yellow-800")
                    .addClass("bg-blue-100 text-blue-800");
            } else if (res.status === "selesai") {
                $("#status")
                    .html("Selesai")
                    .removeClass("bg-yellow-100 text-yellow-800")
                    .addClass("bg-green-100 text-green-800");
            } else {
                $("#status")
                    .html("Di Batalkan")
                    .removeClass("bg-yellow-100 text-yellow-800")
                    .addClass("bg-red-100 text-red-800");
            }

            $("#update_at").text(`Terakhir diupdate: ${res.updated_at}`);

            $("#spesialisasi").text(res.spesialisasi);
        },
        error: function () {
            alert("Gagal mengambil data dokter");
        },
    });
};

function dataPasien() {
    return {
        pasienList: [],
        searchPasien: "",
        pasienDipilih: null,

        loadPasien() {
            fetch("/petugas/kunjungan/list-pasien")
                .then((res) => res.json())
                .then((data) => {
                    this.pasienList = data;
                    console.log(data);
                })
                .catch(() => alert("Gagal mengambil data pasien"));
        },
    };
}

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
