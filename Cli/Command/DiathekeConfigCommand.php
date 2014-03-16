<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Diatheke\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Krillzip\Diatheke\Diatheke;
use Krillzip\Diatheke\OutputParser;
use Krillzip\Diatheke\Configuration;

/**
 * Description of DiathekeCongigCommand
 *
 * @author krillzip
 */
class DiathekeConfigCommand extends \Symfony\Component\Console\Command\Command {

    protected $config;

    protected function configure() {
        parent::configure();
        $this
                ->setName('diatheke:config')
                ->setDescription('Diatheke configuration through user interaction')
                ->setDefinition(array(
                    new InputOption('export', 'e', InputOption::VALUE_REQUIRED, 'Stream to export information to'),
                ))
                ->setHelp(<<<EOT
The <info>diatheke:config</info> command lets the user set diatheke configuration and export data.
EOT
                )
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output) {
        // Setting up helpers
        $dialog = $this->getHelperSet()->get('dialog');
        $diatheke = $this->getHelper('diatheke')->get();
        $this->config = array();

        // Ask for locale
        $locales = OutputParser::parseModuleList($diatheke->getLocales());
        $locale = $dialog->select(
                $output, 'Select a locale:', $locales
        );
        $this->config['locale'] = $locales[$locale];
        $output->writeln('You choosed: <info>' . $this->config['locale'] . '</info>' . PHP_EOL);

        // Ask for bible
        $data = $diatheke->getModules();
        $structure = OutputParser::parseModules($data);
        $bibleTranslations = array_keys($structure['Biblical Texts']);
        $bibleTranslation = $dialog->select(
                $output, PHP_EOL . 'Select a bible translation:', $bibleTranslations
        );
        $this->config['module'] = $bibleTranslations[$bibleTranslation];
        $output->writeln('You choosed: <info>' . $this->config['module'] . '</info>' . PHP_EOL);

        // Ask for search type
        $searchTypes = Configuration::getSearchType();
        $searchType = $dialog->select(
                $output, 'Select search type:', $searchTypes
        );
        $this->config['search'] = $searchTypes[$searchType];
        $output->writeln('You choosed: <info>' . $this->config['search'] . '</info>' . PHP_EOL);

        /* // Ask for option filters
          $optionFilters = Configuration::getOptionFilters();
          $optionFilter = $dialog->select(
          $output,
          'Select option filter:',
          $optionFilters
          );
          $this->config['filter'] = $optionFilters[$optionFilter];
          $output->writeln('You choosed: <info>'.$this->config['filter'].'</info>'); */

        // Ask for output format
        $outputFormats = Configuration::getOutputFormats();
        $outputFormat = $dialog->select(
                $output, 'Select output format:' . PHP_EOL . '(<comment>or leave empty if you don\'t know what you\'re doing</comment>)', $outputFormats, array_search(Diatheke::FORMAT_PLAIN, $outputFormats)
        );
        $this->config['format'] = $outputFormats[$outputFormat];
        $output->writeln('You choosed: <info>' . $this->config['format'] . '</info>' . PHP_EOL);

        // Ask for output encoding
        $outputEncodings = Configuration::getOutputEncodings();
        $outputEncoding = $dialog->select(
                $output, 'Select output encoding:' . PHP_EOL . '(<comment>or leave empty if you don\'t know what you\'re doing</comment>)', $outputEncodings, array_search(Diatheke::ENCODING_UTF8, $outputEncodings)
        );
        $this->config['encoding'] = $outputEncodings[$outputEncoding];
        $output->writeln('You choosed: <info>' . $this->config['encoding'] . '</info>' . PHP_EOL);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $c = new Configuration($this->config);
        
        $this->getHelper('diatheke')->sendMessage($c->toArray());
    }

}
