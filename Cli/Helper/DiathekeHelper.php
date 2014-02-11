<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krillzip\Diatheke\Cli\Helper;

use Krillzip\Diatheke\Diatheke;
use Symfony\Component\Console\Helper\Helper;

/**
 * Description of DiathekeHelper
 *
 * @author krillzip
 */
class DiathekeHelper extends Helper{
    
    protected static $diatheke;
    
    public function getName(){
        return 'diatheke';
    }
    
    public function get(){
        if(!self::$diatheke){
            self::$diatheke = new Diatheke();
        }
        return self::$diatheke;
    }
}
