// =====================================================
// VALIDASI KODE BARANG
// Kode harus diawali BRG- dan diikuti angka
// Contoh: BRG-001
// =====================================================

function validasiKode(kode) {
    const pola = /^BRG-\d+$/;
    return pola.test(kode);
}


// =====================================================
// FORM TAMBAH BARANG
// =====================================================

const formBarang = document.getElementById("formBarang");

formBarang.addEventListener("submit", function (event) {

    // Mengambil nilai dari input kode
    const kode = document.getElementById("kode").value.trim();

    // Mengambil nilai jumlah dan mengubahnya menjadi angka
    const jumlah = Number(document.getElementById("jumlah").value);


    // =================================================
    // VALIDASI JUMLAH BARANG
    // Jumlah harus lebih dari 0
    // =================================================

    if (jumlah <= 0 || !Number.isFinite(jumlah)) {

        // Mencegah form dikirim jika jumlah tidak valid
        event.preventDefault();

        alert("Jumlah barang harus lebih dari 0!");

        return;
    }


    // =================================================
    // VALIDASI KODE BARANG
    // =================================================

    if (!validasiKode(kode)) {

        // Mencegah form dikirim jika kode tidak valid
        event.preventDefault();

        alert(
            "Kode barang harus menggunakan format BRG- diikuti angka. Contoh: BRG-002"
        );

        return;
    }


    // =================================================
    // JIKA SEMUA VALID
    // Form akan dilanjutkan ke:
    // simpan.php menggunakan method POST
    // =================================================

});