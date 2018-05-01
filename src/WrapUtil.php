<?php
/**
 * Created by IntelliJ IDEA.
 * User: bomba
 * Date: 27/04/18
 * Time: 6:08 PM
 */
declare(strict_types=1);

namespace KianBomba;


/**
 * Class WrapUtil
 * @package KianBomba
 */
class WrapUtil
{
    public function  __construct() {}

    /**
     * @param string $text
     * @param int $length
     * @return string
     *
     * - checking the single word within the string to see whether it is a larger than or equal to the length or not,
     * - if it is, we add it into the list.
     *
     * - if it is not, we add it into the cache, so that, we can compare whether the length of combination is
     * equal to the length,
     * - if the length of combination is equal to the length defined, add the combination to the list and empty the cache;
     * - if the length of combination is larger than the length defined, remove the single word that is recently added,
     * and add the new combination of cache to list;
     *
     * - if $i is the last index of the string, then we should
     *
     * array join the list with "\n"
     *
     * @deprecated
     *
     * - deprecated due to missed the requirement
     */
    public function wrap(string $text, int $length): string
    {
        $tmp = explode(" ", $text);
        if (empty($tmp)) return "";

        $merge = array();
        $tmpMerge = array();
        $threshold = count($tmp) - 1;

        for ($i = 0; $i < count($tmp); $i++)
        {
            $single = $tmp[$i];
            $ln1 = strlen($single);
            if ($ln1 >= $length)
            {
                /*
                    if the cache is not empty,
                    we need to add it to the merge and clear it for the next loop,
                    since the next word is going to be larger than the length
                */
                if (!empty($tmpMerge))
                {
                    $merge[] = implode(" ", $tmpMerge);
                    $tmpMerge = array();
                }

                $merge[] = $single;
                continue;
            }
            $tmpMerge[$i] = $single;

            $txt = implode(" ", $tmpMerge);
            $ln2 = strlen($txt);
            if ($ln2 > $length)
            {
                /*
                    as the length of combination is larger than the length defined,
                    we need to remove what we have just added, then added it into the lists
                */
                unset($tmpMerge[$i]);
                $merge[] = implode(" ", $tmpMerge);

                /* if it reach the threshold, we need to add the last word, otherwise reset the cache */
                if ($i == $threshold)
                {
                    $merge[] = $single;
                }
                else
                {
                    /* reset the cache here */
                    $tmpMerge = array($i => $single);
                }

            }
            else if ($ln2 == $length)
            {
                $merge[] = implode(" ", $tmpMerge);
                $tmpMerge = array();
            }
            else if ($i == $threshold)
            {
                $merge[] = implode(" ", $tmpMerge);
            }
        }

        return implode("\n", $merge);
    }

    /**
     * @param string $text
     * @param int $length
     * @return string
     *
     * - this is the new update for the wrap method to match with the requirement
     * - (ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)
     *
     */
    public function wrapV2(string $text, int $length): string
    {
        if (empty($text)) return "";
        $text = $this->sanitize($text);
        $merge = $tmpMerge = array();
        $threshold = strlen($text) - 1;
        for ($i=0; $i <= $threshold; $i++)
        {
            $a = $text[$i];

            $ln1 = strlen($a);
            if ($ln1 == $length) //for case length of 1
            {
                if (!empty($tmpMerge))
                {
                    $merge[] = implode("", $tmpMerge);
                    $tmpMerge = array();
                }
                $merge[] = $a;
                continue;
            }

            if ($a == " " && count($tmpMerge) == 0) continue;
            $tmpMerge[$i] = $a;
            $t = implode("", $tmpMerge);
            $ln2 = strlen($t);

            if ($ln2 > $length)
            {
                unset($tmpMerge[$i]);
                $merge[] = implode("", $tmpMerge);
                if ($i == $threshold)
                {
                    $merge[] = $a;
                }
                else
                {
                    $tmpMerge = array($i => $a);
                }
            }
            else if ($ln2 == $length)
            {
                $merge[] = $t;
                $tmpMerge = array();
            }
            else if ($i ==  $threshold)
            {
                $merge[] = $t;
            }
        }

        return implode("\n", $merge);
    }

    public function sanitize(string $input)
    {
        return preg_replace("/\s+/", " ",$input);
    }
}