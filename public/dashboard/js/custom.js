
$(document).ready(function () {
  //alert message
  $('.toast').toast('show');

    if (openModal === 'addBrandModal') {
      $('#addBrandModal').modal('show');
  }

  if (openModal === 'updateBrandModal') {
      $('#editBrandModal').modal('show');
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

});


