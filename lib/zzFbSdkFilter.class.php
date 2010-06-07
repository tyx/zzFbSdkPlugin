<?php
/*
 * This file is part of the .
 * (c) 2010 Autrement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * zzFbSdkFilter does things.
 *
 * @package    
 * @subpackage filters
 * @author     Autrement
 * @version    1.0.0
 */
class zzFbSdkFilter extends sfFilter
{
  public function execute($filterChain)
  {
    if ($this->isFirstCall())
    {    
      $fbSdk = new zzFbSdk(sfConfig::get('app_fb_sdk_api_id'), sfConfig::get('app_fb_sdk_api_secret'), sfConfig::get('app_fb_sdk_has_guard'));
      $this->getContext()->getUser()->fbSdk = $fbSdk;
   
      // On charge le fb connect si pas connecté ou si déjà connecté via facebook
      if ($this->getContext()->getUser()->isAnonymous() || $this->getContext()->getUser()->getAttribute('fb-connect'))
      {
        $isFbConnectActive = sfConfig::get('app_fb_sdk_fb_connect', false);

        if (true === $isFbConnectActive && true === $fbSdk->isFacebookConnected() && true === $fbSdk->hasGuard())
        {
          $guardUser = $fbSdk->checkGuardUser();
        
          if (null !== $guardUser)
          {
            $this->getContext()->getUser()->signIn($guardUser);
            $this->getContext()->getUser()->setAttribute('fb-connect', true);
          }
        }
      }
    }
    
    $filterChain->execute();
  }
}