<?php ob_start(); ?>
<h1>New Prescription</h1>
<?php if (!empty($error)): ?><div class="alert error">{{ htmlspecialchars($error) }}</div><?php endif; ?>
<form method="post">
  <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">
  <label>Patient_id</label><input name="patient_id" required><label>Doctor_id</label><input name="doctor_id" required><label>Drug_id</label><input name="drug_id" required><label>Quantity</label><input name="quantity" required><label>Status</label><input name="status" required>
  <button type="submit">Create</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
