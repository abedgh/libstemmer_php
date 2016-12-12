<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/6/16
 * Time: 5:57 PM
 */

namespace Asg\Support\String;

class StringBuffer {

    /**
     * The string buffer holding the initial string.
     *
     * @access private
     * @var string[];
     */
    private $buffer;

    /**
     * @param mixed|null $arg ;
     * Object constructor.
     * @throws \OutOfBoundsException
     * @throws \RuntimeException
     * @access public
     */
    public function __construct($arg = null) {
        $this->buffer =[];

        if(is_null($arg)) {
            $this->buffer = [];
        }
        /*
         * If parameter is an integer set the buffer this long.
         * Length cannot be less than 0.
         */
        if(is_int($arg)) {
            if($arg < 0) {
                throw new \OutOfBoundsException("Buffer length cannot be less then 0.");
            }

            $this->buffer = array_fill(0, $arg, "");
        }

        if(is_string($arg)) {
            if($arg == "") {
                throw new \RuntimeException("Parameter string cannot be empty");
            }

            $this->buffer = $this->split($arg);
        }

    }

    /**
     * Splits a multibyte string into it's individual characters.
     *
     * @access private
     * @param string $str
     * @return string[]
     */
    private function split($str) {
        $len = mb_strlen($str, "UTF-8");
        $array = array();

        while($len) {
            $array[] = mb_substr($str, 0, 1, "UTF-8");
            $str = mb_substr($str, 1, $len, "UTF-8");
            $len = mb_strlen($str, "UTF-8");
        }

        return $array;
    }

    /**
     * Returns the length of the buffer
     *
     * @access public
     * @return integer
     */
    public function length() {
        return count($this->buffer);
    }

    /**
     * Set the buffer's length.
     *
     * For every nonnegative index k less than $new_length, the character at
     * index k in the new character sequence is the same as the character at
     * index k in the old sequence if k is less than the length of the old
     * character sequence; otherwise it is the "" character.
     * In other words, if the $new_length argument is less than the current
     * length of the string buffer, the string buffer is truncated to contain
     * exactly the number of characters given by the $new_length argument.
     *
     * @access public
     * @param integer $new_length
     * @return void
     */
    public function setLength($new_length) {
        if($new_length < $this->length()) {
            $this->buffer = array_slice($this->buffer, 0, $new_length);
        } else {
            $filler = array_fill(0, $new_length - count($this->buffer), "");
            $this->buffer = array_merge($this->buffer, $filler);
        }

    }

    /**
     * The specified character of the sequence currently represented by the
     * string buffer, as indicated by the $idx argument, is returned.
     * The first character of the string buffer is at index 0.
     *
     * The index argument must be greater than or equal to 0, and less than the
     * length of this string buffer.
     */
    public function charAt($idx) {
        if($idx < 0 || $idx > $this->length()) {
            throw new \OutOfBoundsException("Index out of bounds.");
        }
        return $this->buffer[$idx];
    }

    /**
     * @param int $index;
     * @return int;
     * @throws \OutOfBoundsException
     * */
    public function charCodeAt($index){
        if($index < 0 || $index > $this->length()) {
            throw new \OutOfBoundsException("Index out of bounds.");
        }
        $k = mb_convert_encoding($this->buffer[$index], 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
    }
    /**
     * Characters are copied from this string buffer into the destination
     * array $dst. The first character to be copied is at index $src_begin;
     * the last character to be copied is at index $src_end - 1. The total
     * number of characters to be copied is $src_end - $src_begin. The
     * characters are copied into the subarray of $dst starting at index
     * $dst_begin and ending at index: $dst_begin + ($src_end - $src_begin) - 1
     *
     * @access public
     * @param integer $src_begin
     * @param integer $src_end
     * @param string[] $dst
     * @param integer $dst_begin
     * @return void
     */
    public function getChars($src_begin, $src_end, &$dst, $dst_begin) {
        if($src_begin < 0) {
            throw new \OutOfBoundsException("src_begin cannot be negative.");
        }

        if($src_end < 0) {
            throw new \OutOfBoundsException("src_end cannot be negative.");
        }

        if($src_end < $src_begin) {
            throw new \OutOfBoundsException("src_begin cannot be greater than src_end.");
        }

        if($src_end > $this->length()) {
            throw new \OutOfBoundsException("src_end cannot be greater than the buffer length.");
        }

        if(is_null($dst)) {
            throw new \RuntimeException("dst cannot be null.");
        }

        for($i = $src_begin; $i < $src_end; $i++) {
            $dst[$dst_begin] = $this->buffer[$i];
            $dst_begin += $i;
        }
    }

    /**
     * The character at the specified index of this string buffer is set to $chr.
     * The string buffer is altered to represent a new character sequence that
     * is identical to the old character sequence, except that it contains the
     * character $chr at position $idx.
     *
     * @access public
     * @param integer $idx
     * @param char $chr
     * @throws OutOfBoundsException
     * @see length()
     * @return void
     */
    public function setCharAt($idx, $chr) {
        if($idx < 0 || $idx > $this->length()) {
            throw new \OutOfBoundsException("Index out of bounds.");
        }

        $this->buffer[$idx] = $chr;
    }

    /**
     * Convert the contents of the buffer into a string
     *
     * @access public
     * @return string
     */
    public function toString() {
        return implode($this->buffer);
    }

    /**
     * Decide what type of append we want to do.
     *
     * @access private
     * @return StringBuffer
     */
    private function &check_append(&$arg) {

        if($arg instanceof StringBuffer) {
            return $this->append_string_buffer($arg);
        }

        if(is_object($arg)) {
            return $this->append_object($arg);
        }

        if(is_array($arg)) {
            return $this->append_array($arg);
        }

        if(is_int($arg)) {
            return $this->append_int($arg);
        }

        if(is_float($arg)) {
            return $this->append_float($arg);
        }

        if(is_string($arg)) {
            return $this->append_str($arg);
        }
    }

    /**
     * Appends the string $str to this string buffer.
     *
     * The characters of the $str argument are appended, in order, to the
     * contents of this string buffer, increasing the length of this string
     * buffer by the length of the argument.
     *
     * @access private
     * @param string $str
     * @return StringBuffer
     */
    private function &append_str($str) {
        $tmp = $this->split($str);

        $this->buffer = array_merge($this->buffer, $tmp);

        return $this;
    }

    /**
     * Appends the string representation of the $obj argument to this string
     * buffer.
     *
     * The argument is converted to a string as if by the method $obj->__toString(),
     * and the characters of that string are then appended to this string buffer.
     *
     * @access private
     * @param object $obj
     * @return StringBuffer
     */
    private function &append_object(&$obj) {
        $tmp = call_user_func(array(&$obj, "__toString"));

        return $this->append_str($tmp);
    }

    /**
     * Appends the specified StringBuffer to this StringBuffer.
     *
     * The characters of the StringBuffer argument are appended, in order, to
     * the contents of this StringBuffer, increasing the length of this
     * StringBuffer by the length of the argument.
     *
     * @access private
     *
     */
    private function &append_string_buffer(&$sb) {
        return $this->append_str($sb);
    }

    /**
     * Appends the string representation of the $array argument to this string
     * buffer.
     *
     * The characters of the array argument are appended, in order, to the
     * contents of this string buffer. The length of this string buffer increases
     * by the length of the argument.
     *
     * @access private
     * @param char[] $array
     * @return StringBuffer
     */
    private function &append_array($array) {
        return $this->append_str(implode($array));
    }

    /**
     * Appends the string representation of the int $i argument to this string
     * buffer.
     *
     * @access private
     * @param integer $i
     * @see appent_number()
     * @return StringBuffer
     */
    private function &append_int($i) {
        return $this->append_number($i);
    }

    /**
     * Appends the string representation of the float $f argument to this string
     * buffer.
     *
     * @access private
     * @param float $f
     * @see append_number()
     * @return StringBuffer
     */
    private function &append_float($f) {
        return $this->append_number($f);
    }

    /**
     * Appends the string representation of $n to this string buffer.
     *
     * @access private
     * @param number $n
     * @return StringBuffer
     */
    private function &append_number($n) {
        return $this->append_str((string) $n);
    }

    /**
     * Removes the characters in a substring of this StringBuffer. The substring
     * begins at the specified $start and extends to the charactar index $end - 1
     * or to the end of the StringBuffer if no such character exists. If $start
     * is equal to $end, no changes are made.
     *
     * @access public
     * @param integer $start The beginning index, inclusive.
     * @param integer $end The ending index, exclusive.
     * @throws \OutOfBoundsException
     * @return StringBuffer
     */
    public function &delete($start, $end) {
        $start = intval($start);
        $end = intval($end);
        $tmp = array();


        if($start == $end) {
            return $this;
        }

        if($start < 0 || $start > $this->length() || $start > $end) {
            throw new \OutOfBoundsException("Start index is out of bounds.");
        }

        if($end > $this->length()) {
            $end = $this->length();
        }

        array_splice($this->buffer, $start, $end-$start);

        return $this;
    }

    /**
     * Removes the character at the specified position in this StringBuffer
     * (shortening the buffer by one character).
     *
     * @access public
     * @param integer $idx Index of character to remove
     * @throws \OutOfBoundsException
     * @return StringBuffer
     */
    public function &delete_char_at($idx) {
        if($idx < 0 || $idx > $this->length()) {
            throw new \OutOfBoundsException("Index is out of bounds.");
        }

        return $this->delete($idx, $idx + 1);
    }

    /**
     * Replaces the characters in a substring of this StringBuffer with
     * characters in the specified $str string. The substring begins at the
     * specified $start and extends to the character at index $end -1 or to the
     * end of the StringBuffer if no such character exists. First the characters
     * in the substring are removed and then the specified $str string is
     * inserted at $start. (The StringBuffer will be lengthened to accomodate
     * the specified $str string if necessary.)
     *
     * @access public
     * @param integer $start The beginning index, inclusive.
     * @param integer $end The ending index, exclusive.
     * @param string $str String that will replace previous contents.
     * @throws \OutOfBoundsException
     * @return StringBuffer
     */
    public function &replace($start, $end, $str) {
        $start = intval($start);
        $end = intval($end);

        $tmp_start = array();
        $tmp_end = array();


        if($start < 0 || $start > $this->length() || $start > $end) {
            throw new \OutOfBoundsException("Start index is out of bounds.");
        }

        if($end <= $this->length()) {
            $tmp_end = array_slice($this->buffer, $end);
        }

        if($start > 0) {
            $tmp_start = array_slice($this->buffer, 0, $start, true);
        }

        $this->buffer = array_merge($tmp_start, $this->split($str), $tmp_end);
        return $this;
    }

    /**
     * Returns a new string that contains the subsequence of characters
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
            return implode(array_slice($this->buffer, $start));
        } else {
            $end = intval($end);

            if($start > $end) {
                throw new \OutOfBoundsException("Start index is out of bounds.");
            }

            if($end > $this->length()) {
                $end = $this->length();
            }

            return implode(array_slice($this->buffer, $start, $end-$start));
        }
    }

    /**
     * Check which insert function to call based on the argument.
     *
     * @access private
     * @param mixed $arg
     * @return StringBuffer
     */
    private function check_insert($arg) {

        if(is_numeric($arg[1])) {
            return $this->insert_number($arg[0], $arg[1]);
        }

        if(is_array($arg[1])) {
            return $this->insert_array($arg[0], $arg[1]);
        }

        if(is_object($arg[1])) {
            return $this->insert_object($arg[0], $arg[1]);
        }

        if(is_string($arg[1]) || is_null($arg[1])) {
            return $this->insert_str($arg[0], $arg[1]);
        }
    }

    /**
     * Insert the string $str into this StringBuffer.
     *
     * The characters of the string argument are inserted, in order, into this
     * string buffer at the indicated offset, moving up any characters originally
     * above that position and increasing the length of this string buffer by the
     * length of the argument. If $str is null, then the four characters "null"
     * are inserted into this string buffer.
     *
     * The $offset argument must be greater than or equal to 0, and less than or
     * equal to the length of this string buffer.
     *
     * @access public
     * @param integer $offset the offset.
     * @param string $str a string.
     * @throws OutOfBoundsException
     * @return StringBuffer
     */
    private function &insert_str($offset, &$str) {
        if(is_null($str)) {
            $str = mb_convert_encoding("ASCII","UTF-8","null");
        }

        $tmp_start = array();
        $tmp_end = array();

        $offset = intval($offset);

        if($offset < 0 || $offset > $this->length()) {
            throw new \OutOfBoundsException("Offset is out of bounds.");
        }
        $tmp_start = array_slice($this->buffer, 0, $offset);
        $tmp_end = array_slice($this->buffer, $offset);

        $this->buffer = array_merge($tmp_start, str_split($str), $tmp_end);
        return $this;
    }

    /**
     * Inserts the string representation of the $obj argument into this string
     * buffer.
     *
     * The second argument is converted to a string as if by the method $obj->__toString(),
     * and the characters of that string are then inserted into this string buffer
     * at the indicated offset.
     *
     * The offset argument must be greater than or equal to 0, and less then or
     * equal to the length of this string buffer.
     *
     * @access private
     * @param integer $offset the offest.
     * @param object $obj an Object.
     * @throws OutOfBoundsException
     * @return StringBuffer
     */
    private function &insert_object($offset, &$obj) {
        $str = call_user_func(array($obj, "__toString"));

        return $this->insert_str($offset, $str);
    }

    /**
     * Inserts the string representation of the $array argument into this
     * string buffer.
     *
     * The characters of the array argument are inserted into the contents of
     * this string buffer at the position indicated by the offset. The length
     * of this string buffer increases by the length of the argument.
     *
     * @access public
     * @param integer $offset the offset.
     * @param char[] $array a character array.
     * @throws OutOfBoundsException
     * @return StringBuffer
     */
    private function &insert_array($offset, $array) {
        $str = implode($array);

        return $this->insert_str($offset, $str);
    }

    /**
     * Inserts the string representation of the $n argument into
     * this sequence.
     *
     * The second argument is converted to a string, and the characters
     * of that string are then inserted into this sequence at the indicated
     * offset.
     *
     * The offset argument must be greater than or equal to 0, and less
     * than or equal to the length of this sequence.
     *
     * @access public
     * @param integer $offset
     * @param mixed $n
     * @throws OutOfBoundsException
     * @return StringBuffer
     */
    private function &insert_number($offset, $n) {
        $n = (string) intval($n);

        return $this->insert_str($offset, $n);
    }

    /**
     * Returns the index withing this string of the first occurance of the
     * specified substring, starting at the specified index. If index $idx is
     * ommited then it starts searching from the begining of the string.
     *
     * If no occurance is found then returns -1 else returns the index
     * of the first character of the substring.
     *
     * @access public
     * @param string $str The string we are looking for.
     * @param integer $idx
     * @throws OutOfBoundsException
     * @return integer
     */
    public function index_of($str, $idx = 0) {
        $index = mb_strpos($this->toString(), $str, $idx, "UTF-8");

        if($index === false) {
            $index = -1;
        }

        return $index;
    }

    /**
     * Returns the index within this string of the last occurrence of the
     * specified substring.
     *
     * If no occurrance is found then returns -1.
     *
     * @access public
     * @param string $str The string we are looking for.
     * @param integer $offset
     *
     */
    public function last_index_of($str, $offset = 0) {

        $offset = intval($offset);

        $index = mb_strrpos($this->toString(), $str, $offset, "UTF-8");

        if($index === false) {
            $index = -1;
        }

        return $index;
    }

    /**
     * Causes this character sequence to be replaced by the reverse of the sequence.
     *
     * @access public
     * @return StringBuffer
     */
    public function &reverse() {
        $tmp = array();

        for($i = $this->length() - 1; $i >= 0; $i-- ) {
            $tmp[] = $this->charAt($i);
        }

        $this->buffer = $tmp;

        return $this;
    }

    /**
     * Function overloading the PHP way.
     *
     * @access public
     * @throws \BadFunctionCallException
     * @return mixed
     */
    public function &__call($method, $arg) {
        switch($method) {
            case 'append':
                return $this->check_append($arg[0]);
                break;
            case 'insert':
                return $this->check_insert($arg);
                break;
            default:
                throw new \BadFunctionCallException("Function $method is not supported.");
        }
    }
}