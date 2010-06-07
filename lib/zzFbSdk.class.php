<?php
/*
 * This file is part of the .
 * (c) 2010 Autrement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * zzFbSdk does things.
 *
 * @package    
 * @subpackage 
 * @author     Autrement
 * @version    1.0.0
 */
class zzFbSdk
{
  protected 
    $facebook,
    $hasGuard = false,
    $guardAdapter = null;
  
  public function __construct($apiId, $apiSecret, $hasGuard, $cookie = true)
  {
    if (null === $apiId || null === $apiSecret)
    {
      throw new sfException('Cannot initialize facebook connection');
    }
    
    $this->hasGuard = $hasGuard;
    
    $this->facebook = new Facebook(array(
      'appId' => $apiId,
      'secret' => $apiSecret,
      'cookie' => $cookie,
    ));
  }
  
  public function facebook($requestApi = null)
  {
    if (null !== $requestApi)
    {
      return $this->facebook->api($requestApi);
    }
    
    return $this->facebook;
  }
  
  public function isFacebookConnected()
  {
    $me = null;
    
    try
    {
      if (null !== $this->facebook->getSession())
      {
        $user = $this->facebook->getUser();
        $me = $this->facebook('/me');
      }
    }
    catch(FacebookApiException $e)
    {
      return false;
    }
    
    return null !== $me;
  }
  
  public function hasGuard()
  {
    return $this->hasGuard;
  }
  
  public function getGuardAdapter()
  {
    if (null === $this->guardAdapter)
    {
      $this->guardAdapter = new zzFbSdkGuardAdapter($this->facebook('/me'));
    }
    
    return $this->guardAdapter;
  }
  
  public function checkGuardUser()
  {
    return $this->getGuardAdapter()->checkGuardUser();
  }
}