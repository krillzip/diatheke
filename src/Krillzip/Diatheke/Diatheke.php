<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Diatheke;

/**
 * Description of Diatheke
 *
 * @author krillzip
 */
class Diatheke {

    public function createQueryBuilder(){
        return new QueryBuilder();
    }
    
    public function isInstalled(){
        $output = exec('type -P diatheke');
        if(preg_match('/(diatheke)/', $output) === 1){
            return true;
        }else{
            throw new Exception\NotInstalledException();
            return false;
        }
                
    }
    
    public function execute(QueryBuilder $query){
        system(escapeshellcmd($query));
    }
}