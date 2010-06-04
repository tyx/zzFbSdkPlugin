<?php
/*
 * This file is part of the .
 * (c) 2010 Autrement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * zzFbSdkGuardAdapter manages sfGuard connection.
 *
 * @package    zzFbSdkPlugin
 * @subpackage lib
 * @author     Autrement
 * @version    1.0.0
 */
class zzFbSdkGuardAdapter 
{
  protected 
    $facebook_data = array(),
    $guardUser = null;
    
  public function __construct($data)
  {
    $this->facebook_data = $data;
  }  
  
  public function getGuardUser()
  {
    return Doctrine::getTable('sfGuardUser')
      ->createQuery('s')
      ->leftJoin('s.Profile p')
      ->andWhere('p.facebook_uid = ?', $this->facebook_data['id'])
      ->fetchOne();
  }
  
  public function checkGuardUser()
  {
    $this->guardUser = $this->getGuardUser();

    if (false === $this->guardUser)
    {
      if (null !== ($user = $this->checkEmail($this->facebook_data['email'])))
      {
        $this->linkGuardUser($user);
      }
      else
      {
        $this->createGuardUser();
      }
    }
    else
    {
      $this->updateGuardUser();
    }
    
    return $this->guardUser;
  }
  
  public function createGuardUser()
  {
    $user = new sfGuardUser();
    $user->username = $this->generateUsername(Doctrine_Inflector::urlize($this->facebook_data['name']));
    
    $user->Profile = new SfGuardUserProfile();
    $user->Profile->facebook_uid = $this->facebook_data['id'];
    $this->updateProfile($user->Profile);
  }
  
  protected function saveGuardUser($user)
  {
    if (false === $user->trySave())
    {
      return false;
    }
    else
    {
      $this->guardUser = $user;
    }
    
    return $user;
  }
  
  protected function updateProfile($profile)
  {
    $profile->facebook = $this->facebook_data['link'];
    $profile->birthday = date('Y-m-d', strtotime($this->facebook_data['birthday']));
    $profile->firstname = $this->facebook_data['first_name'];
    $profile->lastname = $this->facebook_data['last_name'];
    
    if (true === isset($this->facebook_data['email']))
    {
      $profile->email = $this->facebook_data['email'];
      $profile->email_facebook = $this->facebook_data['email'];
    }
    
    $sex = array('M.', 'Mme', 'Mlle');
    $profile->sex = $sex[$this->getCivilite($this->facebook_data['gender'], $this->facebook_data['relationship_status'])];
    $profile->type_gender_id = ($sex[$this->getCivilite($this->facebook_data['gender'], $this->facebook_data['relationship_status'])] + 1);
  }
  
  public function linkGuardUser($user)
  {
    $user->Profile->facebook_uid = $this->facebook_data['id'];
    $this->updateProfile($user->Profile);
    $this->saveGuardUser($user);
  }
  
  public function updateGuardUser()
  {
    $this->updateProfile($this->guardUser->Profile);
    $this->saveGuardUser($this->guardUser);
  }
  
	public function generateUsername($login)
	{	  	  
	  if (false === $this->checkUsername($login))
	  {
	    // Try with an appended number
	    for ($i = 1; $i <= 20; $i++)
	    {
	      if (true === $this->checkUsername($login . $i))
	      {
	        $login = $login . $i;
	        break;
	      }
	    }

	    // Not valid, we try with an appended random number
	    while (false === $this->checkUsername($login))
	    {
	      list($msec, $sec) = explode(" ", microtime());
	      $random = substr($msec, 3, 5);

	      $login = $login . $random;
	    }
	  }
	  
	  return $login;
	}
	
	public function checkUsername($login)
	{
	  return (Doctrine::getTable('sfGuardUser')->findByUsername($login)->count() === 0);
	}
	
	public function checkEmail($email)
	{
	  return Doctrine::getTable('sfGuardUser')
      ->createQuery('s')
      ->leftJoin('s.Profile p')
      ->andWhere('p.email = ?', $email)
      ->fetchOne();
	}
	
	public function getCivilite($sex, $relationship)
  {   
    if ('homme' == $sex)
    {
      return 0;
    }
    elseif ('femme' == $sex)
    {
      if (strstr($relationship,'Marié'))
      {
        return 1;
      }
      else
      {
        return 2;
      }
    }
  }
}