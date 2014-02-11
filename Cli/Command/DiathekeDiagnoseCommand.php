<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
        $d = $this->getHelper('diatheke')->get();
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
