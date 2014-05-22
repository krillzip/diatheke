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
use Symfony\Component\Console\Output\OutputInterface;

use Krillzip\Diatheke\Diatheke;
use Krillzip\Diatheke\Configuration;

/**
 * Description of TestCommand
 *
 * @author krillzip
 */
class TestCommand extends Command {
    
    protected function configure() {
        parent::configure();
        $this
                ->setName('diatheke:test')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output) {
        $factory = new Diatheke(new Configuration(array(
            'module' => 'KJV',
            'output' => Diatheke::FORMAT_PLAIN,
            'filter' => 'n',
            'encoding' => Diatheke::ENCODING_UTF8,
            'locale' => 'en',
        )));
        
        var_dump($factory->bibleText('Gen 1'));
        
    }

}
