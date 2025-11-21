// $(document).ready(function () {
//     const table = $("#data-dosen").DataTable({
//         searching: true,
//         paging: true,
//         info: true,
//         scrollX: true,
//         autoWidth: false,
//     });
// });

window.loadAdminDetail = function (id) {
    $.ajax({
        url: "/superadmin/master-admin/" + id,
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
