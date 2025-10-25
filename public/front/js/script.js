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

        // Handle form submission with AJAX
        let csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';

        $('#formSendEmail').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            // Get form data
            let form = $(this);
            let btn = $('#btnSendEmail');
            let alertBox = $('.alert-box');

            let formData = form.serializeArray();
            formData.push({ name: csrfName, value: csrfHash });

            btn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm"></span> Mengirim...`);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: $.param(formData),
                dataType: 'json',
                success: function (response) {
                    // Show success message
                    alertBox.html(`<div class="alert alert-success">${response.message}</div>`);
                    form[0].reset(); // Reset form fields

                    console.log(response);

                    if (response.csrfName && response.csrfHash) {
                        csrfName = response.csrfName;
                        csrfHash = response.csrfHash;
                    }
                },
                error: function (xhr) {
                    // Show error message
                    let errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alertBox.html(`<div class="alert alert-danger">${errorMsg}</div>`);
                },
                complete: function () {
                    btn.prop('disabled', false).html('Kirim Penawaran!');
                }
            });
        });

});


