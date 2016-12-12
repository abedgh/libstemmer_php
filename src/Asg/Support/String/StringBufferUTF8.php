<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/10/16
 * Time: 11:09 AM
 */

namespace Asg\Support\String;


class StringBufferUTF8 {

    private $encoding = 'UTF-8';


    protected $bufferContainer = [];

    function __construct($string = null)
    {
        $this->set($string);
    }

    /**
     * @return int;
     * */
    public function length(){
        return count($this->bufferContainer);
    }
    /**
     * @param string $string;
     * @return StringBufferUTF8
     * */
    public function set($string)
    {
        if ($string != null && !empty($string)) {
            $string = $this->convertFromUnicodeToHexCode($string);
            $string = $this->convertFromHexCodeToHTMLEntity($string);
            $this->bufferContainer = $this->split($string);
        }
        return $this;
    }
    /**
     * @return string;
     * */
    public function get()
    {
        return implode($this->bufferContainer);
    }
    /**
     * @return string;
     * */
    public function toString(){
        return $this->get();
    }
    /**
     * @param $index;
     * @return string;
     * */
    public function charAt($index){
        if ($index < 0 || $index > $this->length()){
            throw new \OutOfBoundsException("Index out of bounds.");
        }
        return $this->bufferContainer[$index];
    }
    /**
    * @access public
    * @param integer $start The beginning index, inclusive.
    * @param integer|null $end.
    * @param string $string.
    * @throws \OutOfBoundsException
    * @return string
    */
    public function replace($start, $end, $string){
        $start = intval($start);
        $end = intval($end);

        $tmp_start = array();
        $tmp_end = array();

        if($start < 0 || $start > $this->length() || $start > $end) {
            throw new \OutOfBoundsException("Start index is out of bounds.");
        }
        if($end <= $this->length()) {
            $tmp_end = array_slice($this->bufferContainer, $end);
        }

        if($start > 0) {
            $tmp_start = array_slice($this->bufferContainer, 0, $start, true);
        }
        $this->bufferContainer = array_merge($tmp_start, $this->split($string), $tmp_end);
        return $this;
    }
    /**
     * @return string[]
     * */
    public function toChars(){
        return $this->bufferContainer;
    }
    /**
     * @param int $index;
     * @return int;
     * */
    public function charCodeAt($index){
        $c = $this->charAt($index);
        $h = ord($c{0});
        if ($h <= 0x7F) {
            return $h;
        } else if ($h < 0xC2) {
            return false;
        } else if ($h <= 0xDF) {
            return ($h & 0x1F) << 6 | (ord($c{1}) & 0x3F);
        } else if ($h <= 0xEF) {
            return ($h & 0x0F) << 12 | (ord($c{1}) & 0x3F) << 6
            | (ord($c{2}) & 0x3F);
        } else if ($h <= 0xF4) {
            return ($h & 0x0F) << 18 | (ord($c{1}) & 0x3F) << 12
            | (ord($c{2}) & 0x3F) << 6
            | (ord($c{3}) & 0x3F);
        } else {
            return false;
        }
    }
    /**
     * Returns a new string that contains the sub-sequence of characters
     * currently contained in this StringBuffer. The substring begins at the
     * specified $start index and extends to the end of the StringBuffer.
     *
     * @access public
     * @param integer $start The beginning index, inclusive.
     * @param integer|null $end.
     * @throws \OutOfBoundsException
     * @return string
     */
    public function substring($start, $end = null) {
        $start = intval($start);
        if($start < 0 || $start > $this->length()) {
            throw new \OutOfBoundsException("Start index is out of bounds.");
        }
        if($end == null) {
            return implode(array_slice($this->bufferContainer, $start));
        } else {
            $end = intval($end);
            if($start > $end) {
                throw new \OutOfBoundsException("Start index is out of bounds.");
            }

            if($end > $this->length()) {
                $end = $this->length();
            }
            return implode(array_slice($this->bufferContainer, $start, $end-$start));
        }
    }
    /**
     * @todo list:Need to refactor this method;
     * @param string $string;
     * @return string; //hex code;
     * */
    protected function convertFromUnicodeToHexCode($string){

        if ( is_string($string) &&  mb_strlen($string)> 1 && strpos($string,'\u') !== false){
            return preg_replace('/\\\u([0-9a-z]{4})/i', '&#x$1;', $string);
        }
        return $string;
    }
    /**
     * @todo list:Need to refactor this method;
     * @param string $string; //hex code;
     * @return string;
     * */
    protected function convertFromHexCodeToHTMLEntity($string)
    {
        if ( is_string($string) &&  mb_strlen($string)> 1 && strpos($string, '&#x') !== false) {
            $string = mb_convert_encoding($string, $this->encoding, 'HTML-ENTITIES');
        }
        return $string;
    }

    /**
     * Splits a multi-byte string into it's individual characters.
     *
     * @access protected
     * @param string|StringUTF-8 $string
     * @return string[]
     */
    protected function split($string) {
        if ( !empty($string) && is_string($string) ) {
            $string = $this->convertFromUnicodeToHexCode($string);
            $string = $this->convertFromHexCodeToHTMLEntity($string);
        }elseif ($string instanceof $this){
            return $string->toChars();
        }
        $len = mb_strlen($string,$this->encoding);
        $array = [];
        while($len) {
            $array[] = mb_substr($string, 0, 1, $this->encoding);
            $string = mb_substr($string, 1, $len, $this->encoding);
            $len = mb_strlen($string, $this->encoding);
        }
        return $array;
    }

}