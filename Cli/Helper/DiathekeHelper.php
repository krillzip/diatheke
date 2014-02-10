<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
    
    public function __construct(){
        if(!self::$diatheke){
            self::$diatheke = new Diatheke();
        }
    }
    
    public function getName(){
        return 'diatheke';
    }
    
    public function get(){
        return self::$diatheke;
    }
}
