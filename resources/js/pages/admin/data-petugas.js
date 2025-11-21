// $(document).ready(function () {
//     const table = $("#data-dosen").DataTable({
//         searching: true,
//         paging: true,
//         info: true,
//         scrollX: true,
//         autoWidth: false,
//     });
// });

window.loadPetugasDetail = function (id) {
    $.ajax({
        url: "/admin/master-petugas/" + id,
        // url: `/admin/master-dokter/${id}`,

        method: "GET",
        success: function (res) {
            console.log(res);

            $("#nama").text(res.user.nama);
            $("#jenis_kelamin").html(
                res.jenis_kelamin === "L"
                    ? '<i class="fa-solid fa-mars text-blue-500 mr-1"></i> Laki-laki'
                    : '<i class="fa-solid fa-venus text-pink-500 mr-1"></i> Perempuan'
            );
            $("#tempat_lahir").text(res.tempat_lahir);
            $("#tgl_lahir").text(`${res.tgl_lahir} (${res.umur} tahun)`);
            $("#email").text(res.user.email);
            $("#no_telp").text(res.no_telp);
            $("#alamat").text(res.alamat);
            $("#no_telp").text(res.no_telp);
            $("#no_str").text(res.no_str);
            $("#no_sip").text(res.no_sip);
            $("#no_kta").text(res.no_nira);
            $("#jabatan").text(res.jabatan);
            // 🟢 Status aktif / non-aktif
            if (res.status === 1) {
                $("#status")
                    .html('<i class="fa-solid fa-check"></i> Aktif')
                    .removeClass("from-red-500 to-red-600")
                    .addClass("from-blue-500 to-blue-600");
            } else {
                $("#status")
                    .html('<i class="fa-solid fa-times"></i> Non-Aktif')
                    .removeClass("from-blue-500 to-blue-600")
                    .addClass("from-red-500 to-red-600");
            }

            $("#update_at").text(`Terakhir diupdate: ${res.updated_at}`);

            // $("#update_at").html(
            //     `<i class="fa-solid fa-info-circle mr-1"></i>
            //     <strong>Terakhir diupdate:</strong> ${formatted}`
            // );
        },
        error: function () {
            alert("Gagal mengambil data dokter");
        },
    });
};

// window.loadDokterDetail = function (id) {
//     $.ajax({
//         url: `/admin/master-dokter/${id}`,
//         method: "GET",
//         dataType: "json", // pastikan respon di-parse ke object
//         success: function (res) {
//             console.log("Respon diterima:", res);

//             // pastikan elemen muncul (Alpine render selesai)
//             setTimeout(() => {
//                 $("#nama").text(res.user?.nama ?? "-");
//                 $("#jenis_kelamin").text(
//                     res.jenis_kelamin === "L" ? "Laki-laki" : "Perempuan"
//                 );
//                 $("#tempat_lahir").text(res.tempat_lahir ?? "-");
//                 $("#tgl_lahir").text(res.tgl_lahir ?? "-");
//                 $("#email").text(res.user?.email ?? "-");
//                 $("#no_telp").text(res.no_telp ?? "-");
//                 $("#alamat").text(res.alamat ?? "-");
//                 $("#poli").text(res.poli?.nama ?? "-");
//                 $("#no_str").text(res.no_str ?? "-");
//                 $("#no_sip").text(res.no_sip ?? "-");
//                 $("#spesialisasi").text(res.spesialisasi ?? "-");
//                 $("#status").text(res.status ?? "-");
//             }, 200); // beri jeda 200ms agar modal benar-benar aktif
//         },
//         error: function (xhr, status, error) {
//             console.error("Status:", xhr.status);
//             console.error("Error:", error);
//             console.error("Response:", xhr.responseText);
//         },
//     });
// };
