<?php

    namespace application\components\helpers;

    use \Yii;
    use \CException;

    /**
     * Text Helper
     *
     * A helper class for manipulating text.
     *
     * @author      Zander Baldwin <mynameiszanders@gmail.com>
     * @link        https://github.com/mynameiszanders/chaser
     * @copyright   2013 Zander Baldwin
     * @license     MIT/X11 <http://j.mp/mit-license>
     */
    class Text extends \CComponent
    {

        /**
         * Is UTF8?
         *
         * Detect if the given string is a UTF8 string (or at least contains UTF8 characters).
         *
         * @static
         * @access public
         * @param string $str The string that should be checked.
         * @return boolean
         */
        public static function isUTF8($str)
        {
            $length = strlen($str);
            for($i = 0; $i < $length; $i++) {
                $c = ord($str[$i]);
                if($c < 0x80) {
                    // 0bbbbbbb
                    $n = 0;
                }
                elseif(($c & 0xE0) == 0xC0) {
                    // 110bbbbb
                    $n = 1;
                }
                elseif(($c & 0xF0) == 0xE0) {
                    // 1110bbbb
                    $n = 2;
                }
                elseif(($c & 0xF8) == 0xF0) {
                    // 11110bbb
                    $n = 3;
                }
                elseif(($c & 0xFC) == 0xF8) {
                    // 111110bb
                    $n = 4;
                }
                elseif(($c & 0xFE) == 0xFC) {
                    // 1111110b
                    $n = 5;
                }
                else {
                    // Does not match any model.
                    return false;
                }
                for($j = 0; $j < $n; $j++) {
                    if((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80)) {
                        return false;
                    }
                }
            }
            return true;
        }

        /**
         * Anglicise String
         *
         * Convert all accent characters to ASCII characters, if there are no accent characters then the string is
         * returned as-is.
         *
         * @static
         * @access public
         * @param string $str
         * @return string
         */
        public static function anglicise($str)
        {
            $map = array(
                '/ä|æ|ǽ/'                           => 'ae',
                '/ö|œ/'                             => 'oe',
                '/ü/'                               => 'ue',
                '/Ä/'                               => 'Ae',
                '/Ü/'                               => 'Ue',
                '/Ö/'                               => 'Oe',
                '/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/'             => 'A',
                '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/'           => 'a',
                '/Ç|Ć|Ĉ|Ċ|Č/'                       => 'C',
                '/ç|ć|ĉ|ċ|č/'                       => 'c',
                '/Ð|Ď|Đ/'                           => 'D',
                '/ð|ď|đ/'                           => 'd',
                '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/'               => 'E',
                '/è|é|ê|ë|ē|ĕ|ė|ę|ě/'               => 'e',
                '/Ĝ|Ğ|Ġ|Ģ/'                         => 'G',
                '/ĝ|ğ|ġ|ģ/'                         => 'g',
                '/Ĥ|Ħ/'                             => 'H',
                '/ĥ|ħ/'                             => 'h',
                '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/'             => 'I',
                '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/'             => 'i',
                '/Ĵ/'                               => 'J',
                '/ĵ/'                               => 'j',
                '/Ķ/'                               => 'K',
                '/ķ/'                               => 'k',
                '/Ĺ|Ļ|Ľ|Ŀ|Ł/'                       => 'L',
                '/ĺ|ļ|ľ|ŀ|ł/'                       => 'l',
                '/Ñ|Ń|Ņ|Ň/'                         => 'N',
                '/ñ|ń|ņ|ň|ŉ/'                       => 'n',
                '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/'           => 'O',
                '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/'         => 'o',
                '/Ŕ|Ŗ|Ř/'                           => 'R',
                '/ŕ|ŗ|ř/'                           => 'r',
                '/Ś|Ŝ|Ş|Ș|Š/'                       => 'S',
                '/ś|ŝ|ş|ș|š|ſ/'                     => 's',
                '/Ţ|Ț|Ť|Ŧ|Þ/'                       => 'T',
                '/ţ|ț|ť|ŧ/'                         => 't',
                '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/'   => 'U',
                '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/'   => 'u',
                '/Ý|Ÿ|Ŷ/'                           => 'Y',
                '/ý|ÿ|ŷ/'                           => 'y',
                '/Ŵ/'                               => 'W',
                '/ŵ/'                               => 'w',
                '/Ź|Ż|Ž/'                           => 'Z',
                '/ź|ż|ž/'                           => 'z',
                '/Æ|Ǽ/'                             => 'AE',
                '/ß/'                               => 'ss',
                '/Ĳ/'                               => 'IJ',
                '/ĳ/'                               => 'ij',
                '/Œ/'                               => 'OE',
                '/ƒ/'                               => 'f'
            );
            return preg_replace(array_keys($map), array_values($map), $str);
        }


        /**
         * Slugify
         *
         * @access public
         * @param string $string ""
         * @param string $replacement ""
         * @return string
         */
        public static function slugify($string, $replacement = '-')
        {
            $quotedReplacement = preg_quote($replacement, '/');
            if(self::isUTF8($string)) {
                $string = self::anglicise($string);
            }
            $string = str_replace($replacement, ' ', $string);
            // Replace any word character with a space, so that words get separated.
            $string = preg_replace('/\\W/', ' ', $string);
            return strtolower(trim(substr(preg_replace(
                array(
                    '/[^\\s\\p{Zs}\\p{Ll}\\p{Lm}\\p{Lo}\\p{Lt}\\p{Lu}\\p{Nd}]/mu',
                    '/[\\s\\p{Zs}]+/mu',
                    sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement),
                ),
                array(
                    '',
                    $replacement,
                    '',
                ),
                $string
            ), 0, 64), '-'));
        }

    }
