<div class="modal fade" id="logbookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        $<?php $validation = session('validation'); ?>
        <form method="post" action="<?= base_url('dashboard/logbook/store') ?>" enctype="multipart/form-data">
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