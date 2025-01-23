<?php

namespace App\Helpers;

class FormatHelper
{
	public static function swapString($oldString)
    {
        $character = [
            "á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","Ã","Ì","Ò",
            "Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚",
            "ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","#",
            "<1","<2","<3","<4","<5","<6","<7","<8","<9",
            "< 1","< 2","< 3","< 4","< 5","< 6","< 7","< 8","< 9",
            "<  1","<  2","<  3","<  4","<  5","<  6","<  7","<  8","<  9",
            "<<", "\n", "\t", "\r"
        ];
        $rules = [
            "a","e","i","o","u","A","E","I","O","U","n","N","A","E","I",
            "O","U","a","e","i","o","u","c","C","a","e","i","o","u","A",
            "E","I","O","U","u","o","O","i","a","e","U","I","A","E","",
            " MENOR 1"," MENOR 2"," MENOR 3"," MENOR 4"," MENOR 5",
            " MENOR 6"," MENOR 7"," MENOR 8"," MENOR 9"," MENOR 1",
            " MENOR 2"," MENOR 3"," MENOR 4"," MENOR 5"," MENOR 6",
            " MENOR 7"," MENOR 8"," MENOR 9"," MENOR 1"," MENOR 2",
            " MENOR 3"," MENOR 4"," MENOR 5"," MENOR 6"," MENOR 7",
            " MENOR 8"," MENOR 9", "", " ", " ", ""
        ];
        $newString = str_replace($character, $rules, $oldString);
        return $newString;
    }

    public static function extractPhone($phone = "")
    {
        $countryCode = substr($phone, 0, 2);
        if (strlen($phone) > 9) {
            switch ((int)$countryCode) {
                case 51:
                    return substr($phone, 2);
                    break;
                default:
                    break;
            }
        } else {
            $firstNumber = substr($phone, 0);
            switch ((int)$firstNumber) {
                case 1:
                    return substr($phone, 1);
                    break;
                default:
                    break;
            }
        }
        return $phone;
    }
}