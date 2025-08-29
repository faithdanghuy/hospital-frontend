<?php use App\Core\Auth; ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Medicare</title>
  <link rel="stylesheet" href="/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body>
<div class="layout">
  <aside class="sidebar">

    <?php if (Auth::check()): ?>
      <div class="sidebar-top">
        <div class="brand"><a href="/">Medicare</a></div>
        <span class="user-name">
          Hi, <?= htmlspecialchars(Auth::user()['full_name'] ?? 'Guest') ?>!
        </span>

        <div class="divider"></div>

        <nav>
          <a href="/"><i class="icon fa fa-house"></i>Home</a>
          <a href="/notification"><i class="icon fa fa-bell"></i>Notifications</a>
          <a href="/account/profile"><i class="icon fa-solid fa-address-card"></i>Profile</a>

          <?php $role = Auth::role(); ?>
          <?php if ($role === 'admin'): ?>
            <a href="/account"><i class="icon fa fa-user"></i>Users</a>
            <a href="/medications"><i class="icon fa fa-pills"></i>Medication</a>
            <a href="/appointments"><i class="icon fa fa-calendar"></i>Appointments</a>
            <a href="/prescriptions"><i class="icon fa fa-file-prescription"></i>Prescriptions</a>

          <?php elseif ($role === 'doctor'): ?>
            <a href="/appointments"><i class="icon fa fa-calendar"></i>My Appointments</a>
            <a href="/prescriptions"><i class="icon fa fa-file-prescription"></i>My Prescriptions</a>

          <?php elseif ($role === 'patient'): ?>
            <a href="/appointments"><i class="icon fa fa-calendar"></i>My Appointments</a>
            <a href="/prescriptions"><i class="icon fa fa-file-prescription"></i>My Prescriptions</a>
          <?php endif; ?>
        </nav>
      </div>

      <div class="sidebar-bottom">
        <div class="divider"></div>
        <form action="/auth/logout" method="post" class="logout">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
          <button type="submit">Logout</button>
        </form>
        <span class="copyright">© 2025 MediCare</span>
      </div>
    <?php else: ?>
      <div class="sidebar-top">
        <div class="brand">Medicare</div>
        <div class="divider"></div>
        <nav>
          <a href="/auth/login"><i class="icon fa fa-right-to-bracket"></i>Login</a>
        </nav>
      </div>
      <div class="sidebar-bottom">
        <span class="copyright">© 2025 MediCare</span>
      </div>
    <?php endif; ?>

  </aside>

  <main class="content">
    <?= $content ?? '' ?>
  </main>
</div>
</body>
</html>
