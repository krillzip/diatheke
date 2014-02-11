<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
