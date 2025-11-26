
$(document).ready(function () {
  //alert message
  $('.toast').toast('show');

  // jika ada error maka modal akan terbuka
  if (openModal === 'addBrandModal') {
      $('#addBrandModal').modal('show');
  }

  if (openModal === 'updateBrandModal') {
      $('#editBrandModal').modal('show');
  }

  if (openModal === 'addTypeModal') {
      $('#addTypeModal').modal('show');
  }

  if (openModal === 'editTypeModal') {
      $('#editTypeModal').modal('show');
  }

  if (openModal === 'addMotorModal') {
      $('#addMotorModal').modal('show');
  }

  if (openModal === 'editMotorModal') {
      $('#editMotorModal').modal('show');
  }
  if (openModal === 'addUserModal') {
      $('#addUserModal').modal('show');
  }

  if (openModal === 'resetPasswordUserModal') {
      $('#resetPasswordUserModal').modal('show');
  }

  if (openModal === 'addBookingModal') {
    $('#addBookingModal').modal('show');

  let oldMotorId = $('#motor_id').val();
        if (oldMotorId) {
            $(".select-motor").each(function () {
                if ($(this).data("id-motor") == oldMotorId) {
                    $(this).addClass("active");
                } else {
                    $(this).removeClass("active");
                }
            });
        }
  }

  //modal add brand
  $('#addBrandModal').on('shown.bs.modal', function () {
    $('#brand_name_add').trigger('focus');
  });

  //modal delete brand
  $('.btn-delete-brand-modal').on('click', function () {
    let id_delete = $(this).data('id-delete');
    let brand_delete = $(this).data('brand-delete');

    $('#brand_id_delete').val(id_delete);
    $('#brand_name_delete').text(brand_delete);
  });

  // modal edit brand
  $('.btn-edit-brand-modal').on('click', function () {
    $('#editBrandModal').modal('show');
    let id_update = $(this).data('id-update');
    let brand_update = $(this).data('brand-update');

    $('#update_brand_id').val(id_update);
    $('#update_brand_name').val(brand_update);
  });

  $('#editBrandModal').on('shown.bs.modal', function () {
    $('#update_brand_name').trigger('focus');
  });

  // modal type
  $('.btn-edit-type-modal').on('click', function () {
    $('#editTypeModal').modal('show');

    let id_update = $(this).data('id-update');
    let type_update = $(this).data('type-update');
    // console.log(type_update, id_update);
    $('#update_type_id').val(id_update);
    $('#update_type_name').val(type_update);
  });

  $('#editTypeModal').on('shown.bs.modal', function () {
    $('#update_type_name').trigger('focus');
  });

  // btn delete modal type
   $('.btn-delete-type-modal').on('click', function () {
    $('#deleteTypeModal').modal('show')

    let id_delete = $(this).data('id-delete');
    let type_delete = $(this).data('type-delete');

    $('#type_id_delete').val(id_delete);
    $('#type_name_delete').text(type_delete);
   });

  // modal motor
  $('.btn-edit-motor-modal').on('click', function () {
    $('#editMotorModal').modal('show');

    let id_update_motor = $(this).data('id-update-motor');
    let update_name_motor = $(this).data('update-name-motor');
    let update_plate_motor = $(this).data('update-plate-motor');
    let update_id_brand_motor = $(this).data('update-id-brand-motor');
    let update_id_type_motor = $(this).data('update-id-type-motor');
    let update_price_motor = $(this).data('update-price-motor');
    let update_status_motor = $(this).data('update-status-motor');
    let update_photo_motor = $(this).data('update-photo-motor');
    // console.log(type_update, id_update);
    $('#update_id_motor').val(id_update_motor);
    $('#update_name_motor').val(update_name_motor);
    $('#update_plate_motor').val(update_plate_motor);
    $('#update_brand_motor').val(update_id_brand_motor).trigger('change');
    $('#update_type_motor').val(update_id_type_motor).trigger('change');
    $('#update_price_motor').val(update_price_motor);
    $('#update_status_motor').val(update_status_motor).trigger('change');
    $('#update_photo_motor').val(update_photo_motor);
  });

  $('#editMotorModal').on('shown.bs.modal', function () {
    $('#update_name_motor').trigger('focus');
  });

  // btn delete modal type
   $('.btn-delete-motor-modal').on('click', function () {
    $('#deleteMotorModal').modal('show')

    let id_delete_motor = $(this).data('id-delete-motor');
    let delete_motor = $(this).data('motor-delete');

    $('#motor_id_delete').val(id_delete_motor);
    $('#motor_name_delete').text(delete_motor);
   });

    //format rupiah
    function formatRupiah(angka) {
    if (!angka) return "Rp 0";
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0
    }).format(angka);
}


  //show password toggle
  $('.toggle-password').click(function() {
      let input = $($(this).data('target'));
      let icon = $(this).find('i');

      if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
  });

  // modal delete user
  $('.btn-delete-user-modal').on('click', function () {
    $('#deleteUserModal').modal('show')

    let id_delete_user = $(this).data('delete-id-user');
    let name_delete_user = $(this).data('delete-name-user');
    // let type_delete = $(this).data('type-delete');
    $('#user_id_delete').val(id_delete_user);
    $('#user_name_delete').text(name_delete_user);
  });

  // modal reset password user
  $('.btn-reset-password-user-modal').on('click', function () {
    $('#resetPasswordUserModal').modal('show')

    let id_reset_password_user = $(this).data('id-reset-password-user');
    let name_reset_password_user = $(this).data('name-reset-password-user');

    $('#id_reset_password_user').val(id_reset_password_user);
    $('#name_reset_password_user').text(name_reset_password_user);
  });

// search user for booking
    // const searchInput = document.getElementById("search_user");
    // const userIdInput = document.getElementById("user_id");
    // const resultsBox = document.getElementById("user_results");

    // let timeout = null;

    // searchInput.addEventListener("keyup", function () {
    //     const keyword = this.value.trim();

    //     if (keyword.length < 2) {
    //         resultsBox.style.display = "none";
    //         return;
    //     }

    //     clearTimeout(timeout);
    //     timeout = setTimeout(() => {
    //         fetch(`${BASE_URL}/dashboard/user/search?q=${encodeURIComponent(keyword)}`)
    // .then(res => res.json())
    // .then(data => {
    //     if (!Array.isArray(data)) {
    //         console.error("Bukan array:", data);
    //         return;
    //     }

    //     resultsBox.innerHTML = "";
    //     data.forEach(user => {
    //         const item = document.createElement("a");
    //         item.href = "#";
    //         item.className = "list-group-item list-group-item-action";
    //         item.textContent = `${user.username} (${user.email})`;
    //         item.addEventListener("click", e => {
    //             e.preventDefault();
    //             searchInput.value = user.username;
    //             userIdInput.value = user.id;
    //             resultsBox.style.display = "none";
    //         });
    //         resultsBox.appendChild(item);
    //     });
    //     resultsBox.style.display = "block";
    // })
    // .catch(err => console.error("Error:", err));
    //     }, 300);
    // });

    // // klik di luar → sembunyikan dropdown
    // document.addEventListener("click", function (e) {
    //     if (!resultsBox.contains(e.target) && e.target !== searchInput) {
    //         resultsBox.style.display = "none";
    //     }
  // });

  // search user for booking
$(function () {
    let timeout = null;

    $(document).on("keyup", "#search_user", function () {
        const keyword = $(this).val().trim();
        const $resultsBox = $("#user_results");
        const $userIdInput = $("#user_id");

        if (keyword.length < 2) {
            $resultsBox.hide();
            return;
        }

        clearTimeout(timeout);
        timeout = setTimeout(() => {
            $.getJSON(`${BASE_URL}/dashboard/user/search`, { q: keyword })
                .done(function (data) {
                    if (!Array.isArray(data)) {
                        console.error("Bukan array:", data);
                        return;
                    }

                    $resultsBox.empty();
                    $.each(data, function (_, user) {
                        const $item = $("<a>")
                            .attr("href", "#")
                            .addClass("list-group-item list-group-item-action")
                            .text(`${user.username} (${user.email})`)
                            .on("click", function (e) {
                                e.preventDefault();
                                $("#search_user").val(user.username);
                                $userIdInput.val(user.id);
                                $resultsBox.hide();
                            });
                        $resultsBox.append($item);
                    });
                    $resultsBox.show();
                })
                .fail(function (err) {
                    console.error("Error:", err);
                });
        }, 300);
    });

    // klik di luar → sembunyikan dropdown
    $(document).on("click", function (e) {
        if (!$(e.target).closest("#user_results, #search_user").length) {
            $("#user_results").hide();
        }
    });
});


// Swiper init
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 3,
    spaceBetween: 15,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: { slidesPerView: 1 },
      576: { slidesPerView: 2 },
      992: { slidesPerView: 3 }
    }
  });

  // Klik pilih motor
  document.querySelectorAll(".motor-card").forEach(card => {
    card.addEventListener("click", function() {
      document.querySelectorAll(".motor-card").forEach(c => c.classList.remove("active"));
      this.classList.add("active");
      document.getElementById("selected_motor_id").value = this.dataset.id;
    });
  });

  $(document).on('click', '.select-motor', function () {
    $('.select-motor').removeClass('active');
    $(this).addClass('active');

    // optional kalau ada hidden input untuk form
    let motorId = $(this).data('id-motor');
    $('#selected_motor_id').val(motorId);
});

  //set value motor_id saat form disubmit
  $(document).on("click", ".select-motor", function () {
    let motorId = $(this).data("id-motor");
        // set ke hidden input
    $("#motor_id").val(motorId);
  });

  // isi data hapus booking
  $('.btn-delete-booking-modal').on('click', function () {
    let id_delete_booking     = $(this).data('delete-id-booking');
    let user_delete_booking   = $(this).data('delete-user-booking');
    let motor_delete_booking  = $(this).data('delete-motor-booking');
    let start_delete_booking  = $(this).data('delete-start-date-booking');
    let end_delete_booking    = $(this).data('delete-end-date-booking');
    let total_delete_booking  = $(this).data('delete-total-price-booking');
    let status_delete_booking = $(this).data('delete-status-booking');

    // Set nilai ke input/td
    $('#delete_booking_id').val(id_delete_booking);
    $('#delete_booking_user').text(user_delete_booking);
    $('#delete_booking_motor').text(motor_delete_booking);
    $('#delete_booking_start_date').text(start_delete_booking);
    $('#delete_booking_end_date').text(end_delete_booking);
    $('#delete_booking_total_price').text(total_delete_booking);
    $('#delete_booking_status').text(status_delete_booking);

    // buka modal
    $('#deleteBookingAdminModal').modal('show');
    // console.log("Klik");
  });

  //ketika tanggal mulai atau tanggal akhir diubah tampilkan motor yang tersedia
  $('#rental_start_date, #rental_end_date').on('change', function () {
    let start = $('#rental_start_date').val();
    let end   = $('#rental_end_date').val();

    if (start && end) {
        $.getJSON(`/dashboard/booking/getAvailableMotorsBooking?start=${start}&end=${end}`, function(data) {

            let container = $('.swiper-wrapper');
            container.empty();

            if (!data || data.length === 0) {
                container.append('<p class="text-center">Tidak ada motor tersedia</p>');
                return;
            }

            data.forEach(motor => {
                container.append(`
                    <div class="swiper-slide">
                        <div class="select-motor card motor-card h-100 flex-column d-flex justify-content-between"
                             data-id-motor="${motor.id}"
                             data-name-motor="${motor.name}"
                             data-price-motor="${motor.price_per_day}">
                            <img src="/uploads/motors/${motor.photo}" class="card-img-top" style="height:180px;object-fit:cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title"><b>${motor.name}</b></h5>
                                <p>${motor.number_plate}</p>
                                <p>Rp ${new Intl.NumberFormat('id-ID').format(motor.price_per_day)}<br>/hari</p>
                            </div>
                        </div>
                    </div>
                `);
            });

            swiper.update();
        });
    }
  });

  //serarch motor booking
  function fetchMotors(start, end, keyword = '') {
    $.getJSON(`/dashboard/booking/getAvailableMotorsBooking?start=${start}&end=${end}&q=${keyword}`, function(data) {
        let container = $('.swiper-wrapper');
        container.empty();

        if (data.length === 0) {
            container.append('<p class="text-center">Tidak ada motor tersedia</p>');
            swiper.update();
            return;
        }

        data.forEach(motor => {
            container.append(`
                <div class="swiper-slide">
                    <div class="select-motor card motor-card h-100"
                         data-id-motor="${motor.id}">
                        <img src="/uploads/motors/${motor.photo}" class="card-img-top" style="height:180px;object-fit:cover;">
                        <div class="card-body text-center">
                            <h6 class="card-title"><b>${motor.name}</b></h6>
                            <p>Rp ${new Intl.NumberFormat('id-ID').format(motor.price_per_day)} /hari</p>
                        </div>
                    </div>
                </div>
            `);
        });

        swiper.update();
    });
}

// Trigger saat pilih tanggal
$('#rental_start_date, #rental_end_date').on('change', function () {
    let start = $('#rental_start_date').val();
    let end   = $('#rental_end_date').val();
    if (start && end) {
        fetchMotors(start, end);
    }
});

// Trigger saat user ketik di search
$('#searchMotor').on('keyup', function () {
    let start   = $('#rental_start_date').val();
    let end     = $('#rental_end_date').val();
    let keyword = $(this).val();
    if (start && end) {
        fetchMotors(start, end, keyword);
    }
});

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

    //detail transaksi pada tombol detail transaksi halaman booking
    $(document).on("click", ".btn-detail-transaction", function () {
    let id = $(this).data("id");

        $.ajax({
        url: BASE_URL + "/dashboard/booking/detail/" + id,
        type: "GET",
        dataType: "json",
        success: function (res) {
            if (res.error) {
                alert(res.error);
                return;
            }

           // User
            $("#detail_username").text(res.username ?? "-");
            $("#detail_email").text(res.email ?? "-");

            // Motor
            $("#detail_motor_name").text(res.motor_name ?? "-");
            $("#detail_number_plate").text(res.number_plate ?? "-");
            $("#detail_price_per_day").text(formatRupiah(res.price_per_day ?? "0"));

            //brand and type
            $("#detail_brand").text(res.brand_name ?? "-");
            $("#detail_type").text(res.type_name ?? "-");

            // Booking
            $("#detail_start_date").text(res.rental_start_date ?? "-");
            $("#detail_end_date").text(res.rental_end_date ?? "-");
            $("#detail_total_price").text(formatRupiah(res.total_price ?? "0"));

            // Payment
            $("#detail_payment_amount").text(res.amount ?? "0");
            $("#detail_payment_status").text(res.payment_status ?? "Belum ada");
            $("#detail_payment_method").text(res.payment_method ?? "-");

            if (res.payment_proof) {
                $("#detail_payment_proof").attr("src",BASE_URL +  "/uploads/payments/" + res.payment_proof);
                $("#detail_payment_proof_text").text(""); // hapus teks "belum ada"
            } else {
                $("#detail_payment_proof").css("display", "none");
                $("#detail_payment_proof_text").text("Belum ada bukti pembayaran");
            }

            if (res.identity_photo) {
                $("#identity_user_photo").attr("src", BASE_URL + "/uploads/identitas/" + res.identity_photo);
            } else {
                $("#identity_user_photo").css("display", "none");
                $("#identity_user_photo_text").text("Belum ada foto identitas");
            }

            // Booking status
            $("#detail_booking_status").text(res.status ?? "-");

            // Add Form Acc And Reject
            $("#formAccPayment").attr("action", BASE_URL + "/dashboard/booking/updateStatus/" + id);
            $("#formRejPayment").attr("action", BASE_URL + "/dashboard/booking/updateStatus/" + id);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Gagal mengambil data transaksi");
        }
    });

    });

    //setting faq
    $('.btn-edit-faq-modal').on('click', function () {
        $('#editFaqModal').modal('show');
        let id_update_faq = $(this).data('update-id-faq');
        let question_update_faq = $(this).data('update-question-faq');
        let answer_update_faq = $(this).data('update-answer-faq');

        $('#update_faq_id').val(id_update_faq);
        $('#update_faq_question').val(question_update_faq);
        $('#update_faq_answer').val(answer_update_faq);

    });

    //delete faq
    $('.btn-delete-faq-modal').on('click', function () {
        let id_delete_faq = $(this).data('delete-id-faq');
        let question_delete_faq = $(this).data('delete-question-faq'); // singular: question, bukan questions

        $('#faq_id_delete').val(id_delete_faq);
        $('#faq_delete').text(question_delete_faq);

        $('#deleteFaqModal').modal('show');
    });

    $('.description').summernote({
        height: 200,
        placeholder: 'Masukkan deskripsi motor di sini...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });



    //report booking
     // INIT DATATABLE
    let table = $('#bookingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: BASE_URL + "/dashboard/get-bookings",
            type: "POST",
            data: function (d) {
                d.start_date = $('#start_date').val();
                d.end_date   = $('#end_date').val();
            }
        }
    });

    // AUTO RELOAD SAAT TANGGAL DIUBAH
    $('#start_date, #end_date').on('change', function () {
        table.ajax.reload();
    });

});


