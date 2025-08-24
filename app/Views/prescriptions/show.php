<?php ob_start(); ?>
<h1>Prescription Detail</h1>
<pre><?php print_r($item ?? []); ?></pre>
<a class="btn" href="/prescriptions">Back</a>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
