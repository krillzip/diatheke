<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Diatheke;

/**
 * Description of Configuration
 *
 * @author krillzip
 */
class Configuration implements \ArrayAccess {

    protected static $searchType = array('regex', 'multiword', 'phrase');
    protected static $optionFilters = array('n', 'f', 'm', 'h', 'c', 'v', 'a',
        'p', 'l', 's', 'r', 'b', 'x');
    protected static $outputFormat = array('GBF', 'ThML', 'RTF', 'HTML',
        'OSIS', 'CGI', 'plain');
    protected static $outputEncoding = array('Latin1', 'UTF8', 'UTF16', 'HTML',
        'RTF');
    protected static $keys = array('module', 'search', 'range', 'filter',
        'limit', 'output', 'format', 'encoding', 'script', 'variant', 'locale');
    protected $options;

    public function __construct(array $config = array()) {
        $config = array_filter($config);
        $diff = array_diff(array_keys($config), self::$keys);

        if (!empty($diff)) {
            throw new Exception\ConfigurationException('Configuration option(s) "' . implode(', ', $diff) . '" is not legal.');
        }

        if (isset($config['search'])) {
            self::validateSearchType($config['search']);
        }

        if (isset($config['filter'])) {
            self::validateOptionFilters($config['filter']);
        }

        if (isset($config['format'])) {
            self::validateOutputFormat($config['format']);
        }

        if (isset($config['encoding'])) {
            self::validateOutputEncoding($config['encoding']);
        }

        $this->options = $config;
    }

    public static function validateSearchType($input) {
        if (!in_array($input, self::$searchType)) {
            throw new Exception\ConfigurationException('Expected input value to be one of "' . implode(', ', self::$searchType) . '"');
        }

        return true;
    }

    public static function validateOptionFilters($input) {
        if (!in_array($input, self::$optionFilters)) {
            throw new Exception\ConfigurationException('Expected input value to be one of "' . implode(', ', self::$optionFilters) . '"');
        }

        return true;
    }

    public static function validateOutputFormat($input) {
        if (!in_array($input, self::$outputFormat)) {
            throw new Exception\ConfigurationException('Expected input value to be one of "' . implode(', ', self::$outputFormat) . '"');
        }

        return true;
    }

    public static function validateOutputEncoding($input) {
        if (!in_array($input, self::$outputEncoding)) {
            throw new Exception\ConfigurationException('Expected input value to be one of "' . implode(', ', self::$outputEncoding) . '"');
        }

        return true;
    }
    
    public static function getSearchType(){
        return self::$searchType;
    }
    
    public static function getOptionFilters(){
        return self::$optionFilters;
    }
    
    public static function getOutputFormats(){
        return self::$outputFormat;
    }
    
    public static function getOutputEncodings(){
        return self::$outputEncoding;
    }

    public function toArray() {
        return $this->options;
    }

    public function offsetExists($offset) {
        return key_exists($this->options, $offset);
    }

    public function offsetGet($offset) {
        return $this->options[$offset];
    }

    public function offsetSet($offset, $value) {
        
    }

    public function offsetUnset($offset) {
        
    }

}
