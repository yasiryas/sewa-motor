$(document).ready(function () {

    // ===== Navbar scroll effect =====
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 50) {
            $(".navbar").addClass("scrolled");
        } else {
            $(".navbar").removeClass("scrolled");
        }
    });

    // Jalankan juga saat halaman dimuat ulang
    setTimeout(function() {
    if ($(window).scrollTop() > 50) {
        $(".navbar").addClass("scrolled");
    } else {
        $(".navbar").removeClass("scrolled");
    }
}, 100);

    // ===== Toggle mobile navbar =====
    $('#buttonNavMobile').on('click', function () {
        $('#containerNavbar').toggleClass('clicked');
    });

    // ===== Fungsi ubah format tanggal ke "1 September 2025" =====
    function formatLongDate(dateStr) {
        if (!dateStr) return "";
        const date = new Date(dateStr);
        if (isNaN(date)) return "";

        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    // ===== Preview tanggal sewa saat berubah =====
    $("#tanggal_sewa, #tanggal_kembali").on("change", function () {
        const tanggalSewa = $("#tanggal_sewa").val() && formatLongDate($("#tanggal_sewa").val());
        const tanggalKembali = $("#tanggal_kembali").val() && formatLongDate($("#tanggal_kembali").val());

        $("#preview_tanggal").text(
            `Tanggal Sewa: ${tanggalSewa || '-'} | Tanggal Kembali: ${tanggalKembali || '-'}`
        );
    });

    // ===== Handle form kirim email dengan AJAX =====
    // Token CSRF ikut terkirim via hidden input csrf_field() di dalam form
    $('#formSendEmail').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let btn = $('#btnSendEmail');
        let alertBox = $('.alert-box');
        let formData = form.serializeArray();

        btn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm"></span> Mengirim...`);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function (response) {
                alertBox.html(`<div class="alert alert-success">${response.message}</div>`);
                form[0].reset();
            },
            error: function (xhr) {
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

    // ===== AJAX Search Produk =====
    $('#btnSearchProduct').on('click', function () {
        $('#searchProductAll').trigger('keyup');
    });

    $('#searchProductAll').on('keyup', function () {
        let query = $(this).val().trim();
        let productContainer = $('#productContainer');

        productContainer.html(`
            <div class="col-12 text-center my-5">
                <div class="spinner-border text-warning" role="status"></div>
                <p class="mt-2">Mencari produk...</p>
            </div>
        `);

        $.ajax({
            url: BASE_URL + 'product/search',
            type: 'GET',
            data: { keyword: query },
            dataType: 'json',
            success: function (response) {
                if (!response || response.length === 0) {
                    productContainer.html('<div class="col-12 text-center my-5"><p>Tidak ada produk ditemukan.</p></div>');
                    return;
                }

                let html = '';
                $.each(response, function (i, motor) {
                    html += `
                        <div class="col-md-3 mb-4 d-flex align-items-stretch">
                            <div class="card h-100 shadow">
                                <img src="${BASE_URL + 'uploads/motors/' + motor.photo}"
                                     class="card-img-top" alt="${motor.name}">
                                <div class="card-body d-flex flex-column">
                                    <div class="mt-auto">
                                        <h5 class="card-title">${motor.name}</h5>
                                        <p class="card-text mb-4">Rp. ${Number(motor.price_per_day).toLocaleString('id-ID')} / Hari</p>
                                        <a href="${BASE_URL + 'produk/' + motor.id}"
                                           class="btn btn-warning btn-sm text-white px-4">Booking</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                productContainer.hide().html(html).fadeIn(300);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                productContainer.html('<div class="col-12 text-center my-5"><p>Terjadi kesalahan saat mencari produk.</p></div>');
            }
        });
    });

    // ===== Filter produk berdasarkan merek =====
    $('.brand-filter').on('click', function () {
        let brandId = $(this).data('brand-id');
        let productContainer = $('#productContainer');

        productContainer.html(`
            <div class="col-12 text-center my-5">
                <div class="spinner-border text-warning" role="status"></div>
                <p class="mt-2">Memuat produk...</p>
            </div>
        `);

        $.ajax({
            url: BASE_URL + 'product/filterByBrand/' + brandId,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (!response || response.length === 0) {
                    productContainer.html('<div class="col-12 text-center my-5"><p>Tidak ada produk ditemukan untuk merek ini.</p></div>');
                    return;
                }

                let html = '';
                $.each(response, function (i, motor) {
                    html += `
                        <div class="col-md-3 mb-4 d-flex align-items-stretch">
                            <div class="card h-100 shadow">
                                <img src="${BASE_URL + 'uploads/motors/' + motor.photo}"
                                     class="card-img-top" alt="${motor.name}">
                                <div class="card-body d-flex flex-column">
                                    <div class="mt-auto">
                                        <h5 class="card-title">${motor.name}</h5>
                                        <p class="card-text mb-4">Rp. ${Number(motor.price_per_day).toLocaleString('id-ID')} / Hari</p>
                                        <a href="${BASE_URL + 'produk/' + motor.id}"
                                           class="btn btn-warning btn-sm text-white px-4">Booking</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                productContainer.hide().html(html).fadeIn(300);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                productContainer.html('<div class="col-12 text-center my-5"><p>Terjadi kesalahan saat memuat produk.</p></div>');
            }
        });
    });

    // ===== Tabel pesanan user =====
    $('#tableUserBookings').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari pesanan...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "&laquo;",
                next: "&raquo;"
            }
        }
    });

    // ===== Metode pembayaran =====
function setPaymentMethod(method) {
        // Reset
        $('#btnTransfer, #btnCOD').removeClass('active bg-primary text-white');

        if (method === 'transfer') {
            $('#btnTransfer').addClass('active bg-primary text-white');
            $('#payment_method').val('transfer');

            $('#rekeningSection, #buktiPembayaran').removeClass('d-none');
            $('#CODSection').addClass('d-none');

        } else if (method === 'cash') {
            $('#btnCOD').addClass('active bg-primary text-white');
            $('#payment_method').val('cash');

            $('#CODSection').removeClass('d-none');
            $('#rekeningSection, #buktiPembayaran').addClass('d-none');
        }
    }

    // Event
    $('#btnTransfer').on('click', function() {
        setPaymentMethod('transfer');
    });

    $('#btnCOD').on('click', function() {
        setPaymentMethod('cash');
    });

    // ===== Preview gambar KTP saat upload =====

    // preview gambar motor saat tambah dan edit
    $(document).on("change", ".photo-input", function () {
        const preview = $(this).siblings(".photo-preview");

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.attr("src", e.target.result).show();
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.hide().attr("src", "#");
        }
    });

    function validateImageInput(inputId, maxSizeMB = 1) {
        const input = document.getElementById(inputId);
        const errorMsg = document.getElementById('error_' + inputId);

        // Input tidak ada di halaman ini (script.js dipakai banyak halaman)
        if (!input || !errorMsg) return;

        input.addEventListener('change', function () {

            const file = this.files[0];
            errorMsg.classList.add('d-none');
            errorMsg.textContent = '';

            if (!file) return;

            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = maxSizeMB * 1024 * 1024; // convert ke byte

            // Cek tipe file
            if (!allowedTypes.includes(file.type)) {
                errorMsg.textContent = "Tipe file tidak valid. Hanya .jpg, .jpeg, .png yang diizinkan.";
                errorMsg.classList.remove('d-none');
                this.value = "";
                return;
            }

            // Cek ukuran file
            if (file.size > maxSize) {
                errorMsg.textContent = "Ukuran file maksimal " + maxSizeMB + "MB";
                errorMsg.classList.remove('d-none');
                this.value = "";
                return;
            }
        });
    }

    // Panggil validasi untuk dua input
    validateImageInput('identity_photo', 1);
    validateImageInput('payment_proof', 1);

});
