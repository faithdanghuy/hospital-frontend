<?php ob_start(); ?>
<div class="container">
    <h1 style="text-align: center;">Edit Appointment</h1>

    <?php if (!empty($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form method="post" class="form">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

        <div class="form-group">
            <label>Date</label>
            <input type="date" id="date" name="date" 
                   value="<?= htmlspecialchars($item['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label>Time</label>
            <input type="time" id="time" name="time" 
                   value="<?= htmlspecialchars($item['time'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label>Note</label>
            <input type="text" id="note" name="note" 
                   value="<?= htmlspecialchars($item['note'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>


        <div class="form-group">
            <label>Status</label>
            <select id="status" name="status" required>
                <?php 
                $statuses = ['Pending', 'Confirmed', 'Cancelled'];
                $currentStatus = $item['status'] ?? 'Pending';
                foreach ($statuses as $status): ?>
                    <option value="<?= $status ?>" <?= ($status === $currentStatus) ? 'selected' : '' ?>>
                        <?= $status ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn">Save</button>
    </form>
</div>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
