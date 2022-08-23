<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait pcre_0
{
    /** @see \preg_filter() */
    public function preg_filter(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_filter0(array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_filter1(array|string $pattern, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_filter2(array|string $pattern, array|string $replacement, int $limit = -1, &$count = null): self { }
    public function preg_filter3(array|string $pattern, array|string $replacement, array|string $subject, &$count = null): self { }
    public function preg_filter4(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1): self { }

    /** @see \preg_grep() */
    public function preg_grep(string $pattern, array $array, int $flags = 0): self { }
    public function preg_grep0(array $array, int $flags = 0): self { }
    public function preg_grep1(string $pattern, int $flags = 0): self { }
    public function preg_grep2(string $pattern, array $array): self { }

    /** @see \preg_match() */
    public function preg_match(string $pattern, string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match0(string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match1(string $pattern, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match2(string $pattern, string $subject, int $flags = 0, int $offset = 0): self { }
    public function preg_match3(string $pattern, string $subject, &$matches = null, int $offset = 0): self { }
    public function preg_match4(string $pattern, string $subject, &$matches = null, int $flags = 0): self { }

    /** @see \preg_match_all() */
    public function preg_match_all(string $pattern, string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match_all0(string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match_all1(string $pattern, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match_all2(string $pattern, string $subject, int $flags = 0, int $offset = 0): self { }
    public function preg_match_all3(string $pattern, string $subject, &$matches = null, int $offset = 0): self { }
    public function preg_match_all4(string $pattern, string $subject, &$matches = null, int $flags = 0): self { }

    /** @see \preg_quote() */
    public self $preg_quote;
    public function preg_quote(string $str, ?string $delimiter = null): self { }
    public function preg_quote0(?string $delimiter = null): self { }
    public function preg_quote1(string $str): self { }

    /** @see \preg_replace() */
    public function preg_replace(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_replace0(array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_replace1(array|string $pattern, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_replace2(array|string $pattern, array|string $replacement, int $limit = -1, &$count = null): self { }
    public function preg_replace3(array|string $pattern, array|string $replacement, array|string $subject, &$count = null): self { }
    public function preg_replace4(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1): self { }

    /** @see \preg_replace_callback() */
    public function preg_replace_callback(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback0(callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback1(array|string $pattern, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback2(array|string $pattern, callable $callback, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback3(array|string $pattern, callable $callback, array|string $subject, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback4(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_replace_callback5(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_replace_callbackP(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback0P(callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback1P(array|string $pattern, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback2P(array|string $pattern, callable $callback, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback3P(array|string $pattern, callable $callback, array|string $subject, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback4P(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_replace_callback5P(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_replace_callbackE(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback0E(callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback1E(array|string $pattern, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback2E(array|string $pattern, callable $callback, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback3E(array|string $pattern, callable $callback, array|string $subject, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback4E(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_replace_callback5E(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null): self { }

    /** @see \preg_replace_callback_array() */
    public function preg_replace_callback_array(array $pattern, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback_array0(array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback_array1(array $pattern, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback_array2(array $pattern, array|string $subject, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback_array3(array $pattern, array|string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_replace_callback_array4(array $pattern, array|string $subject, int $limit = -1, &$count = null): self { }

    /** @see \preg_split() */
    public function preg_split(string $pattern, string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_split0(string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_split1(string $pattern, int $limit = -1, int $flags = 0): self { }
    public function preg_split2(string $pattern, string $subject, int $flags = 0): self { }
    public function preg_split3(string $pattern, string $subject, int $limit = -1): self { }

}
