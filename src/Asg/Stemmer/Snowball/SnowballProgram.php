<?php
/**
 * Created by PhpStorm.
 * User: Abed Ghazaleh
 * Email : abed.gh@gmail.com
 * Date: 12/6/16
 * Time: 5:52 PM
 *
 */

namespace Asg\Stemmer\Snowball;

use Asg\Support\String\StringBuffer;
use Asg\Support\String\Contracts\CharSequence;
use Asg\Stemmer\Snowball\Exceptions\InvocationTargetException;
use Asg\Stemmer\Snowball\Exceptions\IllegalAccessException;

class SnowballProgram
{
    /**
     * PHP Snowball version.
     *
     * @var string
     */
    const VERSION = '1.0';

    // current string
    /**
     * @var StringBuffer
     * */
    protected $current;
    /**
     * @var int
     * */
    protected $cursor;
    /**
     * @var int
     * */
    protected $limit;
    /**
     * @var int
     * */
    protected $limit_backward;
    /**
     * @var int
     * */
    protected $bra;
    /**
     * @var int
     * */
    protected $ket;

    protected function __construct()
    {
        $this->current = new StringBuffer();
        $this->setCurrent('');
    }

    /**
     * Set the current string.
     * @param string $value ;
     */
    public function setCurrent($value)
    {
        $this->current->replace(0, $this->current->length(), $value);
        $this->cursor = 0;
        $this->limit = $this->current->length();
        $this->limit_backward = 0;
        $this->bra = $this->cursor;
        $this->ket = $this->limit;
    }

    /**
     * Get the current string.
     * @return string;
     */
    public function getCurrent()
    {
        $result = $this->current->toString();
        $this->current = new StringBuffer();
        return $result;
    }

    protected function copy_from(SnowballProgram $other)
    {
        $this->current = $other->current;
        $this->cursor = $other->cursor;
        $this->limit = $other->limit;
        $this->limit_backward = $other->limit_backward;
        $this->bra = $other->bra;
        $this->ket = $other->ket;
    }

    /**
     * @todo list
     * @param array $s ;
     * @param int $min ;
     * @param int $max ;
     * @return bool;
     * */
    protected function in_grouping($s, $min, $max)
    {
        if ($this->cursor >= $this->limit) return false;
        $ch = $this->current->charAt($this->cursor);
        if ($ch > $max || $ch < $min) return false;
        $ch -= $min;
        if (($s[$ch >> 3] & (0X1 << ($ch & 0X7))) == 0) return false;
        $this->cursor++;
        return true;
    }

    /**
     * @todo list
     * @param array $s ;
     * @param int $min ;
     * @param int $max ;
     * @return bool;
     * */
    protected function in_grouping_b($s, $min, $max)
    {
        if ($this->cursor <= $this->limit_backward) return false;
        $ch = $this->current->charAt($this->cursor - 1);
        if ($ch > $max || $ch < $min) return false;
        $ch -= $min;
        if (($s[$ch >> 3] & (0X1 << ($ch & 0X7))) == 0) return false;
        $this->cursor--;
        return true;
    }

    /**
     * @todo list
     * @param array $s ;
     * @param int $min ;
     * @param int $max ;
     * @return bool;
     * */
    protected function out_grouping($s, $min, $max)
    {
        if ($this->cursor >= $this->limit) return false;
        $ch = $this->current->charAt($this->cursor);
        if ($ch > $max || $ch < $min) {
            $this->cursor++;
            return true;
        }
        $ch -= $min;
        if (($s[$ch >> 3] & (0X1 << ($ch & 0X7))) == 0) {
            $this->cursor++;
            return true;
        }
        return false;
    }

    /**
     * @todo list
     * @param array $s ;
     * @param int $min ;
     * @param int $max ;
     * @return bool;
     * */
    protected function out_grouping_b($s, $min, $max)
    {
        if ($this->cursor <= $this->limit_backward) return false;
        $ch = $this->current->charAt($this->cursor - 1);
        if ($ch > $max || $ch < $min) {
            $this->cursor--;
            return true;
        }
        $ch -= $min;
        if (($s[$ch >> 3] & (0X1 << ($ch & 0X7))) == 0) {
            $this->cursor--;
            return true;
        }
        return false;
    }

    /**
     * @todo list:need to fix the CharSequence
     * @param string|CharSequence $s //CharSequence Interface
     * @return bool;
     */
    protected function eq_s(CharSequence $s)
    {
        if ($this->limit - $this->cursor < $s->length()) return false;

        for ($i = 0; $i != $s->length(); $i++) {
            if ($this->current->charAt($this->cursor + $i) != $s->charAt($i)) return false;
        }
        $this->cursor += $s->length();
        return true;
    }

    /**
     * @todo list:need to fix the CharSequence
     * @param string|CharSequence $s
     * @return bool;
     */
    protected function eq_s_b(CharSequence $s)
    {
        if ($this->cursor - $this->limit_backward < $s->length()) return false;

        for ($i = 0; $i != $s->length(); $i++) {
            if ($this->current->charAt($this->cursor - $s->length() + $i) != $s->charAt($i)) return false;
        }
        $this->cursor -= $s->length();
        return true;
    }

    /**
     * @todo list: must check the invoke method part;
     * @param array<Among> $v
     * @return int;
     * */
    protected function find_among($v)
    {
        $i = 0;
        $j = count($v);
        $c = $this->cursor;
        $l = $this->limit;
        $common_i = 0;
        $common_j = 0;
        $first_key_inspected = false;
        while (true) {
            $k = $i + (($j - $i) >> 1);
            $diff = 0;
            $common = $common_i < $common_j ? $common_i : $common_j; // smaller
            $w = $v[$k]; //return Among
            for ($i2 = $common; $i2 < count($w->s); $i2++) {
                if ($c + $common == $l) {
                    $diff = -1;
                    break;
                }
                $diff = $this->current->charAt($c + $common) - $w->s[$i2];
                if ($diff != 0) break;
                $common++;
            }
            if ($diff < 0) {
                $j = $k;
                $common_j = $common;
            } else {
                $i = $k;
                $common_i = $common;
            }
            if ($j - $i <= 1) {
                if ($i > 0) break; // v->s has been inspected
                if ($j == $i) break; // only one item in v
                // - but now we need to go round once more to get
                // v->s inspected. This looks messy, but is actually
                // the optimal approach.
                if ($first_key_inspected) break;
                $first_key_inspected = true;
            }
        }
        while (true) {
            $w = $v[$i]; //return Among
            if ($common_i >= count($w->s)) {
                $this->cursor = $c + count($w->s);
                if ($w->method == null) return $w->result;
                $res = false;
                try {
                    //Object
                    $resobj = $w->method->invoke($this);
                    $res = $resobj->toString()->equals("true");
                } catch (InvocationTargetException $e) {
                    $res = false;
                    // FIXME - debug message
                } catch (IllegalAccessException $e) {
                    $res = false;
                    // FIXME - debug message
                }
                $this->cursor = $c + $w->s->length;
                if ($res) return $w->result;
            }
            $i = $w->substring_i;
            if ($i < 0) return 0;
        }
    }

    /**
     * @description: find_among_b is for backwards processing. Same comments apply
     * @todo list: must check the invoke method part;
     * @param array $v
     * @return int;
     *
     * */
    protected function find_among_b($v)
    {
        $i = 0;
        $j = count($v);
        $c = $this->cursor;
        $lb = $this->limit_backward;
        $common_i = 0;
        $common_j = 0;
        $first_key_inspected = false;
        while (true) {
            $k = $i + (($j - $i) >> 1);
            $diff = 0;
            $common = $common_i < $common_j ? $common_i : $common_j;
            $w = $v[$k];
            for ($i2 = count($w->s) - 1 - $common; $i2 >= 0; $i2--) {
                if ($c - $common == $lb) {
                    $diff = -1;
                    break;
                }
                $diff = $this->current->charAt($c - 1 - $common) - $w->s[$i2];
                if ($diff != 0) break;
                $common++;
            }
            if ($diff < 0) {
                $j = $k;
                $common_j = $common;
            } else {
                $i = $k;
                $common_i = $common;
            }
            if ($j - $i <= 1) {
                if ($i > 0) break;
                if ($j == $i) break;
                if ($first_key_inspected) break;
                $first_key_inspected = true;
            }
        }
        while (true) {
            $w = $v[$i];
            if ($common_i >= count($w->s)) {
                $this->cursor = $c - count($w->s);
                if ($w->method == null) return $w->result;
                $res = false;
                try {
                    //Object
                    $resobj = $w->method->invoke($this);
                    $res = $resobj->toString()->equals("true");
                } catch (InvocationTargetException $e) {
                    $res = false;
                    // FIXME - debug message
                } catch (IllegalAccessException $e) {
                    $res = false;
                    // FIXME - debug message
                }
                $this->cursor = $c - count($w->s);
                if ($res) return $w->result;
            }
            $i = $w->substring_i;
            if ($i < 0) return 0;
        }
    }
    /* to replace chars between c_bra and c_ket in current by the
     * chars in s.
     */
    /**
     * @param int $c_bra ;
     * @param int $c_ket ;
     * @param string $s ;
     * @return int;
     * */
    protected function replace_s($c_bra, $c_ket, $s)
    {
        $adjustment = $s->length() - ($c_ket - $c_bra);
        $this->current->replace($c_bra, $c_ket, $s);
        $this->limit += $adjustment;
        if ($this->cursor >= $c_ket) $this->cursor += $adjustment;
        else if ($this->cursor > $c_bra) $this->cursor = $c_bra;
        return $adjustment;
    }

    protected function slice_check()
    {
        if ($this->bra < 0 ||
            $this->bra > $this->ket ||
            $this->ket > $this->limit ||
            $this->limit > $this->current->length()
        )   // this line could be removed
        {
            print("faulty slice operation");
            // FIXME: report error somehow.
            /*
                fprintf(stderr, "faulty slice operation:\n");
                debug(z, -1, 0);
                exit(1);
                */
        }
    }

    /**
     * @param string|CharSequence $s
     * */
    protected function slice_from($s)
    {
        if ($s instanceof CharSequence) {
            $s = $s->toString();
        }
        $this->slice_check();
        $this->replace_s($this->bra, $this->ket, $s);
    }


    protected function slice_del()
    {
        $this->slice_from('');
    }

    /**
     * @param int $c_bra ;
     * @param int $c_ket ;
     * @param string $s |CharSequence;
     * */
    protected function insert($c_bra, $c_ket, $s)
    {
        if ($s instanceof CharSequence) {
            $s = $s->toString();
        }
        $adjustment = $this->replace_s($c_bra, $c_ket, $s);
        if ($c_bra <= $this->bra) $this->bra += $adjustment;
        if ($c_bra <= $this->ket) $this->ket += $adjustment;
    }

    /* Copy the slice into the supplied StringBuffer */
    /**
     * @param string|StringBuffer|StringBuilder $s
     * @return string|StringBuffer|StringBuilder;
     * */
    protected function slice_to($s)
    {
        $this->slice_check();
        $len = $this->ket - $this->bra;
        $s->replace(0, $s->length(), $this->current->substring($this->bra, $this->ket));
        return $s;
    }
    /**
     * @param string|StringBuffer|StringBuilder $s
     * @return string|StringBuffer|StringBuilder
     * */
    protected function assign_to($s)
    {
        $s->replace(0, $s->length(), $this->current->substring(0, $this->limit));
        return $s;
    }
}