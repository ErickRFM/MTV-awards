<?php $adminJsVersion = @filemtime(__DIR__ . '/../../../../public/js/app.js') ?: time(); ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/jquery/jquery.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/dist/js/adminlte.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/js/app.js?v=' . $adminJsVersion)) ?>"></script>
</body>
</html>
