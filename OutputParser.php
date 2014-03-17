<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
        preg_match('/([\S ]*) [0-9]*:[0-9]*:/', $output, $matches);
        return (isset($matches[1])) ? $matches[1] : null;
    }
    
    public static function parseModules($output){
         $data = explode(PHP_EOL, $output);
         $headline = null;
         $structure = array();
         foreach($data as $row){
             if(strlen($row) == 0){
                 continue;
             }
             if(preg_match('/^[\S ]*:$/', $row)){
                 $headline = substr($row, 0, strlen($row)-1);
                 $structure[$headline] = array();
             }else{
                 $split = explode(':', $row);
                 if(is_null($headline)){
                     $structure[trim($split[0])] = trim($split[1]);
                 }else{
                     $structure[$headline][trim($split[0])] = trim($split[1]);
                 }
             }
         }
         return $structure;
    }
    
    public static function parseModuleList($output){
         $data = explode(PHP_EOL, $output);
         return array_filter($data);
    }

}
