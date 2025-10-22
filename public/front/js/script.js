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
    // Fungsi ubah format ke "1 September 2025"
    function formatLongDate(dateStr) {
        if (!dateStr) return "";
        const date = new Date(dateStr);
        if (isNaN(date)) return "";

        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    // Update preview saat tanggal berubah
    $("#tanggal_sewa, #tanggal_kembali").on("change", function() {
        const tanggalSewa = formatLongDate($("#tanggal_sewa").val());
        const tanggalKembali = formatLongDate($("#tanggal_kembali").val());

        $("#preview_tanggal").text(
            `Tanggal Sewa: ${tanggalSewa || '-'} | Tanggal Kembali: ${tanggalKembali || '-'}`
        );
    });
});
});


