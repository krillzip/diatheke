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

    /**
     * Remembers if the diatheke unix command is installed. Is static for all
     * class instances to see.
     * @var boolean
     */
    protected static $isInstalled = false;
    
    /**
     * Creates a new instance of the QueryBuilder.
     * @return QueryBuilder 
     */
    public function createQueryBuilder(){
        return new QueryBuilder();
    }
    
    /**
     * Checks if the diatheke unix command is installed.
     * @return boolean 
     */
    public function isInstalled(){
        if(self::$isInstalled === true){
            return true; 
        }
        
        $output = exec('type -P diatheke');
        if(preg_match('/(diatheke)/', $output) === 1){
            self::$isInstalled = true;
            return true;
        }else{
            throw new Exception\NotInstalledException();
            return false;
        }
                
    }
    
    /**
     * Executes the diatheke command at the command line.
     * @param QueryBuilder $query 
     */
    public function execute(QueryBuilder $query){
        echo $query->__toString();
        system(escapeshellcmd($query));
    }
    
    /**
     * Prints a list of all installed modules, names and abbreviations.
     * @return string 
     */
    public function getModules(){
        $qb = $this->createQueryBuilder();
        $qb->module('system')->query('modulelist');
        return $this->execute($qb);
    }
    
    /**
     * Prints a list of all installed modules, abbreviations only.
     * @return string 
     */
    public function getModuleList(){
        $qb = $this->createQueryBuilder();
        $qb->module('system')->query('modulelistnames');
        return $this->execute($qb);
    }
    
    /**
     * Prints a list of all available locales.
     * @return string 
     */
    public function getLocales(){
        $qb = $this->createQueryBuilder();
        $qb->module('system')->query('localelist');
        return $this->execute($qb);
    }
}