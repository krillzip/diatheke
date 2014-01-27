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

    protected $options = array();
    protected $firstOption;
    protected $lastOption;
    protected $searchType = array('regex', 'multiword', 'phrase');
    protected $optionFilters = array('n', 'f', 'm', 'h', 'c', 'v', 'a', 'p',
        'l', 's', 'r', 'b', 'x');
    protected $outputFormat = array('GBF', 'ThML', 'RTF', 'HTML', 'OSIS', 'CGI', 'plain');
    protected $outputEncoding = array('Latin1', 'UTF8', 'UTF16', 'HTML', 'RTF');

    public function __construct(Configuration $config = NULL) {
        if($config !== NULL){
            $config = $config->toArray();
            
            if(isset($config['module'])){
                $this->module($config['module']);
            }
            
            if(isset($config['search'])){
                $this->search($config['search']);
            }
            
            if(isset($config['range'])){
                $this->range($config['range']);
            }
            
            if(isset($config['filter'])){
                $this->filter($config['filter']);
            }
            
            if(isset($config['limit'])){
                $this->limit($config['limit']);
            }
            
            if(isset($config['output'])){
                $this->output($config['output']);
            }
            
            if(isset($config['encoding'])){
                $this->encoding($config['encoding']);
            }
            
            if(isset($config['script'])){
                $this->script($config['script']);
            }
            
            if(isset($config['variant'])){
                $this->variant($config['variant']);
            }
            
            if(isset($config['locale'])){
                $this->locale($config['locale']);
            }
        }
    }

    public function module($name) {
        if (empty($name)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        $this->firstOption = ' -b ' . $name;
        return $this;
    }

    public function search($type) {
        if (empty($type)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }
        Configuration::validateSearchType($type);

        $this->options['s'] = ' -s ' . $type;
        return $this;
    }

    public function range($range) {
        if (empty($range)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        $this->options['r'] = ' -r ' . $range;
        return $this;
    }

    public function filter($options) {
        if (empty($options)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }
        Configuration::validateOptionFilters($options);

        $this->options['o'] = ' -o ' . $options;
        return $this;
    }

    public function limit($max) {
        if (empty($max)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        $this->options['m'] = ' -m ' . $max;
        return $this;
    }

    public function output($format) {
        if (empty($format)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }
        Configuration::validateOutputFormat($format);

        $this->options['f'] = ' -f ' . $format;
        return $this;
    }

    public function encoding($enc) {
        if (empty($enc)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }
        Configuration::validateOutputEncoding($enc);

        $this->options['e'] = ' -e ' . $enc;
        return $this;
    }

    public function script($data) {
        if (empty($data)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        $this->options['t'] = ' -t ' . $data;
        return $this;
    }

    public function variant($data) {
        if (empty($input)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        $this->options['v'] = ' -v ' . $data;
        return $this;
    }

    public function locale($data) {
        if (empty($data)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        $this->options['l'] = ' -l ' . $data;
        return $this;
    }

    public function query($data) {
        if (empty($data)) {
            throw new Exception\QueryBuilderException('Input value cannot be empty!');
        }

        $this->lastOption = ' -k ' . $data;
        return $this;
    }

    public function __toString() {
        if (!isset($this->firstOption)) {
            trigger_error('Module must be set in QueryBuilder!');
        }
        if (!isset($this->lastOption)) {
            trigger_error('Query must be set in QueryBuilder!');
        }
        return
                'diatheke ' .
                $this->firstOption .
                implode('', $this->options) .
                $this->lastOption
        ;
    }

}