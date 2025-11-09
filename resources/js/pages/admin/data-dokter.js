// $(document).ready(function () {
//     const table = $("#data-dosen").DataTable({
//         searching: true,
//         paging: true,
//         info: true,
//         scrollX: true,
//         autoWidth: false,
//     });
// });

// window.loadDokterDetail = function (id) {
//     $.ajax({
//         url: "/admin/master-dokter/" + id,
//         // url: `/admin/master-dokter/${id}`,

//         method: "GET",
//         success: function (res) {
//             console.log(res);

//             $("#nama").val(res.user.nama);
//             $("#jenis_kelamin").val(
//                 res.jenis_kelamin === "L" ? "Laki-laki" : "Perempuan"
//             );
//             $("#tempat_lahir").val(res.tempat_lahir);
//             $("#tgl_lahir").val(res.tgl_lahir);
//             $("#email").val(res.user.email);
//             $("#no_telp").val(res.no_telp);
//             $("#alamat").val(res.alamat);
//             $("#poli").val(res.poli.nama);
//             $("#no_telp").val(res.no_telp);
//             $("#no_str").val(res.no_str);
//             $("#no_sip").val(res.no_sip);
//             $("#spesialisasi").val(res.spesialisasi);
//             $("#status").val(res.status);
//         },
//         error: function () {
//             alert("Gagal mengambil data dosen");
//         },
//     });
// };

window.loadDokterDetail = function (id) {
    $.ajax({
        url: `/admin/master-dokter/${id}`,
        method: "GET",
        dataType: "json", // pastikan respon di-parse ke object
        success: function (res) {
            console.log("Respon diterima:", res);

            // pastikan elemen muncul (Alpine render selesai)
            setTimeout(() => {
                $("#nama").val(res.user?.nama ?? "-");
                $("#jenis_kelamin").val(
                    res.jenis_kelamin === "L" ? "Laki-laki" : "Perempuan"
                );
                $("#tempat_lahir").val(res.tempat_lahir ?? "-");
                $("#tgl_lahir").val(res.tgl_lahir ?? "-");
                $("#email").val(res.user?.email ?? "-");
                $("#no_telp").val(res.no_telp ?? "-");
                $("#alamat").val(res.alamat ?? "-");
                $("#poli").val(res.poli?.nama ?? "-");
                $("#no_str").val(res.no_str ?? "-");
                $("#no_sip").val(res.no_sip ?? "-");
                $("#spesialisasi").val(res.spesialisasi ?? "-");
                $("#status").val(res.status ?? "-");
            }, 200); // beri jeda 200ms agar modal benar-benar aktif
        },
        error: function (xhr, status, error) {
            console.error("Status:", xhr.status);
            console.error("Error:", error);
            console.error("Response:", xhr.responseText);
        },
    });
};
