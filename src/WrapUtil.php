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
     * @param string    $text           => the input text that we are going to wrap up.
     * @param int       $length         => the pre-defined length that we are going to wrap
     * @param bool      $sanitizing     => determined whether we would want to sanitize the string or not
     * @return string
     *
     * - this is the new update for the wrap method to match with the requirement
     * - (ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)(ಥ_ಥ)
     *
     *
     * @deprecated
     *
     * - deprecated due to not coping well with the requirements
     */
    public function wrapV2(string $text, int $length, bool $sanitizing=true): string
    {
        if ($sanitizing) $text = Sanitizer::instance()->spaceSanitize($text);
        if (empty($text)) return "";

        $merge = $tmpMerge = array();
        $threshold = strlen($text) - 1;
        for ($i=0; $i <= $threshold; $i++)
        {
            $a = $text[$i];

            /* by this statement, if the next append is the space */
            if (in_array($a, [" ", "\n", "\t"]) && count($tmpMerge) == 0) continue;
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

    /**
     * @param string $input
     * @param int $length
     * @return string
     *
     * - this is the new version that would fit better with the requirements
     * - logic UPDATE in ENGLISH:
     * ------------ START -----------
     * + if the length of input is less than the length required -> just return string, no need to perform logic
     *
     * + when the length of the input is bigger than the required -> start performing logic
     *
     * + looping through all the single word in the string, then start putting them into cache
     * -> then check the cache, if the length of cache is larger than the length required, hence, I need to remove
     * what we have just added, and save it into the merge (which would be used for the result return)
     *
     * + in case if the length of cache reaches to the length required, then we are checking whether if the last item is a space
     * -> if it is a space, get rid of that SPACE within the cache !!! ༼つ◕_◕ ༽つ -> then add it into the the merge
     * -> if it is not the space, leave it in the cache
     *
     * + in case where the cache is under the length, we need to check the differences
     * between the length required and the length of cache, if the differences is less than or equal 1
     * (I'm not sure about this solution, but if it need to be 1, other number wouldn't cope this situation well)
     * get rid of that SPACE within the cache !!! ༼つ◕_◕ ༽つ -> then add the cache into the the merge and clear it
     *
     * + other than the new logic updates, the mechanism should be the same as older version
     *
     * ---------- END ----------
     *
     * - I have found the funny bug, that 0 is actually evaluated as empty,
     * therefore the older version would return ""
     * oh dear PHP ٩(͡๏_๏)۶ ٩(͡๏_๏)۶ ٩(͡๏_๏)۶
     *
     *
     * ༼つ◕_◕ ༽つ༼つ◕_◕ ༽つ༼つ◕_◕ ༽つ GOD OF WAR IV ༼つ◕_◕ ༽つ༼つ◕_◕ ༽つ༼つ◕_◕ ༽つ
     */
    public function wrapV3(string $input, int $length): string
    {
        $inputLength = strlen($input);
        if ($inputLength == 0)
        {
            return "";
        }
        else if ($inputLength <= $length)
        {
            return $input;
        }

        $merge = $tmpMerge = array();
        $threshold = $inputLength - 1;
        for ($i=0; $i <= $threshold; $i++)
        {
            $a = $input[$i];

            /* by this statement, if the next append is the space */
            if (preg_match("/\s+/", $a) && count($tmpMerge) == 0) continue;

            $tmpMerge[$i] = $a;
            $t = implode("", $tmpMerge);
            $ln2 = strlen($t);

            if ($ln2 == $length)
            {
                /*
                    checking whether the last append is a space or not
                    if it is, then we are getting rid of ༼つ◕_◕ ༽つ SPACE
                */
                if (preg_match("/\s+/", $a))
                {
                    unset($tmpMerge[$i]);
                    $merge[] = implode("", $tmpMerge);
                }
                else
                {
                    $merge[] = $t;
                }
                $tmpMerge = array();
            }
            else if ($i ==  $threshold)
            {
                $merge[] = $t;
            }
            else if ($ln2 < $length)
            {
                $diff = $length - $ln2;
                if ($diff <= 1 && preg_match("/\s+/", $a))
                {
                    unset($tmpMerge[$i]);
                    $merge[] = implode("", $tmpMerge);
                    $tmpMerge = array();
                }
            }
        }
        return implode("\n", $merge);
    }
}