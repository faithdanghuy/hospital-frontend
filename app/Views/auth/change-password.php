<?php ob_start(); ?>
<h1>Change Password</h1>

<form method="POST" action="/account/change-password" class="change-password-form">
  <div class="form-group">
    <label>Current Password</label>
        <input type="password" 
            id="current_password" 
            name="current_password" 
            placeholder="Enter current password"
            required>
  </div>

  <div class="form-group">
    <label>New Password</label>
        <input type="password" 
            id="new_password" 
            name="new_password" 
            placeholder="Enter new password"
            required 
            minlength="6">
  </div>

  <div class="form-group">
    <label>Confirm New Password</label>
        <input type="password" 
            id="confirm_password" 
            name="confirm_password" 
            placeholder="Confirm new password"
            required 
            minlength="6">
  </div>

  <div class="form-actions">
    <button type="submit" class="btn">Update Password</button>
    <a href="/account/profile" class="btn btn-secondary">Cancel</a>
  </div>
</form>

<?php 
$content = ob_get_clean();
echo App\Core\View::render('partials/layout', compact('content')); 
?>
