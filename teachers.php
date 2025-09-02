<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-6xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('teachers_directory')); ?></h1>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php
      $r = $mysqli && !$mysqli->connect_errno ? $mysqli->query("SELECT id, name, subject, qualification, photo FROM teachers ORDER BY created_at DESC") : false;
      if ($r && $r->num_rows): while ($t = $r->fetch_assoc()):
    ?>
      <div class="bg-white border border-slate/20 rounded p-3 text-center">
        <div class="mx-auto h-24 w-24 rounded-full overflow-hidden bg-slate/10">
          <?php if (!empty($t['photo'])): ?>
            <img src="<?php echo 'uploads/gallery/'.e($t['photo']); ?>" alt="<?php echo e($t['name']); ?>" class="h-full w-full object-cover">
          <?php endif; ?>
        </div>
        <div class="mt-2 font-medium"><?php echo e($t['name']); ?></div>
        <div class="text-sm opacity-80"><?php echo e($t['subject']); ?></div>
        <div class="text-xs opacity-60"><?php echo e($t['qualification']); ?></div>
      </div>
    <?php endwhile; else: ?>
      <div class="col-span-2 text-sm">No teachers yet.</div>
    <?php endif; ?>
  </div>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
