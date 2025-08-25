<?php ob_start(); ?>
<h1>New User</h1>

<?php if (!empty($error)): ?>
  <div class="alert error">{{ htmlspecialchars($error) }}</div>
<?php endif; ?>

<form method="post" action="/account/store">
  <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">

  <label>Name</label>
    <input name="name" 
        value="<?= htmlspecialchars($old['name'] ?? '') ?>"
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
    <input name="dob" 
        type="date" 
        value="<?= htmlspecialchars($old['dob'] ?? '') ?>"
        required>

  <label>Gender</label>
    <select name="gender" required>
      <option value="male" <?= (isset($old['gender']) && $old['gender'] === 'male') ? 'selected' : '' ?>>Male</option>
      <option value="female" <?= (isset($old['gender']) && $old['gender'] === 'female') ? 'selected' : '' ?>>Female</option>
  </select>

  <label>Role</label>
    <select name="role" required>
      <option value="admin" <?= (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
      <option value="doctor" <?= (isset($old['role']) && $old['role'] === 'doctor') ? 'selected' : '' ?>>Doctor</option>
      <option value="patient" <?= (isset($old['role']) && $old['role'] === 'patient') ? 'selected' : '' ?>>Patient</option>
  </select>

  <button type="submit">Create</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
