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
class PrintCommand extends Command {

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

    protected function readFile($file = 'Bibelns kronologi.xlsx') {
        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $reader->setReadDataOnly(true);
        $document = $reader->load('Bibelns kronologi.xlsx');
        $worksheet = $document->setActiveSheetIndex(1);

        $rowIterator = $worksheet->getRowIterator();
        $rowIterator->resetStart(2);

        $references = array();

        foreach ($rowIterator as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->next();

            $rowNumber = $rowIterator->key();
            $references[$rowNumber] = array();

            foreach ($cellIterator as $col) {
                $value = trim($col->getValue());
                $key = $cellIterator->key();
                if (!empty($value) && $key != 0) {
                    $header = trim(substr($value, 0, strrpos($value, ',')));
                    $book = $this->books[$key];
                    $reference = $book . ' ' . trim(substr($value, strrpos($value, ',')+1));

                    $references[$rowNumber][$book] = array(
                                'header' => $header,
                                'reference' => $reference,
                    );

                    $this->output->writeln($rowNumber . ':' . $key . ':' . $reference . ', ' . $header);

                    unset($col);
                }
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
                //$references[$rowNumber][$book]['text'];
            }
        }
    }
    
    protected function generateLatex(array $texts){
        $t = new I18n('sv');
        ob_start();
        include __DIR__.'/print_tex_tpl.php';
        $buffer = ob_get_clean();
        file_put_contents('study1.tex', $buffer);
    }

}