<?php

declare(strict_types=1);

class SimpleCipherTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        require_once 'SimpleCipher.php';
    }

    public function testRandomCipherKeyIsLetters(): void
    {
        $cipher = new SimpleCipher();
        $this->assertMatchesRegularExpression('/\A[a-z]+\z/', $cipher->key);
    }

    /**
     * Here we take advantage of the fact that plaintext of "aaa..." doesn't
     * output the key. This is a critical problem with shift ciphers, some
     * characters will always output the key verbatim.
     */
    public function testRandomKeyCipherEncode(): void
    {
        $cipher = new SimpleCipher();
        $plaintext = 'aaaaaaaaaa';
        $this->assertEquals(substr($cipher->key, 0, 10), $cipher->encode($plaintext));
    }

    public function testRandomKeyCipherDecode(): void
    {
        $cipher = new SimpleCipher();
        $plaintext = 'aaaaaaaaaa';
        $this->assertEquals($plaintext, $cipher->decode(substr($cipher->key, 0, 10)));
    }

    public function testRandomKeyCipherReversible(): void
    {
        $cipher = new SimpleCipher();
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));
    }

    public function testCipherWithCapsKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $cipher = new SimpleCipher('ABCDEF');
    }

    public function testCipherWithNumericKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $cipher = new SimpleCipher('12345');
    }

    public function testCipherWithEmptyKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $cipher = new SimpleCipher('');
    }

    public function testCipherKeyIsAsSubmitted(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $this->assertEquals($cipher->key, 'abcdefghij');
    }

    public function testCipherEncode(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'abcdefghij';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    public function testCipherDecode(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($ciphertext));
    }

    public function testCipherReversible(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));
    }

    public function testDoubleShiftEncode(): void
    {
        $cipher = new SimpleCipher('iamapandabear');
        $plaintext = 'iamapandabear';
        $ciphertext = 'qayaeaagaciai';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    public function testCipherEncodeWrap(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'zzzzzzzzzz';
        $ciphertext = 'zabcdefghi';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    public function testShiftCipherEncode(): void
    {
        $cipher = new SimpleCipher('dddddddddd');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'dddddddddd';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    public function testShiftCipherDecode(): void
    {
        $cipher = new SimpleCipher('dddddddddd');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'dddddddddd';
        $this->assertEquals($plaintext, $cipher->decode($ciphertext));
    }

    public function testShiftCipherReversible(): void
    {
        $cipher = new SimpleCipher('dddddddddd');
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));
    }
}
