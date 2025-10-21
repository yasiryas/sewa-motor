    $(document).ready(function() {
       $(function () {
            $(window).on("scroll", function () {
                if ($(this).scrollTop() > 50) {
            $(".navbar").addClass("scrolled");
                } else {
            $(".navbar").removeClass("scrolled");
        }
        });
    });

    $(function() {

    // Fungsi format tanggal ke dd/mm/yyyy
    function formatDate(dateStr) {
        if (!dateStr) return "";
        const date = new Date(dateStr);
        if (isNaN(date)) return "";
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }

    // Update preview ketika tanggal sewa / kembali berubah
    $("#tanggal_sewa, #tanggal_kembali").on("change", function() {
        const tanggalSewa = formatDate($("#tanggal_sewa").val());
        const tanggalKembali = formatDate($("#tanggal_kembali").val());

        $("#preview_tanggal").text(
            `Tanggal Sewa: ${tanggalSewa || '-'} | Tanggal Kembali: ${tanggalKembali || '-'}`
        );
    });
    });
});


