<!-- Modal-->
<div class="modal fade" id="logbookModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('dashboard/logbook/store') ?>">
            <?= csrf_field() ?>

            <input type="hidden" name="type" id="logType">

            <input type="hidden" name="motor_id" id="motorId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logbook Motor</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_booking">ID Booking</label>
                        <Select name="id_booking" id="id_booking" class="form-control">
                            <?php foreach ($bookings as $booking): ?>
                                <option value="<?= $booking['id'] ?>"><?= $booking['id'] ?> - <?= $booking['username'] ?></option>
                            <?php endforeach; ?>
                        </Select>
                    </div>

                    <div class="form-group">
                        <label>Motor</label>
                        <select name="motor" id="motor-modal" class="form-control motor-select">
                            <option value="">Semua Motor</option>
                            <?php foreach ($motors as $motor): ?>
                                <option value="<?= $motor['id'] ?>" <?= request()->getGet('motor') == $motor['id'] ? 'selected' : '' ?>>
                                    <?= esc($motor['name']) ?> - <?= esc($motor['number_plate']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
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

<!-- end modal -->