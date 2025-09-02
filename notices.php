<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-4xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('notices')); ?></h1>
  <div class="bg-white border border-slate/20 rounded divide-y">
    <?php
      $r = $mysqli && !$mysqli->connect_errno ? $mysqli->query("SELECT id, title, description, file, created_at FROM notices ORDER BY created_at DESC") : false;
      if ($r && $r->num_rows): while($n = $r->fetch_assoc()):
    ?>
      <div class="p-4">
        <div class="font-medium"><?php echo e($n['title']); ?></div>
        <div class="text-sm mt-1"><?php echo e($n['description']); ?></div>
        <div class="text-xs mt-2 opacity-60"><?php echo e(date('d M Y', strtotime($n['created_at']))); ?></div>
        <?php if (!empty($n['file'])): ?>
          <a class="mt-2 inline-flex items-center text-brand text-sm" href="download.php?type=notice&id=<?php echo (int)$n['id']; ?>"><i class="fa fa-download mr-1"></i><?php echo e(__t('download')); ?></a>
        <?php endif; ?>
      </div>
    <?php endwhile; else: ?>
      <div class="p-4 text-sm">No notices yet.</div>
    <?php endif; ?>
  </div>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
