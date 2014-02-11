<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
