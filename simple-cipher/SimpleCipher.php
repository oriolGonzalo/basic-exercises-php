<?php

declare(strict_types=1);

class SimpleCipher
{
    private const LOWERCASE_LETTERS_BASE = 97;
    private const NUM_OF_LETTERS_IN_ALPHABET = 25;
    private const RESET_LOWERCASE_LETTERS_RANGE = 26;
    
    public string $key;

    private function generateRandomString($length): string {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $random = [];
        for ($i = 0; $i < $length; $i++) {
            $random[$i] = $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return implode("", $random);
    }

    private function valid (string $key): bool {
        if ($key === '' || is_numeric($key) || preg_match('/[A-Z\s]+/', $key)) {
            return false;
        }
        return true;
    }
    
    public function __construct(string $key = null) {
        if (is_null($key)) {
            $this->key = $this->generateRandomString(100);
            return $this->key;
        }
        if ($this->valid($key)) {
            $this->key = $key;
            return $this->key;  
        }
        throw new InvalidArgumentException('Invalid key provided');  
    }

    private function getCipherValues (): array {
        $cipherValues = [];

        foreach (str_split($this->key) as $index => $char) $cipherValues[$index] = ord($char) - self::LOWERCASE_LETTERS_BASE;

        return $cipherValues;
    }

    private function isEncodedCharALetter (int $charToEncodeValue, int $encodingValue): bool {
        if ($charToEncodeValue + $encodingValue <= self::NUM_OF_LETTERS_IN_ALPHABET) return true;

        return false;
    }

    private function encodeChar (int $charToEncodeValue, int $encodingValue): string {
        $encodedCharIsALetter = $this->isEncodedCharALetter($charToEncodeValue, $encodingValue);
            
        if ($encodedCharIsALetter) return chr($charToEncodeValue + $encodingValue + self::LOWERCASE_LETTERS_BASE);
        
        return chr($charToEncodeValue + $encodingValue - self::RESET_LOWERCASE_LETTERS_RANGE + self::LOWERCASE_LETTERS_BASE);
    }

    private function isDecodedCharALetter (int $charToDecodeValue, int $encodingValue): bool {
        if ($charToDecodeValue - $encodingValue >= 0) return true;
        
        return false;
    }

    private function decodeChar (int $charToDecodeValue, int $encodingValue) {
        $decodedCharIsALetter = $this->isDecodedCharALetter($charToDecodeValue, $encodingValue);

        if ($decodedCharIsALetter) return chr($charToDecodeValue - $encodingValue + self::LOWERCASE_LETTERS_BASE);
        
        return chr($charToDecodeValue - $encodingValue + self::RESET_LOWERCASE_LETTERS_RANGE + self::LOWERCASE_LETTERS_BASE);
    }

    public function operateOn (string $UnprocessedText, string $operation) {
        $processedText = '';
        $cipherValues = $this->getCipherValues();
        
        foreach (str_split($UnprocessedText) as $index => $charToProcess) {
            $charToProcessValue = ord($charToProcess) - self::LOWERCASE_LETTERS_BASE;
            $processedChar = call_user_func(array($this, $operation), $charToProcessValue, $cipherValues[$index]);
            $processedText = $processedText . $processedChar;
        }
        return $processedText;
    }

    public function encode(string $plainText): string {    
        return $this->operateOn($plainText, 'encodeChar');
    }

    public function decode(string $cipherText): string {
        return $this->operateOn($cipherText, 'decodeChar');
    }
}