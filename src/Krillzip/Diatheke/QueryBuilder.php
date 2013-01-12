<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Diatheke;

/**
 * Description of QueryBuilder
 *
 * @author krillzip
 */
class QueryBuilder {
    
    const SEARCH_REGEX = 'regex';
    const SEARCH_MULTIWORD = 'multiword';
    const SEARCH_PHRASE = 'phrase';
    
    /**
     * @todo Option filter constants
     */
    
    const FORMAT_GBF = 'GBF';
    const FORMAT_THML = 'ThML';
    const FORMAT_RTF = 'RTF';
    const FORMAT_HTML = 'HTML';
    const FORMAT_OSIS = 'OSIS';
    const FORMAT_CGI = 'CGI';
    const FORMAT_PLAIN = 'plain';
    
    const ENCODING_LATIN1 = 'Latin1';
    const ENCODING_UTF8 = 'UTF8';
    const ENCODING_UTF16 = 'UTF16';
    const ENCODING_HTML = 'HTML';
    const ENCODING_RTF = 'RTF';
  
    protected $options = array();
    protected $firstOption;
    protected $lastOption;
    
    protected $searchType = array('regex', 'multiword', 'phrase');
    protected $optionFilters = array('n', 'f', 'm', 'h', 'c', 'v', 'a', 'p',
        'l', 's', 'r', 'b', 'x');
    protected $outputFormat = array('GBF', 'ThML', 'RTF', 'HTML', 'OSIS', 'CGI', 'plain');
    protected $outputEncoding = array('Latin1', 'UTF8', 'UTF16', 'HTML', 'RTF');

    public function module($name) {
        $this->filterInput($name);

        $this->firstOption .= ' -b ' . $name;
        return $this;
    }

    public function search($type) {
        $this->filterInput($type, $this->searchType);

        $this->option['s'] .= ' -s ' . $type;
        return $this;
    }

    public function range($range) {
        $this->filterInput($range);

        $this->option['r'] .= ' -r ' . $range;
        return $this;
    }

    public function filter($options) {
        $this->filterInput($options, $this->optionFilters);

        $this->option['o'] .= ' -o ' . $options;
        return $this;
    }

    public function limit($max) {
        $this->filterInput($max);

        $this->option['m'] .= ' -m ' . $max;
        return $this;
    }

    public function output($format) {
        $this->filterInput($format, $this->outputFormat);

        $this->option['f'] .= ' -f ' . $format;
        return $this;
    }

    public function encoding($enc) {
        $this->filterInput($enc, $this->outputEncoding);

        $this->option['e'] .= ' -e ' . $enc;
        return $this;
    }

    public function script($data) {
        $this->filterInput($data);

        $this->option['t'] .= ' -t ' . $data;
        return $this;
    }

    public function variant($data) {
        $this->filterInput($data);

        $this->option['v'] .= ' -v ' . $data;
        return $this;
    }

    public function locale($data) {
        $this->filterInput($data);

        $this->option['l'] .= ' -l ' . $data;
        return $this;
    }

    public function query($data) {
        $this->filterInput($data);

        $this->lastOption .= ' -k ' . $data;
        return $this;
    }

    public function __toString() {
        if(!isset($this->firstOption)){
            trigger_error('Module must be set in QueryBuilder!');
        }
        if(!isset($this->lastOption)){
            trigger_error('Query must be set in QueryBuilder!');
        }
        return 
                        'diatheke ' .
                        $this->firstOption .
                        implode('', $this->options) .
                        $this->lastOption
        ;
    }

    protected function filterInput($input, array $list = null) {
        if (empty($input)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        if (isset($list) && !in_array($input, $list)) {
            throw new Exception\QueryBuilderException('Expected input value to be one of "' . implode(', ', $list) . '"');
        }
    }

}