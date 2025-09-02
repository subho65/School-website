<?php include __DIR__.'/common/header.php'; verify_csrf(); ?>
<main class="max-w-4xl mx-auto px-4 py-6 grid gap-6 md:grid-cols-2">
  <section>
    <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('contact')); ?></h1>
    <?php
      $msg = '';
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $message = trim($_POST['message'] ?? '');
        if (!$name || !$email || !$message) $msg = 'Please fill required fields.';
        if (!$msg) {
          if ($mysqli && !$mysqli->connect_errno) {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $st = $mysqli->prepare("INSERT INTO contact_messages (name, email, phone, message, ip, created_at) VALUES (?,?,?,?,?,NOW())");
            if ($st) {
              $st->bind_param('sssss', $name, $email, $phone, $message, $ip);
              $st->execute();
              $st->close();
            }
          }
          $to = $S['email'] ?: 'school@example.com';
          $sub = "Contact from ".$name;
          $body = "Name: $name\nEmail: $email\nPhone: $phone\n\n$message";
          @mail($to, $sub, $body, "From: no-reply@".($_SERVER['HTTP_HOST'] ?? 'localhost')."\r\nReply-To: $email");
          $msg = 'Message sent successfully.';
        }
      }
    ?>
    <?php if ($msg): ?><div class="mb-3 p-3 bg-green-50 border border-green-200 text-green-800 rounded"><?php echo e($msg); ?></div><?php endif; ?>
    <form method="post" class="bg-white border border-slate/20 p-4 rounded space-y-3">
      <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
      <div>
        <label class="block text-sm mb-1"><?php echo e(__t('name')); ?>*</label>
        <input name="name" required class="w-full border rounded px-3 py-2" />
      </div>
      <div>
        <label class="block text-sm mb-1"><?php echo e(__t('email')); ?>*</label>
        <input name="email" type="email" required class="w-full border rounded px-3 py-2" />
      </div>
      <div>
        <label class="block text-sm mb-1"><?php echo e(__t('phone')); ?></label>
        <input name="phone" class="w-full border rounded px-3 py-2" />
      </div>
      <div>
        <label class="block text-sm mb-1"><?php echo e(__t('message')); ?>*</label>
        <textarea name="message" required class="w-full border rounded px-3 py-2 h-28"></textarea>
      </div>
      <button class="px-4 py-2 bg-brand text-white rounded"><?php echo e(__t('send_message')); ?></button>
    </form>
  </section>
  <section>
    <div class="bg-white border border-slate/20 p-4 rounded">
      <h2 class="font-semibold mb-2">Location</h2>
      <?php if (!empty($S['map_embed'])): ?>
        <div class="aspect-video rounded overflow-hidden"><?php echo $S['map_embed']; ?></div>
      <?php else: ?>
        <iframe class="w-full aspect-video rounded"
          src="https://www.google.com/maps?q=Kaligram&output=embed" loading="lazy"></iframe>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
