<?php
/*
 * This file is part of the .
 * (c) 2010 Autrement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * zzFbSdkDemoActions does things.
 *
 * @package    
 * @subpackage actions
 * @author     Autrement
 * @version    1.0.0
 */
class zzFbSdkDemoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->setLayout(false);
  }
  
  public function executeDemo(sfWebRequest $request)
  {

  }
}