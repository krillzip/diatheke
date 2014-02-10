<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Diatheke\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Krillzip\Diatheke\Diatheke;

/**
 * Description of DiagnoseCommand
 *
 * @author krillzip
 */
class DiathekeDiagnoseCommand extends Command {

    protected $output = null;
    
    protected function configure() {
        parent::configure();
        $this
                ->setName('diatheke:diagnose')
                ->setDescription('Diagnosing the diatheke install')
                ->setDefinition(array())
                ->setHelp(<<<EOT
The <info>diatheke:diagnose</info> command tests and diagnoses the Diatheke environment
EOT
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $d = new Diatheke();
        $this->output = $output;
        
        $output->writeln('<info>Starting diagnosis...</info>');
        
        $output->writeln('<info>Probing OS for diatheke install</info>');
        
        if($d->isInstalled()){
            $this->printSuccess('Diatheke environment installed');
        }else{
            $this->printError('Diatheke not installed');
            return;
        }
    }
    
    protected function printSuccess($text){
        $this->output->writeln('<fg=white;bg=green>'.$text.'</fg=white;bg=green>');
    }
    
     protected function printError($text){
        $this->output->writeln('<error>'.$text.'</error>');
    }

}
