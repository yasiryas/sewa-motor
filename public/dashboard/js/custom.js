
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

    const searchInput = document.getElementById("search_user");
    const userIdInput = document.getElementById("user_id");
    const resultsBox = document.getElementById("user_results");

    let timeout = null;

    searchInput.addEventListener("keyup", function () {
        const keyword = this.value.trim();

        if (keyword.length < 2) {
            resultsBox.style.display = "none";
            return;
        }

        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fetch(`${BASE_URL}/dashboard/user/search?q=${encodeURIComponent(keyword)}`)
    .then(res => res.json())
    .then(data => {
        if (!Array.isArray(data)) {
            console.error("Bukan array:", data);
            return;
        }

        resultsBox.innerHTML = "";
        data.forEach(user => {
            const item = document.createElement("a");
            item.href = "#";
            item.className = "list-group-item list-group-item-action";
            item.textContent = `${user.username} (${user.email})`;
            item.addEventListener("click", e => {
                e.preventDefault();
                searchInput.value = user.username;
                userIdInput.value = user.id;
                resultsBox.style.display = "none";
            });
            resultsBox.appendChild(item);
        });
        resultsBox.style.display = "block";
    })
    .catch(err => console.error("Error:", err));
        }, 300);
    });

    // klik di luar → sembunyikan dropdown
    document.addEventListener("click", function (e) {
        if (!resultsBox.contains(e.target) && e.target !== searchInput) {
            resultsBox.style.display = "none";
        }
    });

});


