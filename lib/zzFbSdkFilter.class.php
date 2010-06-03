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
      $isActive = sfConfig::get('app_fb_sdk_fb_connect', false);
      
      $fbSdk = new zzFbSdk(sfConfig::get('app_fb_sdk_api_id'), sfConfig::get('app_fb_sdk_api_secret'));
      $this->getContext()->getUser()->fbSdk = $fbSdk;
    }
    
    $filterChain->execute();
  }
}