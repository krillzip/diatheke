<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Diatheke;

/**
 * Diatheke is the main class in the library.
 * 
 * @author krillzip
 */
class Diatheke {
    
    const SEARCH_REGEX = 'regex';
    const SEARCH_MULTIWORD = 'multiword';
    const SEARCH_PHRASE = 'phrase';

    /**
     * @todo Option filter constants
     */
    const FORMAT_GBF = 'GBF';
    const FORMAT_THML = 'ThML';
    const FORMAT_RTF = 'RTF';
    const FORMAT_HTML = 'HTML';
    const FORMAT_OSIS = 'OSIS';
    const FORMAT_CGI = 'CGI';
    const FORMAT_PLAIN = 'plain';

    const ENCODING_LATIN1 = 'Latin1';
    const ENCODING_UTF8 = 'UTF8';
    const ENCODING_UTF16 = 'UTF16';
    const ENCODING_HTML = 'HTML';
    const ENCODING_RTF = 'RTF';
    
    protected $config;

    /**
     * Remembers if the diatheke unix command is installed. Is static for all
     * class instances to see.
     * @var boolean
     */
    protected static $isInstalled = false;
    
    public function __construct(Configuration $config = NULL){
        $this->config = $config;
    }
    
    /**
     * Creates a new instance of the QueryBuilder.
     * @return QueryBuilder 
     */
    public function createQueryBuilder($empty = false){
        if($empty){
            return new QueryBuilder();
        }else{
            return new QueryBuilder($this->config);
        }
    }
    
    /**
     * Checks if the diatheke unix command is installed.
     * @return boolean 
     */
    public function isInstalled(){
        if(self::$isInstalled === true){
            return true; 
        }
        
        exec('type diatheke', $output, $returnVal);
        var_dump($output, $returnVal);
        if($returnVal === 0){
            self::$isInstalled = true;
            return true;
        }else{
            return false;
        }
                
    }
    
    /**
     * Executes the diatheke command at the command line.
     * @param QueryBuilder $query 
     */
    public function execute(QueryBuilder $query){
        $cmd = escapeshellcmd($query->__toString());
        return `$cmd`;
    }
    
    /**
     * Prints a list of all installed modules, names and abbreviations.
     * @return string 
     */
    public function getModules(){
        $qb = $this->createQueryBuilder(false);
        $qb->module('system')->query('modulelist');
        return $this->execute($qb);
    }
    
    /**
     * Prints a list of all installed modules, abbreviations only.
     * @return string 
     */
    public function getModuleList(){
        $qb = $this->createQueryBuilder(false);
        $qb->module('system')->query('modulelistnames');
        return $this->execute($qb);
    }
    
    /**
     * Prints a list of all available locales.
     * @return string 
     */
    public function getLocales(){
        $qb = $this->createQueryBuilder(false);
        $qb->module('system')->query('localelist');
        return $this->execute($qb);
    }
    
    public function bibleText($reference){
        $qb = $this->createQueryBuilder();
        $qb->query($reference);
        return OutputParser::parsePlainBibleText($this->execute($qb));
    }
    
    public function bibleBook($reference){
        $qb = $this->createQueryBuilder();
        $qb->query($reference);
        return OutputParser::parsePlainBibleBook($this->execute($qb));
    }
}
