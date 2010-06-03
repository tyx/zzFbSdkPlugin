<?php if ($sf_user->fbSdk !== null): ?>
  <?php var_dump($sf_user->fbSdk->facebook('/me')) ?>
<?php endif; ?>