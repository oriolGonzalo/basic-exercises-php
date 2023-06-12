<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

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