<?php

declare(strict_types=1);

class SimpleCipher
{
    public $key;

    public function __construct(string $key = null) {
        if (isset($key) && $key === '' 
        || isset($key) && is_numeric($key)
        || isset($key) && ord($key) < 97 && ord($key) >= 00
        ) {
            throw new InvalidArgumentException('Invalid cipher provided');
        } else if (is_null($key)) {
            $this->key = $this->generateRandomString(100);
        } else {
            $this->key = $key;
        }        
        return $this->key;
    }

    public function generateRandomString($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function encode(string $plainText): string {
        if (is_null($this->key)) return $plainText;

        $cipherValues = [];
        
        foreach (str_split($this->key) as $keyChar) array_push($cipherValues, ord($keyChar) - 97);
        
        $encodedText = '';

        foreach (str_split($plainText) as $key => $charToEncode) {
            $charToEncodeValue = ord($charToEncode) - 97;
            
            if ($charToEncodeValue + $cipherValues[$key] <= 25) {
                $encodedCharValue = $charToEncodeValue + $cipherValues[$key];
            } else {
                $encodedCharValue = $charToEncodeValue + $cipherValues[$key] - 26;
            }
            $encodedChar = chr($encodedCharValue + 97);
            $encodedText = $encodedText . $encodedChar;
        }
        return $encodedText;
    }

    public function decode(string $cipherText): string {
        $cipherValues = [];
        
        foreach (str_split($this->key) as $keyChar) array_push($cipherValues, ord($keyChar) - 97);

        $decodedText = '';

        foreach (str_split($cipherText) as  $key => $char) 
        {
            $charValue = ord(strtolower($char)) - 97;
            
            if ($charValue - $cipherValues[$key] >= 0) {
                $decodedCharValue = $charValue - $cipherValues[$key];
            } else {
                $decodedCharValue = $charValue - $cipherValues[$key] + 26;
            }
            $decodedChar = chr($decodedCharValue + 97);
            $decodedText = $decodedText . $decodedChar;
        }
        return $decodedText;
    }
}