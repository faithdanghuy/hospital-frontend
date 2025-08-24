<?php ob_start(); ?>
<h1>Dashboard</h1>
<div class="cards">
  <a class="card" href="/patients"><h3>Patients</h3><p>Manage patients</p></a>
  <a class="card" href="/medications"><h3>Medications</h3><p>Manage medications</p></a>
  <a class="card" href="/appointments"><h3>Appointments</h3><p>Manage schedules</p></a>
  <a class="card" href="/prescriptions"><h3>Prescriptions</h3><p>Manage prescriptions</p></a>
  <a class="card" href="/notifications"><h3>Notifications</h3><p>Send messages</p></a>
  <a class="card" href="/reports"><h3>Reports</h3><p>Stats & charts</p></a>
</div>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
