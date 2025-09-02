<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-6xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('gallery')); ?></h1>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
    <?php
      $r = $mysqli && !$mysqli->connect_errno ? $mysqli->query("SELECT id, image, type FROM gallery ORDER BY created_at DESC") : false;
      if ($r && $r->num_rows): while ($g = $r->fetch_assoc()):
        $path = 'uploads/gallery/'.e($g['image']);
    ?>
      <?php if ($g['type']==='image'): ?>
        <a href="<?php echo $path; ?>" class="block aspect-square rounded overflow-hidden bg-slate/10 lightbox">
          <img src="<?php echo $path; ?>" alt="Gallery" class="w-full h-full object-cover">
        </a>
      <?php else: ?>
        <div class="aspect-square rounded overflow-hidden bg-black">
          <video src="<?php echo $path; ?>" class="w-full h-full object-cover" controls></video>
        </div>
      <?php endif; ?>
    <?php endwhile; else: ?>
      <div class="col-span-2 text-sm">No gallery items.</div>
    <?php endif; ?>
  </div>
  <div id="lb" class="fixed inset-0 hidden items-center justify-center bg-black/80 z-50">
    <img id="lbImg" src="/placeholder.svg?height=400&width=600" alt="Preview" class="max-h-[85vh] max-w-[95vw] rounded">
  </div>
  <script>
    const lb = document.getElementById('lb');
    const lbImg = document.getElementById('lbImg');
    document.querySelectorAll('.lightbox').forEach(a => {
      a.addEventListener('click', e => {
        e.preventDefault();
        lbImg.src = a.href;
        lb.classList.remove('hidden');
        lb.classList.add('flex');
      });
    });
    lb.addEventListener('click', () => {
      lb.classList.add('hidden'); lb.classList.remove('flex'); lbImg.src = '';
    });
  </script>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
