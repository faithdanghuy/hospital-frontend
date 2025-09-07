<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css">
  <title>Hospital Login</title>
</head>
<body>
  <div class="login-wrapper">
    <!-- Nửa trái: Ảnh minh họa -->
    <div class="login-illustration">
      <div class="overlay"></div>
      <h1 class="illustration-title">Welcome to<br> Group 12 International Hospital</h1>
      <p class="illustration-text">Your health, our priority</p>
      <div class="animated-icons">
        <span>❤️</span>
        <span>💊</span>
        <span>🩺</span>
      </div>
    </div>

    <!-- Nửa phải: Form -->
    <div class="form-container">
      <div class="logo">+</div>
      <h2>Hospital Portal</h2>
      <p class="subtitle">Sign in to access patient records and appointments</p>

      <!-- Error handling -->
      <?php if (!empty($error)): ?>
        <div class="error-message">
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
