<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Krillzip\Diatheke;
/**
 * Description of Exception
 *
 * @author krillzip
 */
class Exception extends \Exception{
    const NOT_INSTALLED = 1;
    const QUERY_BUILDER = 2;
    const REFERENCE_ERROR = 3;
    const CONFIGURATION_ERROR = 4;
}