<?php ob_start(); ?>
<h1>Edit Profile</h1>
<?php if (!empty($error)): ?><div class="alert error">{{ htmlspecialchars($error) }}</div><?php endif; ?>
<form method="post" action="/account/update">
  <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">
  
  <label>Name</label>
    <input name="name" 
        value="{{ htmlspecialchars($item["name"] ?? "") }}" 
        placeholder="Full Name"
        required>

  <label>Email</label>
    <input name="email" 
        type="email"
        value="{{ htmlspecialchars($item["email"] ?? "") }}" 
        placeholder="Email"
        required>

  <label>Address</label>
    <input name="address" 
        type="text" 
        value="{{ htmlspecialchars($item["address"] ?? "") }}" 
        placeholder="Address"
        required>

  <label>Date of Birth</label>
    <input name="dob" 
        type="date" 
        value="{{ htmlspecialchars($item["dob"] ?? "") }}" 
        required>

  <label>Gender</label>
    <select name="gender" required>
        <option value="male" {{ (strtolower($item["gender"] ?? "") == "male") ? 'selected' : '' }}>Male</option>
        <option value="female" {{ (strtolower($item["gender"] ?? "") == "female") ? 'selected' : '' }}>Female</option>
    </select>

  <button type="submit">Save</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
