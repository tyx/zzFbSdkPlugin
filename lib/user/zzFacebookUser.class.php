<?php
/*
 * This file is part of the .
 * (c) 2010 Autrement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * zzFacebookUser does things.
 *
 * @package    
 * @subpackage 
 * @author     Autrement
 * @version    1.0.0
 */
class zzFacebookUser extends sfGuardSecurityUser
{
  /**
   * To ensure removing fb-connect attribute, uses for determine fb-connect or normal connect
   *
   */
  public function signOut()
  {
    $this->setAttribute('fb-connect', false);
    parent::signOut();
  }
}