<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css">
  <title>Login</title>
</head>
<body>
  <div class="login-wrapper">
    <div class="form-container">
      <h1 style="margin-bottom: 1rem;">Login</h1>

      <!-- Error handling -->
      <?php if (!empty($error)): ?>
        <div class="error-message" style="color: red; margin-bottom: 10px;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>
      
      <form action="/auth/login" method="POST" id="login-form">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        
        <input type="text" 
              name="phone" 
              id="phone-number" 
              placeholder="Phone Number" 
              pattern="[0-9]*" 
              inputmode="numeric"
              oninput="this.value = this.value.replace(/[^0-9]/g, '')"
              value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
              maxlength="11"
              required>

        <input type="password" 
              name="password" 
              id="password" 
              placeholder="Password" 
              required>
              
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
