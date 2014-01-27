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
class ReferenceCommand extends Command {

    protected $input;
    protected $output;
    protected $diatheke;

    public function execute(InputInterface $input, OutputInterface $output) {
        $this->input = $input;
        $this->output = $output;
        $this->diatheke = new Diatheke(new Configuration(array(
            'module' => 'SweFolk1998',
            'output' => Diatheke::FORMAT_PLAIN,
            'encoding' => Diatheke::ENCODING_UTF8,
            'locale' => 'sv',
        )));

        $references = $this->readFile();
        $this->extractBibleText($references);
        $this->generateLatex($references);
    }

    protected function readFile($file = 'Helgelse.xlsx') {
        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $reader->setReadDataOnly(true);
        $document = $reader->load($file);
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
                /* if (!empty($value) && $key != 0) {
                  $header = trim(substr($value, 0, strrpos($value, ',')));
                  $book = $this->books[$key];
                  $reference = $book . ' ' . trim(substr($value, strrpos($value, ',')+1));

                  $references[$rowNumber][$book] = array(
                  'header' => $header,
                  'reference' => $reference,
                  );

                  $this->output->writeln($rowNumber . ':' . $key . ':' . $reference . ', ' . $header);

                  unset($col);
                  } */
                $references[$rowNumber] = (object) array(
                            'header' => null,
                            'book' => array_shift($this->diatheke->bibleBook($value)),
                            'reference' => $value,
                );
            }
            unset($cellIterator);
        }

        return array_values($references);
    }

    protected function extractBibleText(array &$references) {


        foreach ($references as $rowNumber => $row) {
            $reference = $row->reference;
            $references[$rowNumber]->text = $this->diatheke->bibleText($reference);
            //$this->output->writeln($d->bibleText($reference));
        }
    }

    protected function generateLatex(array $texts) {
        $t = new I18n('sv');
        ob_start();
        //var_dump($texts);
        include __DIR__ . '/reference_tex_tpl.php';
        $buffer = ob_get_clean();
        file_put_contents('helgelse.tex', $buffer);
    }

}