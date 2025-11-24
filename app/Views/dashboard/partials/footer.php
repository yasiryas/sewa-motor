 <!-- Toast Container -->
 <div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 9999;">
     <div style="position: fixed; top: 20px; right: 20px; min-width: 300px;">

         <?php if (session()->getFlashdata('success')): ?>
             <div class="toast bg-success text-white alert-success" data-delay="3000">
                 <div class="toast-header bg-success text-white">
                     <strong class="mr-auto">Sukses</strong>
                     <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                 </div>
                 <div class="toast-body">
                     <?= session()->getFlashdata('success'); ?>
                 </div>
             </div>
         <?php endif; ?>

         <?php if (session()->getFlashdata('error')): ?>
             <div class="toast bg-danger text-white alert-danger" data-delay="3000">
                 <div class="toast-header bg-danger text-white">
                     <strong class="mr-auto">Gagal</strong>
                     <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                 </div>
                 <div class="toast-body">
                     <?= session()->getFlashdata('error'); ?>
                 </div>
             </div>
         <?php endif; ?>

     </div>
 </div>

 <!-- open modal if error message -->
 <script>
     let openModal = "<?= session()->getFlashdata('modal'); ?>";
     const BASE_URL = "<?= rtrim(base_url(), '/'); ?>";
 </script>


 <!-- Footer -->
 <!-- <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; <?= date('Y'); ?></span>
         </div>
     </div>
 </footer> -->
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <a class="btn btn-warning text-white" href="<?= base_url('logout'); ?>">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <!-- jQuery (load sekali saja, paling atas sebelum plugin lain) -->
 <script src="<?= base_url('dashboard/vendor/jquery/jquery.min.js'); ?>"></script>

 <!-- Bootstrap core JavaScript-->
 <script src="<?= base_url('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

 <!-- Core plugin JavaScript-->
 <script src="<?= base_url('dashboard/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

 <!-- DataTables -->
 <script src="<?= base_url('dashboard/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
 <script src="<?= base_url('dashboard/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= base_url('dashboard/js/sb-admin-2.min.js'); ?>"></script>
 <script src="<?= base_url('dashboard/vendor/summernote/summernote-bs4.min.js'); ?>"></script>


 <!-- Page level plugins -->
 <script src="<?= base_url('dashboard/vendor/chart.js/Chart.min.js'); ?>"></script>


 <script src="<?= base_url('dashboard/vendor/datatables/dataTables.custom.js'); ?>"></script>
 <script src="<?= base_url('dashboard/js/custom.js'); ?>"></script>

 <!-- Page level custom scripts -->
 <script src="<?= base_url('dashboard/js/demo/chart-area-demo.js'); ?>"></script>
 <script src="<?= base_url('dashboard/js/demo/chart-pie-demo.js'); ?>"></script>

 </html>