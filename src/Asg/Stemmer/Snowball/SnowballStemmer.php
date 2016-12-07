<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/6/16
 * Time: 5:51 PM
 */

namespace Asg\Stemmer\Snowball;

abstract class SnowballStemmer extends SnowballProgram{
    /**
     * @return bool;
     * */
    public abstract function stem();
}