<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/6/16
 * Time: 5:44 PM
 */
namespace Asg\Stemmer\Snowball;

class Among {
    /**
     * @var array;
     * */
    public $s = ''; /* search string */
    /**
     * @var int;
     * */
    public $substring_i; /* index to longest matching substring */
    /**
     * @var int;
     * */
    public $result; /* result of the lookup */
    /**
     * @todo list:
     * @var object
     * */
    public $method; /* method to use if substring matches */
    /**
     * @param string $s;
     * @param int $substring_i;
     * @param int $result;
     * @param string|null $methodname;
     * @param SnowballProgram|null $programclass;
     * */
    function __construct($s, $substring_i, $result, $methodname = null,$programclass = null) {
        $this->s = $s;
        $this->substring_i = $substring_i;
	    $this->result = $result;
	    $this->method = null;
    }
}