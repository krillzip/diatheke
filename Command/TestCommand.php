<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Diatheke\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Krillzip\Diatheke\Diatheke;
use Krillzip\Diatheke\Configuration;

/**
 * Description of TestCommand
 *
 * @author krillzip
 */
class TestCommand extends Command {

    public function execute(InputInterface $input, OutputInterface $output) {
        $factory = new Diatheke(new Configuration(array(
            'module' => 'SweFolk1998',
            'output' => Diatheke::FORMAT_PLAIN,
            'encoding' => Diatheke::ENCODING_UTF8,
            'locale' => 'sv',
        )));
        
        var_dump($factory->bibleText('Ps 23'));
        
    }

}
