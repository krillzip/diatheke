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
 * Description of NotInstalledException
 *
 * @author krillzip
 */
class QueryBuilderException extends Exception{
    public function __construct($error){
        parent::__construct('Improper query building: '.$error, Exception::QUERY_BUILDER);
    }
}
