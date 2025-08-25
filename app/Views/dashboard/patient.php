<?php ob_start(); ?>
<h1>My Dashboard</h1>

<div class="dashboard-grid">
  <div class="card summary">
    <h3>Upcoming Appointments</h3>
    <p class="number"><?= $stats['appointments_upcoming'] ?? 0 ?></p>
    <a href="/appointments" class="btn-link">View</a>
  </div>
  <div class="card summary">
    <h3>My Prescriptions</h3>
    <p class="number"><?= $stats['prescriptions'] ?? 0 ?></p>
    <a href="/prescriptions" class="btn-link">View</a>
  </div>
  <div class="card summary">
    <h3>Medical History</h3>
    <p class="number"><?= $stats['visits'] ?? 0 ?></p>
    <a href="/reports" class="btn-link">View</a>
  </div>
</div>

<div class="reports">
  <h2>Health Overview</h2>
  <canvas id="patientChart"></canvas>
</div>

<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>