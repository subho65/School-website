<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-6xl mx-auto px-4 py-6">
   Banner Slider 
  <section aria-label="Banner" class="mb-6">
    <div class="relative aspect-[16/9] rounded overflow-hidden bg-slate/20">
      <?php
        $slides = [];
        if ($mysqli && !$mysqli->connect_errno) {
          $res = $mysqli->query("SELECT id, image, link FROM banners ORDER BY id DESC LIMIT 6");
          while ($res && $row = $res->fetch_assoc()) { $slides[] = $row; }
        }
      ?>
      <div id="slider" class="h-full w-full relative">
        <?php if ($slides): foreach ($slides as $i => $b): ?>
          <a href="<?php echo e($b['link'] ?: '#'); ?>" class="absolute inset-0 transition-opacity duration-700 <?php echo $i===0?'opacity-100':'opacity-0'; ?>">
            <img src="<?php echo 'uploads/'.e($b['image']); ?>" alt="Banner" class="h-full w-full object-cover">
          </a>
        <?php endforeach; else: ?>
          <div class="h-full w-full flex items-center justify-center text-slate">No banners yet</div>
        <?php endif; ?>
      </div>
      <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-2">
        <?php for ($i=0;$i<count($slides);$i++): ?>
          <button class="h-2 w-2 rounded-full bg-white/50" data-slide="<?php echo $i; ?>" aria-label="slide <?php echo $i+1; ?>"></button>
        <?php endfor; ?>
      </div>
    </div>
    <script>
      (function(){
        const slides = Array.from(document.querySelectorAll('#slider > a'));
        if (!slides.length) return;
        let idx = 0;
        function show(i){ slides.forEach((s, k) => s.style.opacity = k === i ? '1' : '0'); }
        setInterval(()=>{ idx = (idx+1)%slides.length; show(idx); }, 4000);
      })();
    </script>
  </section>

   Welcome 
  <section class="mb-6">
    <h2 class="text-xl font-semibold text-navy"><?php echo e(__t('welcome')); ?> - <?php echo e($S['school_name']); ?></h2>
    <p class="mt-2 text-sm">
      <?php if (($_SESSION['lang'] ?? 'en') === 'bn'): ?>
        আমাদের বিদ্যালয়ে স্বাগতম। এটি কালীগ্রামের ঐতিহ্যবাহী একটি প্রতিষ্ঠান যেখানে শৃঙ্খলা, নৈতিকতা ও আধুনিক শিক্ষার সমন্বয় ঘটে।
      <?php else: ?>
        Welcome to our school, a proud institution in Kaligram where discipline, values, and modern education come together.
      <?php endif; ?>
    </p>
  </section>

   Quick Links 
  <section class="mb-8">
    <h3 class="text-lg font-semibold mb-3"><?php echo e(__t('quick_links')); ?></h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
      <a class="p-4 rounded border border-slate/20 bg-white hover:border-brand" href="admissions.php"><i class="fa fa-user-plus mr-2 text-brand"></i><?php echo e(__t('admissions')); ?></a>
      <a class="p-4 rounded border border-slate/20 bg-white hover:border-brand" href="results.php"><i class="fa fa-chart-bar mr-2 text-brand"></i><?php echo e(__t('results')); ?></a>
      <a class="p-4 rounded border border-slate/20 bg-white hover:border-brand" href="notices.php"><i class="fa fa-bullhorn mr-2 text-brand"></i><?php echo e(__t('notices')); ?></a>
      <a class="p-4 rounded border border-slate/20 bg-white hover:border-brand" href="gallery.php"><i class="fa fa-images mr-2 text-brand"></i><?php echo e(__t('gallery')); ?></a>
    </div>
  </section>

  <div class="grid gap-6 md:grid-cols-3">
     Notices 
    <section class="md:col-span-2">
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold"><?php echo e(__t('news_notices')); ?></h3>
        <a class="text-brand text-sm" href="notices.php"><?php echo e(__t('view_all')); ?></a>
      </div>
      <div class="bg-white border border-slate/20 rounded divide-y">
        <?php
          $notices = [];
          if ($mysqli && !$mysqli->connect_errno) {
            $r = $mysqli->query("SELECT id, title, description, file, created_at FROM notices ORDER BY created_at DESC LIMIT 5");
            while ($r && $row = $r->fetch_assoc()) { $notices[] = $row; }
          }
        ?>
        <?php if ($notices): foreach($notices as $n): ?>
          <div class="p-4">
            <div class="font-medium"><?php echo e($n['title']); ?></div>
            <div class="text-sm mt-1"><?php echo e($n['description']); ?></div>
            <div class="text-xs mt-2 opacity-60"><?php echo e(date('d M Y', strtotime($n['created_at']))); ?></div>
            <?php if (!empty($n['file'])): ?>
              <a class="mt-2 inline-flex items-center text-brand text-sm" href="download.php?type=notice&id=<?php echo (int)$n['id']; ?>"><i class="fa fa-download mr-1"></i><?php echo e(__t('download')); ?></a>
            <?php endif; ?>
          </div>
        <?php endforeach; else: ?>
          <div class="p-4 text-sm">No notices yet.</div>
        <?php endif; ?>
      </div>
    </section>

     Events 
    <section>
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold"><?php echo e(__t('upcoming_events')); ?></h3>
        <a class="text-brand text-sm" href="events.php"><?php echo e(__t('view_all')); ?></a>
      </div>
      <div class="space-y-3">
        <?php
          $events = [];
          if ($mysqli && !$mysqli->connect_errno) {
            $r = $mysqli->query("SELECT id, title, date, description FROM events WHERE date >= CURDATE() ORDER BY date ASC LIMIT 5");
            while ($r && $row = $r->fetch_assoc()) { $events[] = $row; }
          }
        ?>
        <?php if ($events): foreach($events as $ev): ?>
          <div class="p-4 rounded border border-slate/20 bg-white">
            <div class="text-sm opacity-70"><?php echo e(date('d M Y', strtotime($ev['date']))); ?></div>
            <div class="font-medium"><?php echo e($ev['title']); ?></div>
            <div class="text-sm mt-1"><?php echo e($ev['description']); ?></div>
          </div>
        <?php endforeach; else: ?>
          <div class="text-sm">No upcoming events.</div>
        <?php endif; ?>
      </div>
    </section>
  </div>

   Gallery Preview 
  <section class="mt-8">
    <div class="flex items-center justify-between mb-2">
      <h3 class="text-lg font-semibold"><?php echo e(__t('gallery')); ?></h3>
      <a class="text-brand text-sm" href="gallery.php"><?php echo e(__t('view_all')); ?></a>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
      <?php
        $gals = [];
        if ($mysqli && !$mysqli->connect_errno) {
          $r = $mysqli->query("SELECT id, image, type FROM gallery ORDER BY created_at DESC LIMIT 12");
          while ($r && $row = $r->fetch_assoc()) { $gals[] = $row; }
        }
      ?>
      <?php if ($gals): foreach ($gals as $g): ?>
        <a href="gallery.php" class="block aspect-square rounded overflow-hidden bg-slate/10">
          <img src="<?php echo 'uploads/gallery/'.e($g['image']); ?>" alt="Gallery" class="w-full h-full object-cover">
        </a>
      <?php endforeach; else: ?>
        <div class="col-span-3 text-sm">No gallery items yet.</div>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
