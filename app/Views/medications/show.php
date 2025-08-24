<?php ob_start(); ?>
<h1>Medication Detail</h1>
<pre><?php print_r($item ?? []); ?></pre>
<a class="btn" href="/medications">Back</a>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
