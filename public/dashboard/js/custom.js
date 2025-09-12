$(document).ready(function () {
  //alert message
  $('.toast').toast('show');

  //modal open is error
  // let openModal = "<?= session()->getFlashdata('modal'); ?>";

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

});


