<?php


namespace Feature;

/**
 * Class Util
 * @package Feature
 */
class Util
{
    /**
     * @return float
     */
    public static function random()
    {
        return mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
    }

    /**
     * @param $id
     * @return float
     */
    public static function randomById($id)
    {
        return static::mapHex(hash('sha256', $id));
    }

    /**
     * @param array $array
     * @param string $key
     * @param null|mixed $default
     * @return null|mixed
     */
    public static function arrayGet(array $array, $key, $default = null)
    {
        return is_array($array) && array_key_exists($key, $array) ? $array[$key] : $default;
    }

    /**
     * @param string $hex
     * @return float
     */
    private static function mapHex($hex)
    {
        $len = min(40, strlen($hex));
        $vMax = 1 << $len;
        $v = 0;
        for ($i = 0; $i < $len; $i++) {
            $bit = hexdec($hex[$i]) < 8 ? 0 : 1;
            $v = ($v << 1) + $bit;
        }
        $w = $v / $vMax;
        return $w;
    }
}
