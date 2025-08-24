<?php ob_start(); ?>
<h1>New Appointment</h1>
<?php if (!empty($error)): ?><div class="alert error">{{ htmlspecialchars($error) }}</div><?php endif; ?>
<form method="post">
  <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">
  <label>Patient id</label>
    <input name="patient_id"
          required>

  <input type="hidden" 
      name="doctor_id" 
      value="{{ htmlspecialchars($doctor_id) }}" 
      required>

  <label>Time</label>
  <input type="time" name="time" required>

  <label>Note</label>
  <input name="note" required>

  <button type="submit">Create</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
