<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-3xl mx-auto px-4 py-6 space-y-6">
  <h1 class="text-2xl font-semibold text-navy"><?php echo e(__t('academics')); ?></h1>
  <section>
    <h2 class="text-lg font-semibold">Curriculum (Classes 5–10)</h2>
    <p class="text-sm mt-2"><?php echo (($_SESSION['lang'] ?? 'en')==='bn') ? 'শ্রেণি ৫-১০ এর পাঠ্যসূচি' : 'Curriculum for classes 5–10 includes core and elective subjects.'; ?></p>
  </section>
  <section>
    <h2 class="text-lg font-semibold">Subjects</h2>
    <ul class="list-disc pl-6 text-sm space-y-1 mt-2">
      <li>Bangla / English / Mathematics</li>
      <li>Science / Social Science</li>
      <li>Computer / Physical Education / Art</li>
    </ul>
  </section>
  <section>
    <h2 class="text-lg font-semibold">Co-curricular</h2>
    <p class="text-sm mt-2">Sports, cultural events, debates, NCC/NSS, community service.</p>
  </section>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
