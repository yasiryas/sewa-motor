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
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    $('#formSendEmail').on('submit', function (e) {
        e.preventDefault();

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
                alertBox.html(`<div class="alert alert-success">${response.message}</div>`);
                form[0].reset();

                if (response.csrfName && response.csrfHash) {
                    csrfName = response.csrfName;
                    csrfHash = response.csrfHash;
                }
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

    // ===== Detail transaksi di modal =====
    $('.btn-detail-transaction').on('click', function () {
    let transactionId = $(this).data('id');

    // Reset tampilan modal
    $('#detailPhotoMotor').attr('src', '');
    $('#detailNamaMotor').text('Memuat...');
    $('#detailTanggalSewa').html('');
    $('#detailTanggalTransaksi').html('');
    $('#detailKeterangan').html('');
    $('#detailBukti').attr('src', '').hide();
    $('#downloadInvoiceBtn').hide();

    $('#detailModal').modal('show');

    $.ajax({
        url: BASE_URL + 'booking/detail-booking/' + transactionId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            let data = response.booking;

            // Isi data utama motor
            $('#detailPhotoMotor').attr('src', BASE_URL + 'uploads/motors/' + data.photo);
            $('#detailNamaMotor').text(`${data.motor_name} (${data.brand_name})`);

            // Hitung durasi sewa
            let start = new Date(data.rental_start_date);
            let end = new Date(data.rental_end_date);
            let diffDays = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;

            // Format tanggal
            $('#detailTanggalSewa').html(
                `<i class="bi bi-calendar-event text-primary"></i>
                <strong>${formatLongDate(data.rental_start_date)}</strong> -
                <strong>${formatLongDate(data.rental_end_date)}</strong>`
            );

            $('#detailTanggalTransaksi').html(
                `<i class="bi bi-clock-history text-secondary"></i>
                <small class="text-muted">Transaksi: ${formatLongDate(data.created_at)}</small>`
            );

            // Format Rupiah
            const formatRupiah = (num) => "Rp " + Number(num).toLocaleString("id-ID");

            // Badge status
            let statusBadge = '';
            if (data.status === 'pending') {
                statusBadge = `<span class="badge badge-danger p-2">
                    <i class="bi bi-hourglass-split"></i> Pending
                </span>`;
            } else if (data.status === 'complete') {
                statusBadge = `<span class="badge badge-primary p-2">
                    <i class="bi bi-check-circle"></i> Complete
                </span>`;
            } else if (data.status === 'on process') {
                statusBadge = `<span class="badge badge-info p-2">
                    <i class="bi bi-arrow-repeat"></i> Diproses
                </span>`;
            } else {
                statusBadge = `<span class="badge badge-secondary p-2">${data.status}</span>`;
            }

            // Nota Biaya
            let notaHTML = `
                <div class="border rounded p-3 bg-light mt-3">
                    <h6 class="font-weight-bold mb-3"><i class="bi bi-receipt"></i> Rincian Biaya</h6>
                    <table class="table table-sm mb-0">
                        <tr>
                            <td>Harga per Hari</td>
                            <td class="text-right">${formatRupiah(data.price_per_day)}</td>
                        </tr>
                        <tr>
                            <td>Lama Sewa</td>
                            <td class="text-right">${diffDays} Hari</td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td>Total Bayar</td>
                            <td class="text-right text-success">${formatRupiah(data.total_price)}</td>
                        </tr>
                    </table>
                </div>
            `;

            // Tampilkan status + nota
            $('#detailKeterangan').html(`
                <div class="mt-3">
                    <i class="bi bi-info-circle"></i> Status: ${statusBadge}
                </div>
                ${notaHTML}
            `);

            // Bukti pembayaran
            if (data.bukti) {
                $('#detailBukti')
                    .attr('src', BASE_URL + 'uploads/transactions/' + data.bukti)
                    .addClass('img-fluid mt-3 rounded shadow-sm')
                    .show();

                $('#detailKeterangan').append(`
                    <div class="mt-3">
                        <h6><i class="bi bi-image"></i> Bukti Pembayaran</h6>
                        <p class="text-muted small">Terima kasih, bukti pembayaran telah diupload.</p>
                    </div>
                `);
            } else {
                $('#detailBukti').hide();
                $('#detailKeterangan').append(`
                    <div class="mt-3 alert alert-warning py-2">
                        <i class="bi bi-exclamation-triangle"></i> Bukti pembayaran belum diupload.
                    </div>
                `);
            }

            // Tombol download invoice
            $('#downloadInvoiceBtn')
                .attr('href', BASE_URL + 'booking/invoice/' + data.id)
                .show();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('Terjadi kesalahan saat memuat detail transaksi.');
        }
    });
    });

    // ===== Metode pembayaran =====

    // // === TRANSFER BANK ===
    //  $('#btnTransfer').on('click', function() {
    //     $(this).addClass('active bg-primary text-white');
    //     $('#btnCOD').removeClass('active bg-primary text-white');
    //     $('#payment_method').val('transfer');
    //     $('#rekeningSection').removeClass('d-none').hide().fadeIn(200);
    //     $('#CODSection').fadeOut(200, function() { $(this).addClass('d-none'); });
    // });

    // // === COD ===
    // $('#btnCOD').on('click', function() {
    //     $(this).addClass('active bg-primary text-white');
    //     $('#btnTransfer').removeClass('active bg-primary text-white');
    //     $('#payment_method').val('cash');
    //     $('#CODSection').removeClass('d-none').hide().fadeIn(200);
    //     $('#rekeningSection').fadeOut(200, function () { $(this).addClass('d-none'); });
    //     $('#buktiPembayaran').addClass('d-none'); // sembunyikan bukti pembayaran jika COD
    // });

    // // === SETELAH REFRESH: tampilkan metode dari database ===
    // const selectedMethod = "<?= $booking['payment_method']; ?>";
    // if (selectedMethod === 'transfer') {
    //     $('#btnTransfer').addClass('active bg-primary text-white');
    //     $('#rekeningSection').removeClass('d-none');
    //     $('#payment_method').val('transfer'); // penting!
    // } else if (selectedMethod === 'cash') {
    //     $('#btnCOD').addClass('active bg-primary text-white');
    //     $('#CODSection').removeClass('d-none');
    //     $('#payment_method').val('cash'); // penting!
    //     $('#buktiPembayaran').addClass('d-none'); // sembunyikan bukti pembayaran jika COD
    // }

    // $('#btnCOD').on('click', function() {
    //     $(this).addClass('active');
    //     $('#btnTransfer').removeClass('active');
    //     $('#rekeningSection').fadeOut(200);
    //     $('#confirmCODModal').modal('show');
    // });

    function setPaymentMethod(method) {
    // Reset semua
    $('#btnTransfer, #btnCOD').removeClass('active bg-primary text-white');

    if (method === 'transfer') {
        $('#btnTransfer').addClass('active bg-primary text-white');
        $('#payment_method').val('transfer');

        // Tampilkan transfer sections
        $('#rekeningSection, #buktiPembayaran').removeClass('d-none').hide().fadeIn(200);

        // Sembunyikan COD
        $('#CODSection').fadeOut(200, function() {
            $(this).addClass('d-none');
        });

    } else if (method === 'cash') {
        $('#btnCOD').addClass('active bg-primary text-white');
        $('#payment_method').val('cash');

        // Tampilkan COD
        $('#CODSection').removeClass('d-none').hide().fadeIn(200);

        // Sembunyikan transfer sections
        $('#rekeningSection, #buktiPembayaran').fadeOut(200, function() {
            $(this).addClass('d-none');
        });
    }
}

// Event handlers
$('#btnTransfer').on('click', function() {
    setPaymentMethod('transfer');
});

$('#btnCOD').on('click', function() {
    setPaymentMethod('cash');
});

// Initialize berdasarkan data dari database
$(document).ready(function() {
    const selectedMethod = "<?= $booking['payment_method']; ?>";

    if (selectedMethod === 'transfer') {
        setPaymentMethod('transfer');
    } else if (selectedMethod === 'cash') {
        setPaymentMethod('cash');
    } else {
        // Default ke transfer jika tidak ada metode
        setPaymentMethod('transfer');
    }
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
});