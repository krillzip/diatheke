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
class QueryBuilderException extends Exception{
    public function __construct($error){
        parent::__construct('Improper query building: '.$error, Exception::QUERY_BUILDER);
    }
}