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


        //ajax search product (product page)
         // Fungsi pencarian dengan AJAX
    $('#searchProductAll').on('keyup', function() {
        let query = $(this).val().trim();
        let productContainer = $('#productContainer');

        // Tampilkan loading spinner
        productContainer.html(`
            <div class="col-12 text-center my-5">
                <div class="spinner-border text-warning" role="status"></div>
                <p class="mt-2">Mencari produk...</p>
            </div>
        `);

        // Kirim request AJAX
        $.ajax({
            url: BASE_URL + 'product/search',
            type: 'GET',
            data: { keyword: query },
            dataType: 'json',
            success: function(response) {
                if (!response || response.length === 0) {
                    productContainer.html('<div class="col-12 text-center my-5"><p>Tidak ada produk ditemukan.</p></div>');
                    return;
                }

                let html = '';
                $.each(response, function(i, motor) {
                    html += `
                        <div class="col-md-3 mb-4 d-flex align-items-stretch">
                            <div class="card h-100 shadow">
                                <img src="${ BASE_URL + 'uploads/motors/' + motor.photo}"
                                     class="card-img-top" alt="${motor.name}">
                                <div class="card-body d-flex flex-column">
                                    <div class="mt-auto">
                                    <h5 class="card-title">${motor.name}</h5>
                                    <p class="card-text mb-4">Rp. ${Number(motor.price_per_day).toLocaleString('id-ID')} / Hari</p>
                                    <a href="${ BASE_URL + 'produk/' + motor.id}"
                                       class="btn btn-warning btn-sm text-white px-4">Booking</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                productContainer.hide().html(html).fadeIn(300);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                productContainer.html('<div class="col-12 text-center my-5"><p>Terjadi kesalahan saat mencari produk.</p></div>');
            }
        });
    });

        //filter by brand (product page)
        $('.brand-filter').on('click', function() {
            let brandId = $(this).data('brand-id');
            let productContainer = $('#productContainer');
            // Tampilkan loading spinner
            productContainer.html(`
                <div class="col-12 text-center my-5">
                    <div class="spinner-border text-warning" role="status"></div>
                    <p class="mt-2">Memuat produk...</p>
                </div>
            `);
            // Kirim request AJAX
            $.ajax({
                url: BASE_URL + 'product/filterByBrand/' + brandId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (!response || response.length === 0) {
                        productContainer.html('<div class="col-12 text-center my-5"><p>Tidak ada produk ditemukan untuk merek ini.</p></div>');
                        return;
                    }

                    let html = '';
                    $.each(response, function(i, motor) {
                        html += `
                            <div class="col-md-3 mb-4 d-flex align-items-stretch">
                                <div class="card h-100 shadow">
                                    <img src="${ BASE_URL + 'uploads/motors/' + motor.photo}"
                                         class="card-img-top" alt="${motor.name}">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mt-auto">
                                        <h5 class="card-title">${motor.name}</h5>
                                        <p class="card-text mb-4">Rp. ${Number(motor.price_per_day).toLocaleString('id-ID')} / Hari</p>
                                        <a href="${ BASE_URL + 'produk/' + motor.id}"
                                           class="btn btn-warning btn-sm text-white px-4">Booking</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    productContainer.hide().html(html).fadeIn(300);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    productContainer.html('<div class="col-12 text-center my-5"><p>Terjadi kesalahan saat memuat produk.</p></div>');

                }
            });
        });
});


