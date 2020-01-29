<?php

/**
 * v 1.1
 */

namespace App;

use Carbon\Carbon;
use Route;

class Helpers
{

    /**
     *  Переделывает строку в ЧПУ также как Str::slug(), но не изменяя русский язык на латиницу
     * @param $str
     * @return string
     */
    public static function str_slug($str)
    {
        // Convert all dashes/underscores into separator
        $flip = $separator = '-';

        $str = preg_replace('!['.preg_quote($flip).']+!u', $separator, $str);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $str = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($str));

        // Replace all separator characters and whitespace by a single separator
        $str = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $str);

        return trim($str, $separator);
    }

    /**
     * Переделывает двумерный массив в строку типа ключ="значение"
     * @param array $array
     * @return string
     */
    public static function array_to_attr_str( array $array )
    {
        if( !is_array($array) || !count($array)) return '';

        $attr = '';
        foreach ($array as $key => $value){
            $attr .= $key . '="' . $value . '" ';
        }
        return trim($attr);
    }

    public static function checkDate($date, $minYear = false, $maxYear = false)
    {
        if( $maxYear === false) $maxYear = Carbon::now()->year;
        $date = preg_replace('/[^0-9]+/', '-', $date);
        preg_match('/([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})/', $date, $matches);

        dd($matches);
    }

    /**
     * Перевод первой буквы строки в верхний регистр с учетом кириллицы в кодировке utf-8
     *
     * @param $text
     * @return string
     */
    public static function mb_ucfirst($text) {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

    // Возвращает число в формате 1 000,00
    public static function number_format($number, $decimals = 2, $dec_point = ',', $thousands_sep = ' ' )
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }

	public static function price_format($number)
    {
        return number_format($number, 2, ',', ' ');
    }

    public static function weight_format($number)
    {
        return number_format($number, 3, '.', ' ');
    }


    public static function normalizePrice($price)
    {
        return self::normalizeFloat($price);
    }

    public static function normalizeFloat($value)
    {
        $value = (float) str_replace(',', '.', $value);
        return $value ?? 0;
    }

    /**
     * Проверка есть ли в сессии флаг, что надо подсветить значение или массив значений
     *
     * @param mixed $value
     * @return bool
     */
    public static function isHL($value)
    {
        $result = false;

        if( $hl = session('hl') ){

            if( is_array($hl) && in_array($value, $hl) ){

                $result = true;

            } elseif( $value == $hl ) {

                $result = true;

            }

        }

        return $result;
    }

    public static function setHL($item)
    {
        session()->flash('hl', is_object($item) ? $item->id : $item);
    }

    /**
     * Убирает из строки запроса часть у указанием страницы
     *
     * @param $url
     * @return null|string|string[]
     */
    public static function url_crop_page($url)
    {
        return preg_replace('/[&]*page=[0-9]*/', '', $url);
    }

    public static function getFilters($filter_name, $default_route = null)
    {
        return session('filters.'.$filter_name, $default_route);
    }
}
