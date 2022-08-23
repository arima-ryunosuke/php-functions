<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait hash_0
{
    /** @see \hash() */
    public function hash(string $algo, string $data, bool $binary = false): self { }
    public function hash0(string $data, bool $binary = false): self { }
    public function hash1(string $algo, bool $binary = false): self { }
    public function hash2(string $algo, string $data): self { }

    /** @see \hash_copy() */
    public self $hash_copy;
    public function hash_copy(\HashContext $context): self { }
    public function hash_copy0(): self { }

    /** @see \hash_equals() */
    public function hash_equals(string $known_string, string $user_string): self { }
    public function hash_equals0(string $user_string): self { }
    public function hash_equals1(string $known_string): self { }

    /** @see \hash_file() */
    public function hash_file(string $algo, string $filename, bool $binary = false): self { }
    public function hash_file0(string $filename, bool $binary = false): self { }
    public function hash_file1(string $algo, bool $binary = false): self { }
    public function hash_file2(string $algo, string $filename): self { }

    /** @see \hash_final() */
    public self $hash_final;
    public function hash_final(\HashContext $context, bool $binary = false): self { }
    public function hash_final0(bool $binary = false): self { }
    public function hash_final1(\HashContext $context): self { }

    /** @see \hash_hkdf() */
    public function hash_hkdf(string $algo, string $key, int $length = 0, string $info = "", string $salt = ""): self { }
    public function hash_hkdf0(string $key, int $length = 0, string $info = "", string $salt = ""): self { }
    public function hash_hkdf1(string $algo, int $length = 0, string $info = "", string $salt = ""): self { }
    public function hash_hkdf2(string $algo, string $key, string $info = "", string $salt = ""): self { }
    public function hash_hkdf3(string $algo, string $key, int $length = 0, string $salt = ""): self { }
    public function hash_hkdf4(string $algo, string $key, int $length = 0, string $info = ""): self { }

    /** @see \hash_hmac() */
    public function hash_hmac(string $algo, string $data, string $key, bool $binary = false): self { }
    public function hash_hmac0(string $data, string $key, bool $binary = false): self { }
    public function hash_hmac1(string $algo, string $key, bool $binary = false): self { }
    public function hash_hmac2(string $algo, string $data, bool $binary = false): self { }
    public function hash_hmac3(string $algo, string $data, string $key): self { }

    /** @see \hash_hmac_file() */
    public function hash_hmac_file(string $algo, string $data, string $key, bool $binary = false): self { }
    public function hash_hmac_file0(string $data, string $key, bool $binary = false): self { }
    public function hash_hmac_file1(string $algo, string $key, bool $binary = false): self { }
    public function hash_hmac_file2(string $algo, string $data, bool $binary = false): self { }
    public function hash_hmac_file3(string $algo, string $data, string $key): self { }

    /** @see \hash_init() */
    public self $hash_init;
    public function hash_init(string $algo, int $flags = 0, string $key = ""): self { }
    public function hash_init0(int $flags = 0, string $key = ""): self { }
    public function hash_init1(string $algo, string $key = ""): self { }
    public function hash_init2(string $algo, int $flags = 0): self { }

    /** @see \hash_pbkdf2() */
    public function hash_pbkdf2(string $algo, string $password, string $salt, int $iterations, int $length = 0, bool $binary = false): self { }
    public function hash_pbkdf20(string $password, string $salt, int $iterations, int $length = 0, bool $binary = false): self { }
    public function hash_pbkdf21(string $algo, string $salt, int $iterations, int $length = 0, bool $binary = false): self { }
    public function hash_pbkdf22(string $algo, string $password, int $iterations, int $length = 0, bool $binary = false): self { }
    public function hash_pbkdf23(string $algo, string $password, string $salt, int $length = 0, bool $binary = false): self { }
    public function hash_pbkdf24(string $algo, string $password, string $salt, int $iterations, bool $binary = false): self { }
    public function hash_pbkdf25(string $algo, string $password, string $salt, int $iterations, int $length = 0): self { }

    /** @see \hash_update() */
    public function hash_update(\HashContext $context, string $data): self { }
    public function hash_update0(string $data): self { }
    public function hash_update1(\HashContext $context): self { }

    /** @see \hash_update_file() */
    public function hash_update_file(\HashContext $context, string $filename, $stream_context = null): self { }
    public function hash_update_file0(string $filename, $stream_context = null): self { }
    public function hash_update_file1(\HashContext $context, $stream_context = null): self { }
    public function hash_update_file2(\HashContext $context, string $filename): self { }

    /** @see \hash_update_stream() */
    public function hash_update_stream(\HashContext $context, $stream, int $length = -1): self { }
    public function hash_update_stream0($stream, int $length = -1): self { }
    public function hash_update_stream1(\HashContext $context, int $length = -1): self { }
    public function hash_update_stream2(\HashContext $context, $stream): self { }

    /** @see \mhash() */
    public function mhash(int $algo, string $data, ?string $key = null): self { }
    public function mhash0(string $data, ?string $key = null): self { }
    public function mhash1(int $algo, ?string $key = null): self { }
    public function mhash2(int $algo, string $data): self { }

    /** @see \mhash_get_block_size() */
    public self $mhash_get_block_size;
    public function mhash_get_block_size(int $algo): self { }
    public function mhash_get_block_size0(): self { }

    /** @see \mhash_get_hash_name() */
    public self $mhash_get_hash_name;
    public function mhash_get_hash_name(int $algo): self { }
    public function mhash_get_hash_name0(): self { }

    /** @see \mhash_keygen_s2k() */
    public function mhash_keygen_s2k(int $algo, string $password, string $salt, int $length): self { }
    public function mhash_keygen_s2k0(string $password, string $salt, int $length): self { }
    public function mhash_keygen_s2k1(int $algo, string $salt, int $length): self { }
    public function mhash_keygen_s2k2(int $algo, string $password, int $length): self { }
    public function mhash_keygen_s2k3(int $algo, string $password, string $salt): self { }

}
