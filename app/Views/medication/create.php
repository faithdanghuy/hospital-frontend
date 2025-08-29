<?php ob_start(); ?>
<h1>New medication</h1>
<?php if (!empty($error)): ?>
  <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="/medication/create">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

  <label>Name</label>
    <input name="drug_name"
          placeholder="Enter medication name"
          required>

  <label>Unit</label>
      <select name="unit" required>
        <option value="" disabled selected>Select unit</option>
        <option value="tablet">tablet</option>
        <option value="capsule">capsule</option>
        <option value="syrup">syrup</option>
        <option value="injection">injection</option>
        <option value="ointment">ointment</option>
        <option value="drop">drop</option>
        <option value="inhaler">inhaler</option>
        <option value="patch">patch</option>
        <option value="suppository">suppository</option>
        <option value="other">other</option>
      </select>

  <label>Stock</label>
    <input name="stock"
          pattern="[0-9]*" 
          inputmode="numeric"
          oninput="this.value = this.value.replace(/[^0-9]/g, '')"
          placeholder="Enter medication stock"
          required>

  <!-- <label>Price</label>
    <input name="price"
          pattern="[0-9]*" 
          inputmode="numeric"
          oninput="this.value = this.value.replace(/[^0-9]/g, '')"
          placeholder="Enter medication price"
          required> -->

  <label>Description</label>
    <input name="description"
          placeholder="Enter medication description"
          required>
  
  <button type="submit">Create</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
