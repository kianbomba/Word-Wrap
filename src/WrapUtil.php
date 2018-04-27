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
}