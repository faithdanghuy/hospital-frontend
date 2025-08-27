<?php ob_start(); ?>
  <h1>Edit Profile</h1>
    <?php if (!empty($error)): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
  <form method="post" action="/account/update">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

    <input type="hidden" 
          name="avatar" 
          value="<?= htmlspecialchars($old['avatar'] ?? ($item['avatar'] ?? '')) ?>"
          required>

    <label>Name</label>
      <input name="full_name" 
          type="text"
          value="<?= htmlspecialchars($old['full_name'] ?? ($item['full_name'] ?? '')) ?>" 
          placeholder="Full Name"
          required>

    <label>Email</label>
      <input name="email" 
          type="email"
          value="<?= htmlspecialchars($old['email'] ?? ($item['email'] ?? '')) ?>" 
          placeholder="Email"
          required>

    <label>Address</label>
      <input name="address" 
          type="text"
          value="<?= htmlspecialchars($old['address'] ?? ($item['address'] ?? '')) ?>" 
          placeholder="Address"
          required>

    <label>Date of Birth</label>
      <input 
          type="date" 
          id="dob_date" 
          value="<?php 
              if (!empty($item['birthday'])) {
                  $dob = new DateTime($item['birthday']);
                  echo $dob->format('Y-m-d');
              }?>"
          required>
      <input type="hidden" name="birthday" id="dob">

    <label>Gender</label>
      <select name="gender" required>
          <option value="male" <?= (strtolower($item["gender"] ?? "") == "male") ? 'selected' : '' ?>>Male</option>
          <option value="female" <?= (strtolower($item["gender"] ?? "") == "female") ? 'selected' : '' ?>>Female</option>
      </select>

    <button type="submit">Save</button>
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
