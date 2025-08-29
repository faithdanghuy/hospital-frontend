<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<h1>New Prescription</h1>

<?php if (!empty($error)): ?>
  <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="/prescription/create" id="prescriptionForm" onsubmit="prepareFormData()">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

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
  </div>

  <label>Status</label>
  <select name="status" required>
    <option value="not_collected">Not Collected</option>
    <option value="collected">Collected</option>
    <option value="pending">Pending</option>
  </select>

  <h3>Medications</h3>
  <div id="medications-wrapper">
    <div class="medication-row">
      <select name="medications[0][medication_id]" required>
        <option value="" disabled selected>-- Select Medication --</option>
        <?php foreach ($meds as $med): ?>
          <option value="<?= htmlspecialchars($med['id']); ?>">
            <?= htmlspecialchars($med['drug_name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
        
      <input type="number" min="1" name="medications[0][quantity]" placeholder="Qty" required>
      <input name="medications[0][dosage]" placeholder="Dosage" required>
      <input name="medications[0][instruction]" placeholder="Instruction" required>
    </div>
  </div>

  <button type="button" onclick="addMedication()">+ Add Medication</button>
  <button type="submit">Create</button>
</form>

<script>
let medIndex = 1;

function addMedication() {
  const wrapper = document.getElementById('medications-wrapper');
  const row = document.createElement('div');
  row.className = 'medication-row';
  row.innerHTML = `
    <select name="medications[${medIndex}][medication_id]" required>
      <option value="" disabled selected>-- Select Medication --</option>
      <?php foreach ($meds as $med): ?>
        <option value="<?= htmlspecialchars($med['id']); ?>">
          <?= htmlspecialchars($med['drug_name']); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <input type="number" min="1" name="medications[${medIndex}][quantity]" placeholder="Qty" required>
    <input name="medications[${medIndex}][dosage]" placeholder="Dosage" required>
    <input name="medications[${medIndex}][instruction]" placeholder="Instruction" required>
    <button type="button" class="btn delete-btn" onclick="removeMedication(this)">Remove</button>
  `;
  wrapper.appendChild(row);
  medIndex++;
}

function removeMedication(button) {
  const row = button.parentNode;
  row.parentNode.removeChild(row);
}

function convertQuantitiesToInt() {
  const quantities = document.querySelectorAll('input[name^="medications"][name$="[quantity]"]');
  quantities.forEach(input => {
    input.value = parseInt(input.value, 10) || 0;
  });
}

function prepareFormData() {
  convertQuantitiesToInt();
}

</script>

<?php
$content = ob_get_clean();
echo App\Core\View::render('partials/layout', compact('content'));
?>
