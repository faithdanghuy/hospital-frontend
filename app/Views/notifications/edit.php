<?php ob_start(); ?>
<h1>Edit Notification</h1>
<?php if (!empty($error)): ?><div class="alert error">{{ htmlspecialchars($error) }}</div><?php endif; ?>
<form method="post">
  <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">
  <label>User_id</label><input name="user_id" value="{{ htmlspecialchars($item["user_id"] ?? "") }}" required><label>Channel</label><input name="channel" value="{{ htmlspecialchars($item["channel"] ?? "") }}" required><label>Message</label><input name="message" value="{{ htmlspecialchars($item["message"] ?? "") }}" required>
  <button type="submit">Save</button>
</form>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
