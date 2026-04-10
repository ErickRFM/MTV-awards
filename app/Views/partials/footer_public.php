<?php $publicJsVersion = @filemtime(__DIR__ . '/../../../public/js/app.js') ?: time(); ?>
      </div>
    </div>
  </div>
</div>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/jquery/jquery.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/dist/js/adminlte.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/js/app.js?v=' . $publicJsVersion)) ?>"></script>
</body>
</html>
