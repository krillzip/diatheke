<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Krillzip\Diatheke\Exception;

use Krillzip\Diatheke\Exception;
/**
 * Description of ConfigurationException
 *
 * @author krillzip
 */
class ConfigurationException extends Exception{
    public function __construct($message = 'Configuration error'){
        parent::__construct($message, Exception::CONFIGURATION_ERROR);
    }
}
