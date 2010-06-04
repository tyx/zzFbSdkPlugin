<?php if ($sf_user->fbSdk !== null): ?>
  <?php if ($sf_user->fbSdk->isFacebookConnected()): ?>
    <a href="<?php echo $sf_user->fbSdk->facebook()->getLogoutUrl(); ?>">
      Déconnexion
    </a>
    <img src="https://graph.facebook.com/<?php echo $sf_user->getGuardUser()->Profile->facebook_uid ?>/picture?type=square">
  <?php else: ?>    
    <a href="<?php echo $sf_user->fbSdk->facebook()->getLoginUrl(array('display' => 'popup', 'req_perms' => 'email')) ?>" rel="facebox">
      <img src="/images/icons/fb_light_small_short.gif" alt="Facebook connect" class="fb-avatar" />
    </a>
  <?php endif; ?>
<?php endif; ?>