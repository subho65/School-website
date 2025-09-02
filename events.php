<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-4xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('upcoming_events')); ?></h1>
  <div class="space-y-3">
    <?php
      $rows = $mysqli && !$mysqli->connect_errno ? $mysqli->query("SELECT id, title, date, description FROM events ORDER BY date DESC") : false;
      if ($rows && $rows->num_rows): while ($ev = $rows->fetch_assoc()):
    ?>
      <div class="p-4 rounded border border-slate/20 bg-white">
        <div class="text-sm opacity-70"><?php echo e(date('d M Y', strtotime($ev['date']))); ?></div>
        <div class="font-medium"><?php echo e($ev['title']); ?></div>
        <div class="text-sm mt-1"><?php echo e($ev['description']); ?></div>
      </div>
    <?php endwhile; else: ?>
      <div class="text-sm">No events available.</div>
    <?php endif; ?>
  </div>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
