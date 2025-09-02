<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-3xl mx-auto px-4 py-6 space-y-6">
  <h1 class="text-2xl font-semibold text-navy"><?php echo e(__t('about')); ?></h1>
  <section>
    <h2 class="text-lg font-semibold">History</h2>
    <p class="mt-2 text-sm">
      <?php if (($_SESSION['lang'] ?? 'en') === 'bn'): ?>
        সরস্বতী শিশুমন্দির, কালীগ্রাম—বিদ্যালয়ের ইতিহাস গৌরবময় ও ঐতিহ্যমণ্ডিত।
      <?php else: ?>
        Saraswati Shishu Mandir, Kaligram has a proud legacy of value-based education and community service.
      <?php endif; ?>
    </p>
  </section>
  <section>
    <h2 class="text-lg font-semibold">Mission, Vision, Values</h2>
    <ul class="list-disc pl-6 text-sm space-y-1 mt-2">
      <li><?php echo (($_SESSION['lang'] ?? 'en') === 'bn') ? 'নৈতিকতা ও শৃঙ্খলা' : 'Ethics and discipline'; ?></li>
      <li><?php echo (($_SESSION['lang'] ?? 'en') === 'bn') ? 'জ্ঞান ও দক্ষতা' : 'Knowledge and skills'; ?></li>
      <li><?php echo (($_SESSION['lang'] ?? 'en') === 'bn') ? 'সামাজিক দায়বদ্ধতা' : 'Social responsibility'; ?></li>
    </ul>
  </section>
  <section>
    <h2 class="text-lg font-semibold">Principal’s Message</h2>
    <p class="mt-2 text-sm">
      <?php if (($_SESSION['lang'] ?? 'en') === 'bn'): ?>
        প্রিয় শিক্ষার্থীরা, শৃঙ্খলা ও অধ্যবসায়ই সাফল্যের চাবিকাঠি।
      <?php else: ?>
        Dear students, discipline and perseverance are the keys to success.
      <?php endif; ?>
    </p>
  </section>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
