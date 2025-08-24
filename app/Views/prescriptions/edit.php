<?php ob_start(); ?>
<h1>Edit Prescription</h1>
<?php if (!empty($error)): ?><div class="alert error">{{ htmlspecialchars($error) }}</div><?php endif; ?>
<form method="post">
  <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">
  <label>Patient_id</label><input name="patient_id" value="{{ htmlspecialchars($item["patient_id"] ?? "") }}" required><label>Doctor_id</label><input name="doctor_id" value="{{ htmlspecialchars($item["doctor_id"] ?? "") }}" required><label>Drug_id</label><input name="drug_id" value="{{ htmlspecialchars($item["drug_id"] ?? "") }}" required><label>Quantity</label><input name="quantity" value="{{ htmlspecialchars($item["quantity"] ?? "") }}" required><label>Status</label><input name="status" value="{{ htmlspecialchars($item["status"] ?? "") }}" required>
  <button type="submit">Save</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
