<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\BibleStudy\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Krillzip\Diatheke\ReferenceBuilder;
use Krillzip\Diatheke\Diatheke;
use Krillzip\Diatheke\Configuration;
use Krillzip\Diatheke\I18n;

/**
 * Description of PrintCommand
 *
 * @author krillzip
 */
class ApocalypseCommand extends Command {

    protected $books = array(
        1 => ReferenceBuilder::_1SAMUEL,
        2 => ReferenceBuilder::_2SAMUEL,
        3 => ReferenceBuilder::_1KINGS,
        4 => ReferenceBuilder::_2KINGS,
        5 => ReferenceBuilder::_1CHRONICLES,
        6 => ReferenceBuilder::_2CHRONICLES,
    );
    protected $input;
    protected $output;

    public function execute(InputInterface $input, OutputInterface $output) {
        $this->input = $input;
        $this->output = $output;

        $references = $this->readFile();
        $this->extractBibleText($references);
        $this->generateLatex($references);
    }

    protected function readFile($file = 'Sluttiden.xlsx') {
        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $reader->setReadDataOnly(true);
        $document = $reader->load('Sluttiden.xlsx');
        $worksheet = $document->setActiveSheetIndex(0);

        $rowIterator = $worksheet->getRowIterator();
        $rowIterator->resetStart(1);

        $references = array();

        foreach ($rowIterator as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->next();
            $rowNumber = $rowIterator->key();
            $references[$rowNumber] = array();

            foreach ($cellIterator as $col) {
                $value = trim($col->getValue());
                $key = $cellIterator->key();

                    $header = trim(substr($value, 0, strrpos($value, ',')));
                    $reference = trim($value);
                    $book = $key;
                    $references[$rowNumber][$book] = array(
                                'header' => $header,
                                'reference' => $reference,
                    );

                    $this->output->writeln($rowNumber . ':' . $key . ':' . $reference . ', ' . $header);

                    unset($col);
                
                $header = trim($value, ',');
                $book = trim(substr(0, strrpos($value, ' ') + 1));
                $reference = $header;

                $references[$rowNumber][$book] = array(
                    'header' => $header,
                    'reference' => $reference,
                );

                $this->output->writeln($rowNumber . ':' . $key . ':' . $reference . ', ' . $header);

                unset($col);
            }
            unset($cellIterator);
        }

        return array_values($references);
    }

    protected function extractBibleText(array &$references) {
        $d = new Diatheke(new Configuration(array(
                            'module' => 'SweFolk1998',
                            'output' => Diatheke::FORMAT_PLAIN,
                            'encoding' => Diatheke::ENCODING_UTF8,
                            'locale' => 'sv',
                        )));

        foreach ($references as $rowNumber => $row) {
            foreach ($row as $book => $passage) {
                $reference = $passage['reference'];
                $this->output->writeln($reference);
                $references[$rowNumber][$book]['text'] = $d->bibleText($reference);
            }
        }
    }

    protected function generateLatex(array $texts) {
        $t = new I18n('sv');
        ob_start();
        include __DIR__ . '/apocalypse_tex_tpl.php';
        $buffer = ob_get_clean();
        file_put_contents('study2.tex', $buffer);
    }

}