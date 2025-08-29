<?php ob_start(); ?>
<h1>Edit Prescription</h1>

<?php if (!empty($error)): ?>
  <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="/prescription/update/<?= htmlspecialchars($item['id']) ?>">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
  <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'] ?? '') ?>">
  <input type="hidden" name="patient_id" value="<?= htmlspecialchars($item['patient_id'] ?? '') ?>" required>
  <input type="hidden" name="doctor_id" value="<?= htmlspecialchars($item['doctor_id'] ?? '') ?>" required>

  <label>Status</label>
  <select name="status" required>
    <option value="not_collected" <?= ($item['status'] ?? '') === 'not_collected' ? 'selected' : '' ?>>Not Collected</option>
    <option value="collected" <?= ($item['status'] ?? '') === 'collected' ? 'selected' : '' ?>>Collected</option>
    <option value="pending" <?= ($item['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
  </select>

  <h3>Medications</h3>
  <div id="medications-wrapper">
    <?php if (!empty($item['medications'])): ?>
      <?php foreach ($item['medications'] as $i => $it): ?>
        <div class="medication-row">
          <!-- <input name="medications[<?= $i ?>][medication_id]" placeholder="Medication ID"
                 value="<?= htmlspecialchars($med['medication_id'] ?? '') ?>" required> -->
                 
          <select name="medications[<?= $i ?>][medication_id]" required>
            <option value="" disabled <?= empty($medication['medication_id']) ? 'selected' : '' ?>>-- Select Medication --</option>
            <?php foreach ($meds as $med): ?>
              <option value="<?= htmlspecialchars($med['id']); ?>"
                <?= (!empty($it['medication_id']) && $it['medication_id'] == $med['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($med['drug_name']); ?>
              </option>
            <?php endforeach; ?>
          </select>

          <input type="number" min="1" name="medications[<?= $i ?>][quantity]" placeholder="Qty"
                 value="<?= htmlspecialchars($it['quantity'] ?? 0) ?>" required>
          <input name="medications[<?= $i ?>][dosage]" placeholder="Dosage"
                 value="<?= htmlspecialchars($it['dosage'] ?? '') ?>" required>
          <input name="medications[<?= $i ?>][instruction]" placeholder="Instruction"
                 value="<?= htmlspecialchars($it['instruction'] ?? '') ?>" required>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="medication-row">
        <input name="medications[0][medication_id]" placeholder="Medication ID" required>
        <input type="number" min="1" name="medications[0][quantity]" placeholder="Qty" required>
        <input name="medications[0][dosage]" placeholder="Dosage" required>
        <input name="medications[0][instruction]" placeholder="Instruction" required>
        <input type="datetime-local" name="medications[0][issued_at]" required>
      </div>
    <?php endif; ?>
  </div>

  <button type="button" onclick="addMedication()">+ Add Medication</button>
  <button type="submit">Save</button>
</form>

<script>
let medIndex = <?= !empty($item['medications']) ? count($item['medications']) : 1 ?>;

// Template medication row (sử dụng PHP để render dropdown thuốc)
const medicationTemplate = `
  <div class="medication-row">
    <select name="medications[__INDEX__][medication_id]" required>
      <option value="" selected disabled>-- Select Medication --</option>
      <?php foreach ($meds as $med): ?>
        <option value="<?= htmlspecialchars($med['id']); ?>">
          <?= htmlspecialchars($med['drug_name']); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <input type="number" min="1" name="medications[__INDEX__][quantity]" placeholder="Qty" required>
    <input name="medications[__INDEX__][dosage]" placeholder="Dosage" required>
    <input name="medications[__INDEX__][instruction]" placeholder="Instruction" required>
    <button type="button" class="btn delete-btn" onclick="removeMedication(this)">Remove</button>
  </div>
`;

function addMedication() {
  const wrapper = document.getElementById('medications-wrapper');
  const rowHtml = medicationTemplate.replace(/__INDEX__/g, medIndex);
  wrapper.insertAdjacentHTML('beforeend', rowHtml);
  medIndex++;
}

function removeMedication(button) {
  button.closest('.medication-row').remove();
}
</script>

<?php 
$content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
