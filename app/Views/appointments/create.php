<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<h1>New Appointment</h1>

<?php if (!empty($error)): ?>
    <div class="alert error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

    <div class="form-group">
      <?php if (Auth::role() === 'doctor'): ?>
        <input type="hidden" name="doctor_id" value="<?= htmlspecialchars(Auth::user()['id'], ENT_QUOTES, 'UTF-8'); ?>">
      <?php else: ?>
        <label>Doctor</label>
          <select id="doctor_id" name="doctor_id" required>
              <option value="" disabled selected>-- Select Doctor --</option>
              <?php foreach ($doctors as $doctor): ?>
                  <option value="<?= htmlspecialchars($doctor['id'], ENT_QUOTES, 'UTF-8'); ?>"
                      <?= (isset($doctor_id) && $doctor_id == $doctor['id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($doctor['full_name'], ENT_QUOTES, 'UTF-8'); ?>
              </option>
          <?php endforeach; ?>
        </select>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <?php if (Auth::role() === 'patient'): ?>
        <input type="hidden" name="patient_id" value="<?= htmlspecialchars(Auth::user()['id'], ENT_QUOTES, 'UTF-8'); ?>">
      <?php else: ?>
        <label>Patient</label>
        <select id="patient_id" name="patient_id" required>
            <option value="" disabled selected>-- Select Patient --</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= htmlspecialchars($patient['id'], ENT_QUOTES, 'UTF-8'); ?>"
                    <?= (isset($patient_id) && $patient_id == $patient['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($patient['full_name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
      <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" required>
    </div>

    <div class="form-group">
        <label for="time">Time</label>
        <input type="time" id="time" name="time" required>
    </div>

    <div class="form-group">
        <label for="note">Note</label>
        <input id="note" name="note">
    </div>

    <button type="submit" class="btn">Create</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
