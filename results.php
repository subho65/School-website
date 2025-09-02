<?php include __DIR__.'/common/header.php'; ?>
<main class="max-w-md mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold text-navy mb-4"><?php echo e(__t('results')); ?></h1>
  <form id="resultForm" class="bg-white border border-slate/20 p-4 rounded space-y-3" onsubmit="return false;">
    <div>
      <label class="block text-sm mb-1"><?php echo e(__t('roll_no')); ?></label>
      <input id="roll" class="w-full border rounded px-3 py-2" required />
    </div>
    <div>
      <label class="block text-sm mb-1"><?php echo e(__t('dob')); ?></label>
      <input id="dob" type="date" class="w-full border rounded px-3 py-2" required />
    </div>
    <button id="searchBtn" class="px-4 py-2 bg-brand text-white rounded"><?php echo e(__t('search')); ?></button>
  </form>
  <div id="resultBox" class="mt-4"></div>

  <script>
    const btn = document.getElementById('searchBtn');
    const box = document.getElementById('resultBox');
    btn.addEventListener('click', async () => {
      const roll = document.getElementById('roll').value.trim();
      const dob = document.getElementById('dob').value;
      if (!roll || !dob) return;
      box.innerHTML = '<div class="p-3 text-sm">Loading...</div>';
      try {
        const res = await fetch('api/get_results.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ roll_no: roll, dob })
        });
        const data = await res.json();
        if (!data.ok) {
          box.innerHTML = '<div class="p-3 text-sm text-red-700 bg-red-50 border border-red-200 rounded">' + (data.message || '<?php echo e(__t('no_results')); ?>') + '</div>';
          return;
        }
        const stu = data.student;
        let html = '<div class="bg-white border border-slate/20 rounded p-4">';
        html += '<div class="font-semibold mb-2">'+stu.name+' ('+stu.class+')</div>';
        html += '<div class="text-sm mb-2">Roll: '+stu.roll_no+'</div>';
        html += '<div class="overflow-x-auto"><table class="min-w-full text-sm"><thead><tr><th class="text-left p-2 border-b">Subject</th><th class="text-left p-2 border-b">Marks</th></tr></thead><tbody>';
        for (const r of data.results) {
          html += '<tr><td class="p-2 border-b">'+r.subject+'</td><td class="p-2 border-b">'+r.marks+'</td></tr>';
        }
        html += '</tbody></table></div></div>';
        box.innerHTML = html;
      } catch (e) {
        box.innerHTML = '<div class="p-3 text-sm text-red-700 bg-red-50 border border-red-200 rounded">Error fetching results.</div>';
      }
    });
  </script>
</main>
<?php include __DIR__.'/common/footer.php'; ?>
