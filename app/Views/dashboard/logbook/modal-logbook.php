<div class="modal fade" id="logbookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="post" action="<?= base_url('dashboard/logbook/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <input type="hidden" name="type" id="logType">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logbook Motor</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <!-- BOOKING (OPSIONAL) -->
                    <div class="form-group">
                        <label>Booking (Opsional)</label>
                        <select name="booking_id" class="form-control" id="select-booking">
                            <option value="">-- Tanpa Booking --</option>
                            <?php foreach ($bookings as $booking): ?>
                                <option value="<?= $booking['id'] ?>" <?= old('booking_id') == $booking['id'] ? 'selected' : '' ?> data-motor="<?= $booking['motor_id'] ?>">
                                    #<?= $booking['id'] ?> - <?= esc($booking['username']) ?> - <?= esc($booking['number_plate']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small id="errorBookingLogBook" class=""></small>
                    </div>

                    <!-- MOTOR -->
                    <div class="form-group">
                        <label>Motor <span class="text-danger">*</span></label>
                        <select name="motor_id" class="form-control motor-select" id="motor-modal" required>
                            <option value="">-- Pilih Motor --</option>
                            <?php foreach ($motors as $motor): ?>
                                <option value="<?= $motor['id'] ?>" <?= old('motor_id') == $motor['id'] ? 'selected' : '' ?>>
                                    <?= esc($motor['name']) ?> - <?= esc($motor['number_plate']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fuel_level">Fuel Level</label>
                        <select name="fuel" id="fuel" class="form-control" <?= old('fuel') == 'fuel' ? 'selected' : '' ?>>
                            <option>-- Pilih Fuel Level --</option>
                            <option value="full">Full</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <!-- Foto kondisi motor saat ini: -->
                    <div class="form-group">
                        <label for="photo">Foto Kondisi Motor</label>
                        <input type="file" class="photo-input form-control-file" accept="image/*" name="photo" accept="image/*" capture="environment">
                        <img src="#" alt="Preview Gambar" class="photo-preview img-fluid mt-2" style="max-width:200px; display:none;">
                    </div>

                    <!-- CATATAN -->
                    <div class="form-group">
                        <label>Catatan Kondisi</label>
                        <textarea name="notes" class="form-control" rows="3" id="notes"><?= old('notes') ?? ''; ?></textarea>
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