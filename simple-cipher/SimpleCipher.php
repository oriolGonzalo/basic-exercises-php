<?php

declare(strict_types=1);

class SimpleCipher
{
    private $key;

    public function __construct(string $key = null)
    {
        $this->key = $key;
        
        return $this->key;
    }

    public function encode(string $plainText): string
    {
        if (is_null($this->key)) return $plainText;

        $encodedText = '';
        $cipherValue = ord(strtolower($this->key)) - 96;

        foreach (str_split($plainText) as $char) {
            echo $char . "\n";

            $charValue = ord(strtolower($char)) - 96;
            $encodedCharValue = $charValue + $cipherValue;
            $encodedText = $encodedText . $encodedCharValue;
        }
        // Para convertir de nuevo a carácter: $letter = chr(encodedAsNumber);
        echo $encodedText . "\n";

        // Iterar sobre l'string 
        // Augmentar
        return '';
    }

    public function decode(string $cipherText): string
    {
        if (is_null($this->key)) return $plainText;

    }
}

$cipher = new SimpleCipher();
$output = $cipher->encode('aaaaaaaaaa');
echo $output;