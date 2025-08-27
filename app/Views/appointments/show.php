<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<div class="container">
    <h1 style="text-align: center;">Appointment Details</h1>

    <div class="card">
        <div class="card__body">
            <div class="field">
                <strong>Patient:</strong>
                <span class="field__value">
                    <a href="../account/detail/<?= htmlspecialchars($item['patient']['id'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>">
                        <?= htmlspecialchars($item['patient']['full_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </span>
            </div>

            <div class="field">
                <strong>Doctor:</strong>
                <span class="field__value">
                    <a href="../account/detail/<?= htmlspecialchars($item['doctor']['id'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>">
                        <?= htmlspecialchars($item['doctor']['full_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </span>
            </div>

            <div class="field">
                <strong>Date:</strong>
                <span class="field__value">
                    <?= htmlspecialchars($item['date'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </div>

            <div class="field">
                <strong>Time:</strong>
                <span class="field__value">
                    <?= htmlspecialchars($item['time'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </div>

            <div class="field">
                <strong>Confirm at:</strong>
                <span class="field__value">
                    <?= htmlspecialchars($item['confirmed_date'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?> - 
                    <?= htmlspecialchars($item['confirmed_time'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </div>

            <div class="field">
                <strong>Status:</strong>
                <span class="status <?= strtolower($item['status'] ?? 'pending'); ?>">
                    <?= htmlspecialchars($item['status'] ?? 'Pending', ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </div>
        </div>

        <?php if (!empty(trim((string)$item['note']))): ?>
            <div class="description">
                <strong>Note:</strong> <?= nl2br(htmlspecialchars((string)$item['note'], ENT_QUOTES, 'UTF-8')); ?>
            </div>
        <?php endif; ?>
    </div>

    <div style="margin-top: 20px; text-align: center;">
        <!-- Nút Edit -->
        <a class="btn" href="/appointment/edit/<?= urlencode((string)($item['id'] ?? '')) ?>">Edit Appointment</a>

    <?php if (Auth::role() === 'doctor' || Auth::role() === 'admin'): ?>
        <?php if ($item['status'] === 'pending'): ?>
            <!-- Nếu Pending thì hiện cả Confirm + Cancel -->
            <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="display:inline-block;">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="status" value="confirmed">
                <button type="submit" class="btn success">Confirm</button>
            </form>
        
            <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="display:inline-block;">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn danger">Cancel</button>
            </form>
        
        <?php elseif ($item['status'] === 'confirmed'): ?>
            <!-- Nếu Confirmed thì chỉ hiện Cancel -->
            <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="display:inline-block;">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn danger">Cancel</button>
            </form>
        
        <?php elseif ($item['status'] === 'cancelled'): ?>
            <!-- Nếu Cancelled thì chỉ hiện Confirm -->
            <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="display:inline-block;">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="status" value="confirmed">
                <button type="submit" class="btn success">Confirm</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    </div>
</div>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
