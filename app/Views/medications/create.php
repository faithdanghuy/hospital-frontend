<?php ob_start(); ?>
<h1>New medication</h1>
<?php if (!empty($error)): ?><div class="alert error">{{ htmlspecialchars($error) }}</div><?php endif; ?>
<form method="post">
  <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">

  <label>Name</label>
    <input name="name"
          placeholder="Enter medication name"
          required>

  <label>Unit</label>
      <select name="dosage" required>
        <option value="" disabled selected>Select unit</option>
        <option value="tablet">tablet</option>
        <option value="capsule">capsule</option>
      </select>

  <label>Stock</label>
    <input name="stock"
          pattern="[0-9]*" 
          inputmode="numeric"
          oninput="this.value = this.value.replace(/[^0-9]/g, '')"
          placeholder="Enter medication stock"
          required>

  <label>Price</label>
    <input name="price"
          pattern="[0-9]*" 
          inputmode="numeric"
          oninput="this.value = this.value.replace(/[^0-9]/g, '')"
          placeholder="Enter medication price"
          required>
  
  <button type="submit">Create</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
