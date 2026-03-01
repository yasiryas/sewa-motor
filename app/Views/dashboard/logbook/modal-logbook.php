<!-- modal check-in check-out  -->
<div class="modal fade" id="logbookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <?php $validation = session('validation'); ?>
        <form method="post" action="<?= base_url('dashboard/logbook/store') ?>" enctype="multipart/form-data" id="logbookForm">
            <?= csrf_field() ?>

            <input type="hidden" name="type" id="logType" value="<?= old('type'); ?>">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logbook Motor</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <!-- BOOKING (OPSIONAL) -->
                    <div class="form-group">
                        <label>Booking (Opsional)</label>
                        <select name="booking_id" class="form-control <?= session('errors.booking_id') ? 'is-invalid' : '' ?>" id="select-booking">
                            <option value="">-- Tanpa Booking --</option>
                            <?php foreach ($bookings as $booking): ?>
                                <option value="<?= $booking['id'] ?>" <?= old('booking_id') == $booking['id'] ? 'selected' : '' ?> data-motor="<?= $booking['motor_id'] ?>">
                                    #<?= $booking['id'] ?> - <?= esc($booking['username']) ?> - <?= esc($booking['number_plate']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <!-- MOTOR -->
                    <div class="form-group">
                        <input type="hidden" name="motor_id" id="motor_id_hidden" value="<?= old('motor_id'); ?>">
                        <label>Motor <span class="text-danger">*</span></label>
                        <select name="motor_id" class="form-control motor-select <?= session('errors.motor_id') ? 'is-invalid' : '' ?>" id="motor-modal">
                            <option value="">-- Pilih Motor --</option>
                            <?php foreach ($motors as $motor): ?>
                                <option value="<?= $motor['id'] ?>" <?= old('motor_id') == $motor['id'] ? 'selected' : '' ?>>
                                    <?= esc($motor['name']) ?> - <?= esc($motor['number_plate']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-danger"><?= session('errors.motor_id' ?? '') ?></small>
                    </div>



                    <div class="form-group">
                        <label for="fuel_level">Fuel Level</label>
                        <select name="fuel" id="fuel" class="form-control <?= session('errors.fuel') ? 'is-invalid' : '' ?>">
                            <option value="">-- Pilih Fuel Level --</option>
                            <option value="full" <?= old('fuel') == 'full' ? 'selected' : '' ?>>Full</option>
                            <option value="medium" <?= old('fuel') == 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="low" <?= old('fuel') == 'low' ? 'selected' : '' ?>>Low</option>
                        </select>
                        <small class="text-danger"><?= session('errors.fuel' ?? '') ?></small>
                    </div>

                    <!-- Foto kondisi motor saat ini: -->
                    <div class="form-group">
                        <label for="photo">Foto Kondisi Motor</label>
                        <input type="file" class="photo-input form-control-file" accept="image/*" name="photo" accept="image/*" capture="environment">
                        <img src="#" alt="Preview Gambar" class="photo-preview img-fluid mt-2" style="max-width:200px; display:none;">
                        <small class="text-danger"><?= session('errors.photo' ?? '') ?></small>
                    </div>

                    <!-- CATATAN -->
                    <div class="form-group">
                        <label>Catatan Kondisi</label>
                        <textarea name="notes" class="form-control" rows="3" id="notes"><?= old('notes') ?? ''; ?></textarea>
                        <small class="text-danger"><?= session('errors.notes' ?? '') ?></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal detail -->
<div class="modal fade" id="detailLogbookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Logbook</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail-logbook-content">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="editLogbookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="post" action="<?= base_url('dashboard/logbook/update') ?>" enctype="multipart/form-data" id="editLogbookForm">
            <?= csrf_field() ?>

            <input type="hidden" name="id" id="edit-logbook-id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Logbook</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Motor</label>
                        <select name="motor_id" class="form-control" id="edit-motor" disabled>
                            <option value="">-- Pilih Motor --</option>
                            <?php foreach ($motors as $motor): ?>
                                <option value="<?= $motor['id'] ?>">
                                    <?= esc($motor['name']) ?> - <?= esc($motor['number_plate']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="type" class="form-control" id="edit-type" disabled>
                            <option value="check-in">Check In</option>
                            <option value="check-out">Check Out</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fuel_level">Fuel Level</label>
                        <select name="fuel" id="edit-fuel" class="form-control">
                            <option value="">-- Pilih Fuel Level --</option>
                            <option value="full">Full</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="photo">Foto Kondisi Motor (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="file" class="form-control-file" accept="image/*" name="photo">
                        <img src="#" alt="Preview Foto" id="edit-photo-preview" class="img-fluid mt-2" style="max-width:200px; display:none;">
                    </div>

                    <div class="form-group">
                        <label>Catatan Kondisi</label>
                        <textarea name="notes" class="form-control" rows="3" id="edit-notes"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal delete -->
<div class="modal fade" id="deleteLogbookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Logbook</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data logbook ini?</p>
                <input type="hidden" id="delete-logbook-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-logbook">Hapus</button>
            </div>
        </div>
    </div>
</div>