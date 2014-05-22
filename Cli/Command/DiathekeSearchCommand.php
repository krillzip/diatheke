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
use Symfony\Component\Console\Input\InputOption;
use Krillzip\Diatheke\Diatheke;

/**
 * Description of DiathekeSearchCommand
 *
 * @author krillzip
 */
class DiathekeSearchCommand extends Command {
    
    const TEXTUS_REEPTUS = 'TR';
    const BYZANTINE = 'Byz';
    const STRONGS_NT = 'StrongsGreek';
    const STRONGS_OT = 'StrongsHebrew';
    const STRONGS_REGEX = '/^(?P<lang>[H|h|G|g])(?P<num>\d+)$/';

    protected function configure() {
        parent::configure();
        $this
                ->setName('diatheke:search')
                ->setDescription('Searching in greek')
                ->setDefinition(array())
                ->addOption('query', 'k', InputOption::VALUE_OPTIONAL, 'Use search term for current translation')
                ->addOption('strongs', 's', InputOption::VALUE_OPTIONAL, 'Use search term in greek')
                ->setHelp(<<<EOT
The <info>diatheke:search</info> command searches a bible translation for a specific word and returns the result
EOT
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $d = $this->getHelper('diatheke')->get();
        $matches = array();
        $strongs = $input->getOption('strongs');
        $query = $input->getOption('query');
        
        if(!empty($strongs)){
            preg_match(self::STRONGS_REGEX, $strongs, $matches);
            $number = (int) $matches['num'];
            $language = trim(strtoupper($matches['lang']));
            switch($language){
                case 'H':
                    $module = self::STRONGS_OT;
                    break;
                case 'G':
                    $module = self::STRONGS_NT;
                    break;
            }
            
            $modules = array_filter(explode(PHP_EOL, $d->getModuleList()));
        }
        
        /*$qb = $d->createQueryBuilder();
        
        $query
        
        $output->writeln($strongs.' - '.$query);*/
    }

}
