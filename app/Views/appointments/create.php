<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<h1>New Appointment</h1>

  <!-- Error handling -->
  <?php if (!empty($error)): ?>
    <div class="error-message" style="color: red; margin-bottom: 10px;">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

<form id="appointmentForm" method="post">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

  <div class="form-group">
    <?php if (Auth::role() === 'doctor'): ?>
      <input type="hidden" name="doctor_id" value="<?= htmlspecialchars(Auth::user()['id']); ?>">
    <?php else: ?>
      <label>Doctor</label>
      <select id="doctor_id" name="doctor_id" required>
        <option value="" disabled selected>-- Select Doctor --</option>
        <?php foreach ($doctors as $doctor): ?>
          <option value="<?= htmlspecialchars($doctor['id']); ?>"
            <?= (isset($doctor_id) && $doctor_id == $doctor['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($doctor['full_name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <?php if (Auth::role() === 'patient'): ?>
      <input type="hidden" name="patient_id" value="<?= htmlspecialchars(Auth::user()['id']); ?>">
    <?php else: ?>
      <label>Patient</label>
      <select id="patient_id" name="patient_id" required>
        <option value="" disabled selected>-- Select Patient --</option>
        <?php foreach ($patients as $patient): ?>
          <option value="<?= htmlspecialchars($patient['id']); ?>"
            <?= (isset($patient_id) && $patient_id == $patient['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($patient['full_name']); ?>
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

  <input type="hidden" name="scheduled_at" id="scheduled_at" required>

  <div class="form-group">
    <label for="note">Note</label>
    <input id="note" name="note">
  </div>

  <button type="submit" class="btn">Create</button>
</form>

<script>
document.getElementById("appointmentForm").addEventListener("submit", function() {
    const date = document.getElementById("date").value; // YYYY-MM-DD
    const time = document.getElementById("time").value; // HH:MM
    if (date && time) {
        // Ghép thành ISO string (UTC format)
        const isoString = date + "T" + time + ":00Z";
        document.getElementById("scheduled_at").value = isoString;
    }
});
</script>

<?php $content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
