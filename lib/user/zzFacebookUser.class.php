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
   * Signs in the user on the application.
   *
   * @param sfGuardUser $user The sfGuardUser id
   * @param boolean $remember Whether or not to remember the user
   * @param Doctrine_Connection $con A Doctrine_Connection object
   */
  public function signIn($user, $remember = false, $con = null)
  {
    if ($this->fbSdk == null)
    {
      $this->setAttribute('fb-connect', false);
    }
    
    parent::signIn($user, $remember, $con);
  }

  /**
   * Signs out the user.
   *
   */
  public function signOut()
  {
    $this->setAttribute('fb-connect', false);
    parent::signOut();
  }
}