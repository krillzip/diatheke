<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Krillzip\Diatheke\Exception;

use Krillzip\Diatheke\Exception;
/**
 * Description of NotInstalledException
 *
 * @author krillzip
 */
class NotInstalledException extends Exception{
    public function __construct(){
        parent::__construct('Diatheke is not installed', Exception::NOT_INSTALLED);
    }
}