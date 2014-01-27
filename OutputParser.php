<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Diatheke;

/**
 * Description of OutputParser
 *
 * @author krillzip
 */
class OutputParser {

    public static function parseSearchResult($output) {
        $matches = array();
        preg_match_all('/ ([\S ]* [0-9]*:[0-9]*) /', $output, $matches);
        return (isset($matches[1])) ? $matches[1] : array();
    }
    
    public static function parsePlainBibleText($output){
        $text = array();
        $output = substr($output, 0, strrpos($output, '('));
        $matches = preg_split('/[\S ]* ([0-9]*):([0-9]*):/', $output, -1, PREG_SPLIT_DELIM_CAPTURE);
        $matches = array_filter($matches);
        
        while(count($matches)){
            $text[] = array(
                'chapter' => array_shift($matches),
                'verse' => array_shift($matches),
                'text' => trim(array_shift($matches)),
            );
        }
        
        return $text;
    }
    
    public static function parsePlainBibleBook($output){
        $matches = array();
        preg_match_all('/([\S ]*) [0-9]*:[0-9]*:/', $output, $matches);
        return (isset($matches[1])) ? $matches[1] : null;
    }

}