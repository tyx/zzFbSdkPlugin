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
  protected $facebook;
  
  public function __construct($apiId, $apiSecret, $cookie = true)
  {
    if (null === $apiId || null === $apiSecret)
    {
      throw new sfException('Cannot initialize facebook connection');
    }
    
    $this->facebook = new Facebook(array(
      'appId' => $apiId,
      'secret' => $apiSecret,
      'cookie' => true,
    ));
  }
  
  public function facebook($requestApi)
  {
    return $this->facebook->api($requestApi);
  }
}