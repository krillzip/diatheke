<?php

namespace Krillzip\Diatheke\Cli;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Krillzip\Diatheke\Cli\Helper\DiathekeHelper;
use Krillzip\Biblesheet\Cli\Helper\BiblesheetHelper;
use Krillzip\Diatheke\Cli\Command\DiathekeDiagnoseCommand;
use Krillzip\Diatheke\Cli\Command\DiathekeListCommand;
use Krillzip\Diatheke\Cli\Command\DiathekeConfigCommand;
use Symfony\Component\Console\Application as BaseApplication;
/**
 * Description of Application
 *
 * @author krillzip
 */
class Application extends BaseApplication{
    const NAME = 'Diatheke console';
    const VERSION = '0.1d';
 
    public function __construct()
    {
        $helperSet = $this->getDefaultHelperSet();
        $helperSet->set(new DiathekeHelper());
        $this->setHelperSet($helperSet);
        
        $this->add(new DiathekeDiagnoseCommand());
        $this->add(new DiathekeListCommand());
        $this->add(new DiathekeConfigCommand());
        
        parent::__construct(static::NAME, static::VERSION);
    }
}
