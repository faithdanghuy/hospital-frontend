<?php ob_start(); ?>
<h1>Doctor Dashboard</h1>

<div class="dashboard-grid">
  <div class="card summary">
    <h3>Today's Appointments</h3>
    <p class="number"><?= $stats['appointments_today'] ?? 0 ?></p>
    <a href="/appointments" class="btn-link">View Schedule</a>
  </div>
  <div class="card summary">
    <h3>My Patients</h3>
    <p class="number"><?= $stats['my_patients'] ?? 0 ?></p>
    <a href="/patients" class="btn-link">View Patients</a>
  </div>
  <div class="card summary">
    <h3>Prescriptions</h3>
    <p class="number"><?= $stats['pending_prescriptions'] ?? 0 ?></p>
    <a href="/prescriptions" class="btn-link">Review</a>
  </div>
</div>

<div class="reports">
  <h2>Weekly Consultations</h2>
  <canvas id="doctorChart"></canvas>
</div>

<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>