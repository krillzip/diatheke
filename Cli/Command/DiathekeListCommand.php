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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Krillzip\Diatheke\Diatheke;
use Krillzip\Diatheke\OutputParser;
use Krillzip\Diatheke\Configuration;

/**
 * Description of DiathekeListCommand
 *
 * @author krillzip
 */
class DiathekeListCommand extends Command {

    protected function configure() {
        parent::configure();
        $this
                ->setName('diatheke:list')
                ->setDescription('Lists installed diatheke modules')
                ->setDefinition(array(
                    new InputArgument('list', InputArgument::REQUIRED, '[all|bible|dictionary|commentary|book|locale]'),
                    new InputOption('long', 'l', InputOption::VALUE_NONE, 'Long list (TODO)'),
                    new InputOption('raw', 'r', InputOption::VALUE_NONE, 'Raw output'),
                ))
                ->setHelp(<<<EOT
The <info>diatheke:list</info> command lists installed modules in the diatheke environment
EOT
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $d = $this->getHelper('diatheke')->get();
        $r = $input->getOption('raw');
        $l = $input->getOption('long');

        switch ($input->getArgument('list')) {
            case 'all':
                $data = $d->getModules();
                if ($r) {
                    $output->write($data, false, OutputInterface::OUTPUT_RAW);
                } else {
                    $structure = OutputParser::parseModules($data);
                    $this->printStructure($structure, $output);
                }
                break;
            case 'modules':
                $data = $d->getModuleList();
                if ($r) {
                    $output->write($data, false, OutputInterface::OUTPUT_RAW);
                } else {
                    $structure = OutputParser::parseModuleList($data);
                    $this->printListAsMatrix($structure, $output);
                }
                break;
            case 'bible':
            case 'bibles':
                $data = $d->getModules();
                 $structure = OutputParser::parseModules($data);
                 $output->writeln('<comment>Biblical Texts:</comment>');
                 $this->printList($structure['Biblical Texts'], $output);
                break;
            case 'dictionary':
            case 'dictionaries':
                $data = $d->getModules();
                 $structure = OutputParser::parseModules($data);
                 $output->writeln('<comment>Dictionaries:</comment>');
                 $this->printList($structure['Dictionaries'], $output);
                break;
            case 'commentary':
            case 'commentaries':
                 $data = $d->getModules();
                 $structure = OutputParser::parseModules($data);
                 $output->writeln('<comment>Commentaries:</comment>');
                 $this->printList($structure['Commentaries'], $output);
                break;
            case 'book':
            case 'books':
                $data = $d->getModules();
                $structure = OutputParser::parseModules($data);
                $output->writeln('<comment>Generic books:</comment>');
                $this->printList($structure['Generic books'], $output);
                break;
            case 'locale':
            case 'locales':
                $data = $d->getLocales();
                if ($r) {
                    $output->write($data, false, OutputInterface::OUTPUT_RAW);
                } else {
                    $structure = OutputParser::parseModuleList($data);
                    $this->printListAsMatrix($structure, $output);
                }
                break;
        }
    }

    protected function getLongestName(array $names) {
        if (!empty($names)) {
            return max(array_map('strlen', $names)) + 1;
        } else {
            return 0;
        }
    }

    protected function printStructure(array $structure, OutputInterface $output) {
        foreach ($structure as $name => $section) {
            $output->writeln('<comment>' . $name . ':</comment>');
            if(!empty($section)){
                $this->printList($section, $output);
            }else{
                $output->writeln('   <error>No entries</error>');
            }
        }
    }

    protected function printList(array $list, OutputInterface $output) {
        $longest = $this->getLongestName(array_keys($list));
        foreach ($list as $abbr => $description) {
            $output->writeln('    <info>' . $abbr . '</info>' . str_pad(' ', $longest - strlen($abbr)) . '- ' . $description);
        }
    }
    
    protected function printListAsMatrix(array $list, OutputInterface $output) {
        $longest = $this->getLongestName($list);
        $dim = $this->getApplication()->getTerminalDimensions();
        $rowMax = (int)($dim[0] / $longest);
        
        if($rowMax < 1){
            $rowMax = 1;
        }
        
        while(count($list) > 0){
            $row = '';
            for($i = 0; $i < $rowMax; $i++){
                $abbr = array_shift($list);
                $row .= $abbr.str_pad(' ', $longest - strlen($abbr));
            }
            $output->writeln($row);
        }
    }
}
