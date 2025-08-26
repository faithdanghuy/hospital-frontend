<?php ob_start(); ?>
<h1>New User</h1>

<?php if (!empty($error)): ?>
  <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="/account/register">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

  <label>Full Name</label>
    <input name="full_name" 
        value="<?= htmlspecialchars($old['full_name'] ?? '') ?>"
        placeholder="Full Name"
        required>

  <label>Email</label>
    <input name="email" 
        type="email" 
        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
        placeholder="Email"
        required>

  <label>Address</label>
    <input name="address" 
        type="text" 
        value="<?= htmlspecialchars($old['address'] ?? '') ?>"
        placeholder="Address"
        required>

  <label>Phone</label>
    <input type="text" 
        name="phone" 
        value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
        placeholder="Phone Number" 
        pattern="[0-9]*" 
        inputmode="numeric"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
        maxlength="11"
        required>

    <label>Date of Birth</label>
      <input type="date" 
        id="dob_date" 
        value="<?= isset($old['dob']) ? htmlspecialchars(date('Y-m-d', strtotime($old['dob']))) : '' ?>"
        required>
    <input type="hidden" name="birthday" id="dob">

  <label>Gender</label>
    <select name="gender" required>
      <option value="" disabled selected>Select Gender</option>
      <option value="male" <?= (isset($old['gender']) && $old['gender'] === 'male') ? 'selected' : '' ?>>Male</option>
      <option value="female" <?= (isset($old['gender']) && $old['gender'] === 'female') ? 'selected' : '' ?>>Female</option>
  </select>

  <label>Role</label>
    <select name="role" required>
      <option value="" disabled selected>Select Role</option>
      <option value="admin" <?= (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
      <option value="doctor" <?= (isset($old['role']) && $old['role'] === 'doctor') ? 'selected' : '' ?>>Doctor</option>
      <option value="patient" <?= (isset($old['role']) && $old['role'] === 'patient') ? 'selected' : '' ?>>Patient</option>
  </select>

  <button type="submit">Create</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>

<script>
function setDobValue() {
    const dateInput = document.getElementById('dob_date').value;
    if (dateInput) {
        // Force midnight UTC
        const iso = new Date(dateInput + "T00:00:00Z").toISOString();
        // Remove milliseconds, keep "YYYY-MM-DDTHH:mm:ssZ"
        document.getElementById('dob').value = iso.split('.')[0] + "Z";
    } else {
        document.getElementById('dob').value = "";
    }
}

// Run once on page load
window.addEventListener('DOMContentLoaded', setDobValue);
// Update whenever user changes date
document.getElementById('dob_date').addEventListener('change', setDobValue);
</script>