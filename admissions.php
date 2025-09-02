<?php include __DIR__.'/common/header.php'; verify_csrf(); ?>
<main class="max-w-3xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('admissions')); ?></h1>

  <section class="mb-6">
    <h2 class="text-lg font-semibold mb-2">Process</h2>
    <p class="text-sm">Read the instructions carefully and submit your application online. Attach required documents (PDF/JPG/PNG).</p>
    <div class="mt-3">
      <?php
        $adForm = null;
        if ($mysqli && !$mysqli->connect_errno) {
          $qr = $mysqli->prepare("SELECT id FROM notices WHERE title = 'Admission Form' ORDER BY created_at DESC LIMIT 1");
          $qr->execute(); $qr->bind_result($nid); if ($qr->fetch()) { $adForm = $nid; } $qr->close();
        }
      ?>
      <?php if ($adForm): ?>
        <a class="inline-flex items-center px-4 py-2 bg-brand text-white rounded" href="download.php?type=notice&id=<?php echo (int)$adForm; ?>"><i class="fa fa-file-arrow-down mr-2"></i><?php echo e(__t('admission_form')); ?></a>
      <?php else: ?>
        <span class="text-sm opacity-70">Admission form will be available soon.</span>
      <?php endif; ?>
    </div>
  </section>

  <?php
    $msg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (!$mysqli || $mysqli->connect_errno) { $msg = 'Database not available.'; }
      else {
        $name = trim($_POST['name'] ?? '');
        $class_applied = trim($_POST['class_applied'] ?? '');
        $dob = $_POST['dob'] ?? '';
        $parent_name = trim($_POST['parent_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        if (!$name || !$class_applied || !$dob || !$parent_name) {
          $msg = 'Please fill all required fields.';
        } else {
          $docsName = '';
          if (!empty($_FILES['docs']['name'])) {
            [$ok, $res] = safe_upload($_FILES['docs'], BASE_PATH.'/uploads/docs', ['pdf','jpg','jpeg','png']);
            if ($ok) { $docsName = 'docs/'.$res; } else { $msg = $res; }
          }
          if (!$msg) {
            $st = $mysqli->prepare("INSERT INTO admissions (name, class_applied, dob, parent_name, email, phone, docs, status, created_at) VALUES (?,?,?,?,?,?,?, 'pending', NOW())");
            $st->bind_param('sssssss', $name, $class_applied, $dob, $parent_name, $email, $phone, $docsName);
            if ($st->execute()) {
              $msg = 'Application submitted successfully.';
            } else {
              $msg = 'Failed to submit.';
            }
            $st->close();
          }
        }
      }
    }
  ?>

  <?php if ($msg): ?><div class="mb-4 p-3 rounded bg-green-50 text-green-800 border border-green-200"><?php echo e($msg); ?></div><?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="bg-white border border-slate/20 p-4 rounded space-y-3">
    <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
    <div>
      <label class="block text-sm mb-1"><?php echo e(__t('name')); ?>*</label>
      <input name="name" required class="w-full border rounded px-3 py-2" />
    </div>
    <div>
      <label class="block text-sm mb-1">Class Applied*</label>
      <input name="class_applied" required class="w-full border rounded px-3 py-2" placeholder="e.g., 5, 6, 7..." />
    </div>
    <div>
      <label class="block text-sm mb-1"><?php echo e(__t('dob')); ?>*</label>
      <input type="date" name="dob" required class="w-full border rounded px-3 py-2" />
    </div>
    <div>
      <label class="block text-sm mb-1">Parent/Guardian Name*</label>
      <input name="parent_name" required class="w-full border rounded px-3 py-2" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm mb-1"><?php echo e(__t('email')); ?></label>
        <input type="email" name="email" class="w-full border rounded px-3 py-2" />
      </div>
      <div>
        <label class="block text-sm mb-1"><?php echo e(__t('phone')); ?></label>
        <input name="phone" class="w-full border rounded px-3 py-2" />
      </div>
    </div>
    <div>
      <label class="block text-sm mb-1">Documents (PDF/JPG/PNG)</label>
      <input type="file" name="docs" accept=".pdf,.jpg,.jpeg,.png" class="w-full" />
    </div>
    <button class="px-4 py-2 bg-brand text-white rounded"><?php echo e(__t('apply_online')); ?></button>
  </form>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
