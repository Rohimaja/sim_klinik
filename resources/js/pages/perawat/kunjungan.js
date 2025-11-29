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

    $("#status, #tgl_kunjungan").on("change", function () {
        const status = $("#status").val();
        const tgl = $("#tgl_kunjungan").val();
        if (status || tgl) {
            fetch(
                `/perawat/getFilterKunjungan?status=${status}&tgl_kunjungan=${tgl}`
            )
                .then((response) => response.json())
                .then((data) => {
                    table.clear();

                    data.forEach((item, index) => {
                        const fotoUrl = item.foto
                            ? `/storage/${item.foto}`
                            : "/images/profil-kosong.png";

                        table.row.add([
                            `<div style="text-align:left;">${index + 1}</div>`,
                            `<div class="w-10 h-10 bg-red-200 rounded-full overflow-hidden">
                                <img src="${fotoUrl}" alt="Photo" class="w-full h-full object-cover">
                            </div>`,
                            item.nim,
                            item.nama,
                            item.jenis_kelamin === "L"
                                ? "Laki-laki"
                                : "Perempuan",
                            item.email,
                            `${item.prodi?.nama_prodi ?? ""}` || "-",
                            item.semester,
                            `<div class="flex gap-2 justify-center">
                                <button @click="openView = true; $nextTick(() => loadMahasiswaDetail(${item.id}))"
                                        class="cursor-pointer px-2 py-1 bg-gray-600 hover:bg-gray-700 active:bg-gray-800 text-white rounded-md">
                                    <i class="bi bi-eye text-lg"></i>
                                </button>
                                <a href="/admin/master-mahasiswa/${item.id}/edit" class="cursor-pointer px-2 py-1 bg-yellow-600 hover:bg-yellow-700 active:bg-yellow-800 text-white rounded-md">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>
                                <form action="/admin/master-mahasiswa/${item.id}" method="POST" class="form-hapus inline-block">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="px-2 py-1 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-md">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                              </div>`,
                        ]);
                    });

                    table.draw();
                })
                .catch((error) => console.error("Error fetching data:", error));
        }
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
                $("#status").html("Menunggu");
            } else if (res.status === "dipanggil") {
                $("#status")
                    .html("Di Panggil")
                    .removeClass("text-yellow-600 dark:text-yellow-400")
                    .addClass("text-blue-600 dark:text-blue-400");
            } else if (res.status === "selesai") {
                $("#status")
                    .html("Selesai")
                    .removeClass("text-yellow-600 dark:text-yellow-400")
                    .addClass("text-green-600 dark:text-green-400");
            } else {
                $("#status")
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
