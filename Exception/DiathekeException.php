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
class DiathekeException extends Exception{
    public function __construct($message = 'Diatheke error'){
        parent::__construct($message, Exception::DIATHEKE_ERROR);
    }
}
