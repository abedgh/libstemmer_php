<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/7/16
 * Time: 1:38 PM
 */

namespace Asg\Stemmer\Snowball\Ext;

use Asg\Stemmer\Snowball\Among;
use Asg\Stemmer\Snowball\SnowballStemmer;
use Asg\Support\String\StringBufferUTF8;

class ArabicStemmer extends SnowballStemmer
{

    private static $serialVersionUID = 1;
    /**
     * @var array<Among>
     * */
    private static $a_0 = null;
    private static $a_1 = null;
    private static $a_2 = null;
    private static $a_3 = null;
    private static $a_4 = null;
    private static $a_5 = null;
    private static $a_6 = null;
    private static $a_7 = null;
    private static $a_8 = null;
    private static $a_9 = null;
    private static $a_10 = null;
    private static $a_11 = null;
    private static $a_12 = null;
    private static $a_13 = null;
    private static $a_14 = null;
    private static $a_15 = null;
    private static $a_16 = null;
    private static $a_17 = null;
    private static $a_18 = null;
    private static $a_19 = null;
    private static $a_20 = null;
    private static $a_21 = null;
    private static $a_22 = null;
    private static $a_23 = null;
    /**
     * @var bool;
     * */
    private $B_is_defined;
    /**
     * @var bool;
     * */
    private $B_is_verb;
    /**
     * @var bool;
     * */
    private $B_is_noun;
    /**
     * @var int;
     * */
    private $I_word_len;

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    protected function init()
    {
        static::$a_0 = [
            new Among ('!', -1, 3),
            new Among ('\'', -1, 3),
            new Among ('%', -1, 3),
            new Among ('*', -1, 3),
            new Among (',', -1, 3),
            new Among ('.', -1, 3),
            new Among ('/', -1, 3),
            new Among (':', -1, 3),
            new Among (';', -1, 3),
            new Among ('?', -1, 3),
            new Among ('\\', -1, 3),
            new Among ('\u060C', -1, 4),
            new Among ('\u061B', -1, 4),
            new Among ('\u061F', -1, 4),
            new Among ('\u0640', -1, 2),
            new Among ('\u064B', -1, 1),
            new Among ('\u064C', -1, 1),
            new Among ('\u064D', -1, 1),
            new Among ('\u064E', -1, 1),
            new Among ('\u064F', -1, 1),
            new Among ('\u0650', -1, 1),
            new Among ('\u0651', -1, 1),
            new Among ('\u0652', -1, 1),
            new Among ('\u0660', -1, 5),
            new Among ('\u0661', -1, 6),
            new Among ('\u0662', -1, 7),
            new Among ('\u0663', -1, 8),
            new Among ('\u0664', -1, 9),
            new Among ('\u0665', -1, 10),
            new Among ('\u0666', -1, 11),
            new Among ('\u0667', -1, 12),
            new Among ('\u0668', -1, 13),
            new Among ('\u0669', -1, 14),
            new Among ('\u066A', -1, 15),
            new Among ('\u066B', -1, 15),
            new Among ('\u066C', -1, 15),
            new Among ('\uFE80', -1, 16),
            new Among ('\uFE81', -1, 20),
            new Among ('\uFE82', -1, 20),
            new Among ('\uFE83', -1, 17),
            new Among ('\uFE84', -1, 17),
            new Among ('\uFE85', -1, 21),
            new Among ('\uFE86', -1, 21),
            new Among ('\uFE87', -1, 18),
            new Among ('\uFE88', -1, 18),
            new Among ('\uFE89', -1, 19),
            new Among ('\uFE8A', -1, 19),
            new Among ('\uFE8B', -1, 19),
            new Among ('\uFE8C', -1, 19),
            new Among ('\uFE8D', -1, 22),
            new Among ('\uFE8E', -1, 22),
            new Among ('\uFE8F', -1, 23),
            new Among ('\uFE90', -1, 23),
            new Among ('\uFE91', -1, 23),
            new Among ('\uFE92', -1, 23),
            new Among ('\uFE93', -1, 24),
            new Among ('\uFE94', -1, 24),
            new Among ('\uFE95', -1, 25),
            new Among ('\uFE96', -1, 25),
            new Among ('\uFE97', -1, 25),
            new Among ('\uFE98', -1, 25),
            new Among ('\uFE99', -1, 26),
            new Among ('\uFE9A', -1, 26),
            new Among ('\uFE9B', -1, 26),
            new Among ('\uFE9C', -1, 26),
            new Among ('\uFE9D', -1, 27),
            new Among ('\uFE9E', -1, 27),
            new Among ('\uFE9F', -1, 27),
            new Among ('\uFEA0', -1, 27),
            new Among ('\uFEA1', -1, 28),
            new Among ('\uFEA2', -1, 28),
            new Among ('\uFEA3', -1, 28),
            new Among ('\uFEA4', -1, 28),
            new Among ('\uFEA5', -1, 29),
            new Among ('\uFEA6', -1, 29),
            new Among ('\uFEA7', -1, 29),
            new Among ('\uFEA8', -1, 29),
            new Among ('\uFEA9', -1, 30),
            new Among ('\uFEAA', -1, 30),
            new Among ('\uFEAB', -1, 31),
            new Among ('\uFEAC', -1, 31),
            new Among ('\uFEAD', -1, 32),
            new Among ('\uFEAE', -1, 32),
            new Among ('\uFEAF', -1, 33),
            new Among ('\uFEB0', -1, 33),
            new Among ('\uFEB1', -1, 34),
            new Among ('\uFEB2', -1, 34),
            new Among ('\uFEB3', -1, 34),
            new Among ('\uFEB4', -1, 34),
            new Among ('\uFEB5', -1, 35),
            new Among ('\uFEB6', -1, 35),
            new Among ('\uFEB7', -1, 35),
            new Among ('\uFEB8', -1, 35),
            new Among ('\uFEB9', -1, 36),
            new Among ('\uFEBA', -1, 36),
            new Among ('\uFEBB', -1, 36),
            new Among ('\uFEBC', -1, 36),
            new Among ('\uFEBD', -1, 37),
            new Among ('\uFEBE', -1, 37),
            new Among ('\uFEBF', -1, 37),
            new Among ('\uFEC0', -1, 37),
            new Among ('\uFEC1', -1, 38),
            new Among ('\uFEC2', -1, 38),
            new Among ('\uFEC3', -1, 38),
            new Among ('\uFEC4', -1, 38),
            new Among ('\uFEC5', -1, 39),
            new Among ('\uFEC6', -1, 39),
            new Among ('\uFEC7', -1, 39),
            new Among ('\uFEC8', -1, 39),
            new Among ('\uFEC9', -1, 40),
            new Among ('\uFECA', -1, 40),
            new Among ('\uFECB', -1, 40),
            new Among ('\uFECC', -1, 40),
            new Among ('\uFECD', -1, 41),
            new Among ('\uFECE', -1, 41),
            new Among ('\uFECF', -1, 41),
            new Among ('\uFED0', -1, 41),
            new Among ('\uFED1', -1, 42),
            new Among ('\uFED2', -1, 42),
            new Among ('\uFED3', -1, 42),
            new Among ('\uFED4', -1, 42),
            new Among ('\uFED5', -1, 43),
            new Among ('\uFED6', -1, 43),
            new Among ('\uFED7', -1, 43),
            new Among ('\uFED8', -1, 43),
            new Among ('\uFED9', -1, 44),
            new Among ('\uFEDA', -1, 44),
            new Among ('\uFEDB', -1, 44),
            new Among ('\uFEDC', -1, 44),
            new Among ('\uFEDD', -1, 45),
            new Among ('\uFEDE', -1, 45),
            new Among ('\uFEDF', -1, 45),
            new Among ('\uFEE0', -1, 45),
            new Among ('\uFEE1', -1, 46),
            new Among ('\uFEE2', -1, 46),
            new Among ('\uFEE3', -1, 46),
            new Among ('\uFEE4', -1, 46),
            new Among ('\uFEE5', -1, 47),
            new Among ('\uFEE6', -1, 47),
            new Among ('\uFEE7', -1, 47),
            new Among ('\uFEE8', -1, 47),
            new Among ('\uFEE9', -1, 48),
            new Among ('\uFEEA', -1, 48),
            new Among ('\uFEEB', -1, 48),
            new Among ('\uFEEC', -1, 48),
            new Among ('\uFEED', -1, 49),
            new Among ('\uFEEE', -1, 49),
            new Among ('\uFEEF', -1, 50),
            new Among ('\uFEF0', -1, 50),
            new Among ('\uFEF1', -1, 51),
            new Among ('\uFEF2', -1, 51),
            new Among ('\uFEF3', -1, 51),
            new Among ('\uFEF4', -1, 51),
            new Among ('\uFEF5', -1, 55),
            new Among ('\uFEF6', -1, 55),
            new Among ('\uFEF7', -1, 53),
            new Among ('\uFEF8', -1, 53),
            new Among ('\uFEF9', -1, 54),
            new Among ('\uFEFA', -1, 54),
            new Among ('\uFEFB', -1, 52),
            new Among ('\uFEFC', -1, 52)
        ];
        static::$a_1 = [
            new Among ('\u0622', -1, 1),
            new Among ('\u0623', -1, 1),
            new Among ('\u0624', -1, 2),
            new Among ('\u0625', -1, 1),
            new Among ('\u0626', -1, 3)
        ];
        static::$a_2 = [
            new Among ('\u0622', -1, 1),
            new Among ('\u0623', -1, 1),
            new Among ('\u0624', -1, 2),
            new Among ('\u0625', -1, 1),
            new Among ('\u0626', -1, 3)
        ];
        static::$a_3 = [
            new Among ('\u0627\u0644', -1, 2),
            new Among ('\u0628\u0627\u0644', -1, 1),
            new Among ('\u0643\u0627\u0644', -1, 1),
            new Among ('\u0644\u0644', -1, 2)
        ];
        static::$a_4 = [
            new Among ('\u0629', -1, 1)
        ];
        static::$a_5 = [
            new Among ('\u0623\u0622', -1, 2),
            new Among ('\u0623\u0623', -1, 1),
            new Among ('\u0623\u0624', -1, 3),
            new Among ('\u0623\u0625', -1, 5),
            new Among ('\u0623\u0627', -1, 4)
        ];
        static::$a_6 = [
            new Among ('\u0641\u0627\u0644', -1, 1),
            new Among ('\u0648\u0627\u0644', -1, 2)
        ];
        static::$a_7 = [
            new Among ('\u0641', -1, 1),
            new Among ('\u0648', -1, 2)
        ];
        static::$a_8 = [
            new Among ('\u0627\u0644', -1, 2),
            new Among ('\u0628\u0627\u0644', -1, 1),
            new Among ('\u0643\u0627\u0644', -1, 1),
            new Among ('\u0644\u0644', -1, 2)
        ];
        static::$a_9 = [
            new Among ('\u0628', -1, 1),
            new Among ('\u0628\u0628', 0, 4),
            new Among ('\u0643', -1, 2),
            new Among ('\u0643\u0643', 2, 5),
            new Among ('\u0644', -1, 3)
        ];
        static::$a_10 = [
            new Among ('\u0633\u0623', -1, 4),
            new Among ('\u0633\u062A', -1, 2),
            new Among ('\u0633\u0646', -1, 3),
            new Among ('\u0633\u064A', -1, 1)
        ];
        static::$a_11 = [
            new Among ('\u062A\u0633\u062A', -1, 1),
            new Among ('\u0646\u0633\u062A', -1, 1),
            new Among ('\u064A\u0633\u062A', -1, 1)
        ];
        static::$a_12 = [
            new Among ('\u0643\u0645\u0627', -1, 3),
            new Among ('\u0647\u0645\u0627', -1, 3),
            new Among ('\u0646\u0627', -1, 2),
            new Among ('\u0647\u0627', -1, 2),
            new Among ('\u0643', -1, 1),
            new Among ('\u0643\u0645', -1, 2),
            new Among ('\u0647\u0645', -1, 2),
            new Among ('\u0647\u0646', -1, 2),
            new Among ('\u0647', -1, 1),
            new Among ('\u064A', -1, 1)
        ];
        static::$a_13 = [
            new Among ('\u0646', -1, 1)
        ];
        static::$a_14 = [
            new Among ('\u0627', -1, 1),
            new Among ('\u0648', -1, 1),
            new Among ('\u064A', -1, 1)
        ];
        static::$a_15 = [
            new Among ('\u0627\u062A', -1, 1)
        ];
        static::$a_16 = [
            new Among ('\u062A', -1, 1)
        ];
        static::$a_17 = [
            new Among ('\u0629', -1, 1)
        ];
        static::$a_18 = [
            new Among ('\u064A', -1, 1)
        ];
        static::$a_19 = [
            new Among ('\u0643\u0645\u0627', -1, 3),
            new Among ('\u0647\u0645\u0627', -1, 3),
            new Among ('\u0646\u0627', -1, 2),
            new Among ('\u0647\u0627', -1, 2),
            new Among ('\u0643', -1, 1),
            new Among ('\u0643\u0645', -1, 2),
            new Among ('\u0647\u0645', -1, 2),
            new Among ('\u0643\u0646', -1, 2),
            new Among ('\u0647\u0646', -1, 2),
            new Among ('\u0647', -1, 1),
            new Among ('\u0643\u0645\u0648', -1, 3),
            new Among ('\u0646\u064A', -1, 2)
        ];
        static::$a_20 = [
            new Among ('\u0627', -1, 2),
            new Among ('\u062A\u0627', 0, 3),
            new Among ('\u062A\u0645\u0627', 0, 5),
            new Among ('\u0646\u0627', 0, 3),
            new Among ('\u062A', -1, 1),
            new Among ('\u0646', -1, 2),
            new Among ('\u0627\u0646', 5, 4),
            new Among ('\u062A\u0646', 5, 3),
            new Among ('\u0648\u0646', 5, 4),
            new Among ('\u064A\u0646', 5, 4),
            new Among ('\u064A', -1, 2)
        ];
        static::$a_21 = [
            new Among ('\u0648\u0627', -1, 1),
            new Among ('\u062A\u0645', -1, 1)
        ];
        static::$a_22 = [
            new Among ('\u0648', -1, 1),
            new Among ('\u062A\u0645\u0648', 0, 2)
        ];
        static::$a_23 = [
            new Among ('\u0649', -1, 1)
        ];
    }

    /**
     * @return bool;
     * */
    private function r_Normalize_pre()
    {
        for ($v_1 = ($this->current->length()); $v_1 > 0; $v_1--) {
            do { //lab0:
                $v_2 = $this->cursor;
                do { //lab1:
                    $this->bra = $this->cursor;
                    $among_var = $this->find_among(static::$a_0);
                    if ($among_var == 0) {
                        break; //lab1;
                    }
                    $this->ket = $this->cursor;
                    switch ($among_var) {
                        case 0:
                            break; //lab1;
                        case 1:
                            $this->slice_del();
                            break;
                        case 2:
                            $this->slice_del();
                            break;
                        case 3:
                            $this->slice_del();
                            break;
                        case 4:
                            $this->slice_del();
                            break;
                        case 5:
                            $this->slice_from("0");
                            break;
                        case 6:
                            $this->slice_from("1");
                            break;
                        case 7:
                            $this->slice_from("2");
                            break;
                        case 8:
                            $this->slice_from("3");
                            break;
                        case 9:
                            $this->slice_from("4");
                            break;
                        case 10:
                            $this->slice_from("5");
                            break;
                        case 11:
                            $this->slice_from("6");
                            break;
                        case 12:
                            $this->slice_from("7");
                            break;
                        case 13:
                            $this->slice_from("8");
                            break;
                        case 14:
                            $this->slice_from("9");
                            break;
                        case 15:
                            $this->slice_del();
                            break;
                        case 16:
                            $this->slice_from('\u0621');
                            break;
                        case 17:
                            $this->slice_from('\u0623');
                            break;
                        case 18:
                            $this->slice_from('\u0625');
                            break;
                        case 19:
                            $this->slice_from('\u0626');
                            break;
                        case 20:
                            $this->slice_from('\u0622');
                            break;
                        case 21:
                            $this->slice_from('\u0624');
                            break;
                        case 22:
                            $this->slice_from('\u0627');
                            break;
                        case 23:
                            $this->slice_from('\u0628');
                            break;
                        case 24:
                            $this->slice_from('\u0629');
                            break;
                        case 25:
                            $this->slice_from('\u062A');
                            break;
                        case 26:
                            $this->slice_from('\u062B');
                            break;
                        case 27:
                            $this->slice_from('\u062C');
                            break;
                        case 28:
                            $this->slice_from('\u062D');
                            break;
                        case 29:
                            $this->slice_from('\u062E');
                            break;
                        case 30:
                            $this->slice_from('\u062F');
                            break;
                        case 31:
                            $this->slice_from('\u0630');
                            break;
                        case 32:
                            $this->slice_from('\u0631');
                            break;
                        case 33:
                            $this->slice_from('\u0632');
                            break;
                        case 34:
                            $this->slice_from('\u0633');
                            break;
                        case 35:
                            $this->slice_from('\u0634');
                            break;
                        case 36:
                            $this->slice_from('\u0635');
                            break;
                        case 37:
                            $this->slice_from('\u0636');
                            break;
                        case 38:
                            $this->slice_from('\u0637');
                            break;
                        case 39:
                            $this->slice_from('\u0638');
                            break;
                        case 40:
                            $this->slice_from('\u0639');
                            break;
                        case 41:
                            $this->slice_from('\u063A');
                            break;
                        case 42:
                            $this->slice_from('\u0642');
                            break;
                        case 43:
                            $this->slice_from('\u0642');
                            break;
                        case 44:
                            $this->slice_from('\u0643');
                            break;
                        case 45:
                            $this->slice_from('\u0644');
                            break;
                        case 46:
                            $this->slice_from('\u0645');
                            break;
                        case 47:
                            $this->slice_from('\u0646');
                            break;
                        case 48:
                            $this->slice_from('\u0647');
                            break;
                        case 49:
                            $this->slice_from('\u0648');
                            break;
                        case 50:
                            $this->slice_from('\u0649');
                            break;
                        case 51:
                            $this->slice_from('\u064A');
                            break;
                        case 52:
                            $this->slice_from('\u0644\u0627');
                            break;
                        case 53:
                            $this->slice_from('\u0644\u0623');
                            break;
                        case 54:
                            $this->slice_from('\u0644\u0625');
                            break;
                        case 55:
                            $this->slice_from('\u0644\u0622');
                            break;
                    }
                    break; //lab0;
                } while (false);
                $this->cursor = $v_2;
                if ($this->cursor >= $this->limit) {
                    return false;
                }
                $this->cursor++;
            } while (false);
        }
        return true;
    }

    /**
     * @return bool;
     * */
    private function r_Normalize_post()
    {
        $v_1 = $this->cursor;
        do { //lab0:
            $this->limit_backward = $this->cursor;
            $this->cursor = $this->limit;
            $this->ket = $this->cursor;
            $among_var = $this->find_among_b(static::$a_1);
            if ($among_var == 0) {
                break; //lab0;
            }
            $this->bra = $this->cursor;
            switch ($among_var) {
                case 0:
                    break; //lab0;
                case 1:
                    $this->slice_from('\u0621');
                    break;
                case 2:
                    $this->slice_from('\u0621');
                    break;
                case 3:
                    $this->slice_from('\u0621');
                    break;
            }
            $this->cursor = $this->limit_backward;
        } while (false);
        $this->cursor = $v_1;
        $v_2 = $this->cursor;
        do { //lab1:
            for ($v_3 = $this->I_word_len; $v_3 > 0; $v_3--) {
                do { //lab2:
                    $v_4 = $this->cursor;
                    do { //lab3:
                        $this->bra = $this->cursor;
                        $among_var = $this->find_among(static::$a_2);
                        if ($among_var == 0) {
                            break; // lab3;
                        }
                        $this->ket = $this->cursor;
                        switch ($among_var) {
                            case 0:
                                break; //lab3;
                            case 1:
                                $this->slice_from('\u0627');
                                break;
                            case 2:
                                $this->slice_from('\u0648');
                                break;
                            case 3:
                                $this->slice_from('\u064A');
                                break;
                        }
                        break; // lab2;
                    } while (false);
                    $this->cursor = $v_4;
                    if ($this->cursor >= $this->limit) {
                        break; //lab1;
                    }
                    $this->cursor++;
                } while (false);
            }
        } while (false);
        $this->cursor = $v_2;
        return true;
    }
    /**
     * @return bool
     * */
    private function r_Checks1()
    {

        $this->I_word_len = ($this->current->length());
        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_3);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->B_is_noun = true;
                $this->B_is_verb = false;
                $this->B_is_defined = true;
                break;
            case 2:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->B_is_noun = true;
                $this->B_is_verb = false;
                // set is_defined, line 367
                $this->B_is_defined = true;
                break;
        }
        return true;
    }
    /**
     * @return bool
     * */
    private function r_Checks2()
    {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_4);
        if ($among_var == 0) {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 2)) {
                    return false;
                }
                $this->B_is_noun = true;
                $this->B_is_verb = false;
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Prefix_Step1()
    {
        $this->I_word_len = ($this->current->length());
        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_5);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:

                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_from('\u0623');
                break;
            case 2:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_from('\u0622');
                break;
            case 3:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_from('\u0623');
                break;
            case 4:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_from('\u0627');
                break;
            case 5:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_from('\u0625');
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Prefix_Step2a()
    {

        $this->I_word_len = ($this->current->length());
        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_6);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 5)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 2:
                if (!($this->I_word_len > 5)) {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Prefix_Step2b()
    {
        $this->I_word_len = ($this->current->length());
        {
            $v_1 = $this->cursor;
            do { //lab0:
                if (!($this->eq_s(new StringBufferUTF8('\u0641\u0627')))) {
                    break; //lab0;
                }
                return false;
            } while (false);
            $this->cursor = $v_1;
        }
        {
            $v_2 = $this->cursor;
            do { //lab1:
                if (!($this->eq_s(new StringBufferUTF8('\u0648\u0627')))) {
                    break; //lab1;
                }
                return false;
            } while (false);
            $this->cursor = $v_2;
        }
        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_7);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                // delete, line 407
                $this->slice_del();
                break;
            case 2:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Prefix_Step3a_Noun()
    {
        $this->I_word_len = ($this->current->length());
        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_8);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 5)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 2:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Prefix_Step3b_Noun()
    {
        $this->I_word_len = ($this->current->length());
        {
            $v_1 = $this->cursor;
            do { // lab0:
                if (!($this->eq_s(new StringBufferUTF8('\u0628\u0627')))) {
                    break; // lab0;
                }
                return false;
            } while (false);
            $this->cursor = $v_1;
        }

        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_9);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 2:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 3:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 4:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_from('\u0628');
                break;
            case 5:
                if (!($this->I_word_len > 3)) {
                    return false;
                }
                $this->slice_from('\u0643');
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Prefix_Step3_Verb()
    {
        $this->I_word_len = ($this->current->length());
        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_10);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->slice_from('\u064A');
                break;
            case 2:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->slice_from('\u062A');
                break;
            case 3:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->slice_from('\u0646');
                break;
            case 4:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->slice_from('\u0623');
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Prefix_Step4_Verb()
    {
        $this->I_word_len = ($this->current->length());
        $this->bra = $this->cursor;
        $among_var = $this->find_among(static::$a_11);
        if ($among_var == 0) {
            return false;
        }
        $this->ket = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 4)) {
                    return false;
                }
                $this->B_is_verb = true;
                $this->B_is_noun = false;
                $this->slice_from('\u0627\u0633\u062A');
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Noun_Step1a()
    {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_12);
        if ($among_var == 0) {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 4)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 2:
                if (!($this->I_word_len >= 5)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 3:
                if (!($this->I_word_len >= 6)) {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Noun_Step1b() {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_13);
        if ($among_var == 0)
        {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 5))
                {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Noun_Step2a() {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_14);
        if ($among_var == 0)
        {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len > 4))
                {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Noun_Step2b() {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_15);
        if ($among_var == 0)
        {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 5))
                {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Noun_Step2c1() {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_16);
        if ($among_var == 0)
        {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 4))
                {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Noun_Step2c2()
    {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_17);
        if ($among_var == 0) {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 3)) {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Noun_Step3()
    {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_18);
        if ($among_var == 0) {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 3)) {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Verb_Step1() {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_19);
        if ($among_var == 0)
        {
            return false;
        }

        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:

                if (!($this->I_word_len >= 4))
                {
                    return false;
                }
                $this->slice_del();
                break;
            case 2:

                if (!($this->I_word_len >= 5))
                {
                    return false;
                }
                $this->slice_del();
                break;
            case 3:
                if (!($this->I_word_len >= 6))
                {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Verb_Step2a() {
        $this->I_word_len = ($this->current->length());

        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_20);
        if ($among_var == 0)
        {
            return false;
        }

        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 4))
                {
                    return false;
                }
                $this->slice_del();
                break;
            case 2:
                if (!($this->I_word_len >= 4))
                {
                    return false;
                }
                $this->slice_del();
                break;
            case 3:
                if (!($this->I_word_len >= 5))
                {
                    return false;
                }
                $this->slice_del();
                break;
            case 4:
                if (!($this->I_word_len > 5))
                {
                    return false;
                }
                $this->slice_del();
                break;
            case 5:
                if (!($this->I_word_len >= 6))
                {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Verb_Step2b() {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_21);
        if ($among_var == 0)
        {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 5))
                {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_Verb_Step2c()
    {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_22);
        if ($among_var == 0) {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                if (!($this->I_word_len >= 4)) {
                    return false;
                }
                $this->slice_del();
                break;
            case 2:
                if (!($this->I_word_len >= 6)) {
                    return false;
                }
                $this->slice_del();
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    private function r_Suffix_All_alef_maqsura()
    {
        $this->I_word_len = ($this->current->length());
        $this->ket = $this->cursor;
        $among_var = $this->find_among_b(static::$a_23);
        if ($among_var == 0) {
            return false;
        }
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                $this->slice_from('\u064A');
                break;
        }
        return true;
    }
    /**
     * @return bool;
     * */
    public function stem()
    {
        $this->B_is_noun = true;
        $this->B_is_verb = true;
        $this->B_is_defined = false;

        $v_1 = $this->cursor;
        do { //lab0:
            if (!$this->r_Checks1()) {
                break;// lab0;
            }
        } while (false);
        $this->cursor = $v_1;
        $this->limit_backward = $this->cursor;
        $this->cursor = $this->limit;
        $v_2 = $this->limit - $this->cursor;
        do { //lab1:
            if (!$this->r_Checks2()) {
                break; //lab1;
            }
        } while (false);
        $this->cursor = $this->limit - $v_2;
        $this->cursor = $this->limit_backward;
        $v_3 = $this->cursor;
        do { //lab2:
            if (!$this->r_Normalize_pre()) {
                break; //lab2;
            }
        } while (false);
        $this->cursor = $v_3;
        $this->limit_backward = $this->cursor;
        $this->cursor = $this->limit;
        $v_4 = $this->limit - $this->cursor;
        do { //  lab3:
            do { //lab4:
                $v_5 = $this->limit - $this->cursor;
                do { //lab5:
                    if (!($this->B_is_verb)) {
                        break; //lab5;
                    }
                    do { //lab6:
                        $v_6 = $this->limit - $this->cursor;
                        do { // lab7:
                            {
                                $v_7 = 1;
                                while (true) { //replab8:
                                    $v_8 = $this->limit - $this->cursor;
                                    do { //lab9:
                                        if (!$this->r_Suffix_Verb_Step1()) {
                                            break;// lab9;
                                        }
                                        $v_7--;
                                        continue; //replab8;
                                    } while (false);
                                    $this->cursor = $this->limit - $v_8;
                                    break;// replab8;
                                }
                                if ($v_7 > 0) {
                                    break; // lab7;
                                }
                            }
                            do { //lab10:
                                $v_9 = $this->limit - $this->cursor;
                                do { //lab11:
                                    if (!$this->r_Suffix_Verb_Step2a()) {
                                        break; // lab11;
                                    }
                                    break; // lab10;
                                } while (false);
                                $this->cursor = $this->limit - $v_9;
                                do { //lab12:
                                    if (!$this->r_Suffix_Verb_Step2c()) {
                                        break; //lab12;
                                    }
                                    break; // lab10;
                                } while (false);
                                $this->cursor = $this->limit - $v_9;
                                if ($this->cursor <= $this->limit_backward) {
                                    break; //lab7;
                                }
                                $this->cursor--;
                            } while (false);
                            break; // lab6;
                        } while (false);
                        $this->cursor = $this->limit - $v_6;

                        do { //lab13:
                            if (!$this->r_Suffix_Verb_Step2b()) {
                                break; //lab13;
                            }
                            break; // lab6;
                        } while (false);
                        $this->cursor = $this->limit - $v_6;
                        if (!$this->r_Suffix_Verb_Step2a()) {
                            break; // lab5;
                        }
                    } while (false);
                    break; // lab4;
                } while (false);
                $this->cursor = $this->limit - $v_5;
                do { //lab14:
                    if (!($this->B_is_noun)) {
                        break; // lab14;
                    }
                    $v_10 = $this->limit - $this->cursor;
                    do { //lab15:
                        do { //lab16:
                            $v_11 = $this->limit - $this->cursor;
                            do { // lab17:
                                if (!$this->r_Suffix_Noun_Step2c2()) {
                                    break;// lab17;
                                }
                                break; // lab16;
                            } while (false);
                            $this->cursor = $this->limit - $v_11;
                            do { //lab18:
                                do { // lab19:
                                    if (!($this->B_is_defined)) {
                                        break;// lab19;
                                    }
                                    break;// lab18;
                                } while (false);
                                if (!$this->r_Suffix_Noun_Step1a()) {
                                    break; // lab18;
                                }
                                do { // lab20:
                                    $v_13 = $this->limit - $this->cursor;
                                    do { // lab21:
                                        if (!$this->r_Suffix_Noun_Step2a()) {
                                            break; // lab21;
                                        }
                                        break;// lab20;
                                    } while (false);
                                    $this->cursor = $this->limit - $v_13;
                                    do { //lab22:
                                        if (!$this->r_Suffix_Noun_Step2b()) {
                                            break; //lab22;
                                        }
                                        break; //lab20;
                                    } while (false);
                                    $this->cursor = $this->limit - $v_13;
                                    do { // lab23:
                                        if (!$this->r_Suffix_Noun_Step2c1()) {
                                            break; // lab23;
                                        }
                                        break;// lab20;
                                    } while (false);
                                    $this->cursor = $this->limit - $v_13;
                                    if ($this->cursor <= $this->limit_backward) {
                                        break; //lab18;
                                    }
                                    $this->cursor--;
                                } while (false);
                                break; //lab16;
                            } while (false);
                            $this->cursor = $this->limit - $v_11;
                            do { //lab24:
                                if (!$this->r_Suffix_Noun_Step1b()) {
                                    break; //lab24;
                                }
                                do { //lab25:
                                    $v_14 = $this->limit - $this->cursor;
                                    do { //lab26:
                                        if (!$this->r_Suffix_Noun_Step2a()) {
                                            break;// lab26;
                                        }
                                        break;// lab25;
                                    } while (false);
                                    $this->cursor = $this->limit - $v_14;
                                    do { //lab27:
                                        if (!$this->r_Suffix_Noun_Step2b()) {
                                            break;// lab27;
                                        }
                                        break;// lab25;
                                    } while (false);
                                    $this->cursor = $this->limit - $v_14;
                                    if (!$this->r_Suffix_Noun_Step2c1()) {
                                        break; //lab24;
                                    }
                                } while (false);
                                break; //lab16;
                            } while (false);
                            $this->cursor = $this->limit - $v_11;
                            do { //lab28:
                                do { //lab29:
                                    if (!($this->B_is_defined)) {
                                        break; //lab29;
                                    }
                                    break; //lab28;
                                } while (false);
                                if (!$this->r_Suffix_Noun_Step2a()) {
                                    break; //lab28;
                                }
                                break; //lab16;
                            } while (false);
                            $this->cursor = $this->limit - $v_11;
                            if (!$this->r_Suffix_Noun_Step2b()) {
                                $this->cursor = $this->limit - $v_10;
                                break; // lab15;
                            }
                        } while (false);
                    } while (false);
                    if (!$this->r_Suffix_Noun_Step3()) {
                        break; // lab14;
                    }
                    break;// lab4;
                } while (false);
                $this->cursor = $this->limit - $v_5;
                if (!$this->r_Suffix_All_alef_maqsura()) {
                    break;// lab3;
                }
            } while (false);
        } while (false);
        $this->cursor = $this->limit - $v_4;
        $this->cursor = $this->limit_backward;
        $v_16 = $this->cursor;
        do { // lab30:
            $v_17 = $this->cursor;
            do { //lab31:
                if (!$this->r_Prefix_Step1()) {
                    $this->cursor = $v_17;
                    break; // lab31;
                }
            } while (false);
            $v_18 = $this->cursor;
            do { //lab32:
                do { //lab33:
                    $v_19 = $this->cursor;
                    do { // lab34:
                        if (!$this->r_Prefix_Step2a()) {
                            break;// lab34;
                        }
                        break;// lab33;
                    } while (false);
                    $this->cursor = $v_19;
                    if (!$this->r_Prefix_Step2b()) {
                        $this->cursor = $v_18;
                        break;// lab32;
                    }
                } while (false);
            } while (false);
            do { //lab35:
                $v_20 = $this->cursor;
                do { //lab36:
                    if (!$this->r_Prefix_Step3a_Noun()) {
                        break; // lab36;
                    }
                    break;// lab35;
                } while (false);
                $this->cursor = $v_20;
                do { //lab37:
                    if (!($this->B_is_noun)) {
                        break;// lab37;
                    }
                    if (!$this->r_Prefix_Step3b_Noun()) {
                        break;// lab37;
                    }
                    break;// lab35;
                } while (false);
                $this->cursor = $v_20;
                if (!($this->B_is_verb)) {
                    break;// lab30;
                }
                $v_21 = $this->cursor;
                do { //lab38:
                    if (!$this->r_Prefix_Step3_Verb()) {
                        $this->cursor = $v_21;
                        break;// lab38;
                    }
                } while (false);
                if (!$this->r_Prefix_Step4_Verb()) {
                    break;// lab30;
                }
            } while (false);
        } while (false);
        $this->cursor = $v_16;
        $v_22 = $this->cursor;
        do { //lab39:
            if (!$this->r_Normalize_post()) {
                break;//lab39;
            }
        } while (false);
        $this->cursor = $v_22;
        return true;
    }
    /**
     * @param mixed $o
     * @return bool;
     * */
    public function equals($o)
    {
        return $o instanceof ArabicStemmer;
    }

    /**
     * @return int
     * */
    public function hashCode()
    {
        $string = get_class();
        $hash = 0;
        $stringLength = strlen($string);
        for ($i = 0; $i < $stringLength; $i++) {
            $hash = 31 * $hash + $string[$i];
        }
        return $hash;
    }
}