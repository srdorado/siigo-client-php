<?php

namespace Srdorado\SiigoClient\Utils;

class Utils
{
    /**
     * Validate if name is valid
     *
     * @param string $name
     * @return bool
     */
    public static function isNameValid(string $name): bool
    {
        $result = true;
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $result = false;
        }
        return $result;
    }

    /**
     * Validate if email is valid
     *
     * @param string $email
     * @return bool
     */
    public static function isEmailValid(string $email): bool
    {
        $result = true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }
        return $result;
    }

    /**
     * Reemplaza sólo la primera ocurrencia de un texto por otro.
     * Es insensible a mayúsculas y minúsculas pero no a los acentos.
     * Si no existe la ocurrencia, devuelve el mismo string
     *
     * @param string $txt
     * @param string $origen
     * @param string $destino
     *
     * @return string
     */
    public static function replaceFirst(string $txt, string $origen, string $destino): string
    {
        $origen = '/' . preg_quote('' . $origen, '/') . '/i';
        return '' . preg_replace($origen, '' . $destino, '' . $txt, 1);
    }

    /**
     * Validate if date is valid
     *
     * @param string $format
     * @param string $date
     * @return bool
     */
    public static function isDateValid(string $format, string $date): bool
    {
        $result = false;
        if (date($format, strtotime($date)) == $date) {
            $result = true;
        }
        return $result;
    }
}
