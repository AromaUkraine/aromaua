<?php

namespace Modules\Synchronize\Service;

use Illuminate\Support\Facades\Log;
use Modules\Synchronize\Traits\DatabaseLogTrait;

class ReadJsonFileService
{

    use DatabaseLogTrait;

    public function make($path)
    {
        if (\File::exists($path)) {
            $str = file_get_contents($path);
            return $this->strToValidJson($str, $path);
        } else {
            return null;
        }
    }

    protected function strToValidJson($str, $path)
    {

        $str = $this->remove_utf8_bom($str);

        if ($data = $this->json_validate($str, $path)) {
            return $data;
        }

        return null;
    }


    protected function remove_utf8_bom($str)
    {
        $bom = pack('H*', 'EFBBBF');
        $str = preg_replace("/^$bom/", '', $str);
        return $str;
    }


    protected function json_validate($string, $path)
    {
        // decode the JSON data
        $result = json_decode($string, true);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
                // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
                // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
                // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            $this->logToDb('file with path ' . $path . ' has error ' . $error);
            
            abort(403);
        }

        // everything is OK
        return $result;
    }
}