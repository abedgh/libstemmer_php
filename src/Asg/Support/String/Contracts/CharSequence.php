<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/7/16
 * Time: 11:28 AM
 */

namespace Asg\Support\String\Contracts;

interface CharSequence {
    /**
     * @param int $index;
     * @return string|null;
     * */
    public function charAt($index);
    /**
     * @return int;
     * */
    public function length();

    /**
     * @return string;
     * */
    public function toString();
}