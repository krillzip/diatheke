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

/**
 * Description of TestCommand
 *
 * @author krillzip
 */
class TestCommand extends Command {

    public function execute(InputInterface $input, OutputInterface $output) {
        $factory = new Diatheke();
        if ($factory->isInstalled()) {
            $output->writeln('Diatheke is installed!');
        }
        
        $output->write($factory->getLocales());
    }

}
