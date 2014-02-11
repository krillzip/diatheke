<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
