<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-3xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('help')); ?></h1>
  <div class="space-y-3">
    <details class="bg-white border border-slate/20 rounded p-4">
      <summary class="cursor-pointer font-medium">Admissions FAQs</summary>
      <p class="text-sm mt-2">Apply online from the Admissions page and attach required documents.</p>
    </details>
    <details class="bg-white border border-slate/20 rounded p-4">
      <summary class="cursor-pointer font-medium">Academic FAQs</summary>
      <p class="text-sm mt-2">Curriculum covers classes 5 to 10 with core and co-curricular activities.</p>
    </details>
    <details class="bg-white border border-slate/20 rounded p-4">
      <summary class="cursor-pointer font-medium">Fees & Payments</summary>
      <p class="text-sm mt-2">Fee details are shared via notices and at the school office.</p>
    </details>
  </div>
  <div class="mt-6 text-sm">
    Support: <a class="text-brand" href="mailto:<?php echo e($S['email']); ?>"><?php echo e($S['email']); ?></a> | <?php echo e($S['phone']); ?>
  </div>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
