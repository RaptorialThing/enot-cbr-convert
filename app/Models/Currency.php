<?php

namespace App\Models;
use App\Models\Model;

class Currency extends Model
{
    protected static $table = "currencies";

    static public function curl_currencies()
    {
        $content = file_get_contents("https://cbr.ru/scripts/XML_daily.asp");
        $xml = simplexml_load_string($content);
        $res = [];
        foreach ($xml as $valute) {
            $res[] = [ 
                        "ID" => strval($valute["ID"]),
                        "NumCode" => strval($valute->NumCode),
                        "CharCode" => strval($valute->CharCode),
                        "Nominal" => strval($valute->Nominal),
                        "Name" => strval($valute->Name),
                        "Value" => strval($valute->Value)
                     ];

            static::insertOrUpdate([
                        "cbr_id" => strval($valute["ID"]),
                        "num_code" => intval($valute->NumCode),
                        "char_code" => strval($valute->CharCode),
                        "nominal" => intval($valute->Nominal),
                        "name" => strval($valute->Name),
                        "value" => strval($valute->Value)
            ]);

        }

        return $res;
    }
}
