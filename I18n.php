<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Diatheke;

/**
 * Description of I18n
 *
 * @author krillzip
 */
class I18n {
    
    protected $locale;
    protected $file;
    
    public function __construct($locale = 'en'){
        $this->locale = $locale;
        $this->file = include(__DIR__.'/i18n/'.$this->locale.'.php');
    }
    
    public function book($phrase, $short = false){
        return $this->file[$phrase][$short == true ? 0 : 1];
    }
}