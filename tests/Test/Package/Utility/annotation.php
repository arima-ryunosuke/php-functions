<?php

namespace This\Is\Space;

class DateTime2 extends \DateTime
{
    /**
     * @message this is annotation
     */
    public function method() { }
}

// @formatter:off
return new class
{
    /**
     * this is \@escape
     * @single 123
     * @closure 123 + 456
     * @multi a b c
     * @quote "a b c" 123
     * @noval
     * @noval
     * @hash {a: 123}
     * @list [123, 456]
     * @DateTime2("2019/12/23")
     * @hashX{a: 123}
     * @listX[123, 456]
     * @block message {
     *     this is message1
     *     this is message2
     * }
     * @blockX message1 {
     *     this is message1
     * }
     * @blockX message2 {
     *     this is message2
     * }
     * @double a
     * @double b
     * @double c
     *
     * this is \@escape
     * @param string $arg1 引数1
     * @param	array	 $arg2 this is second argument
     * @return null 返り値
     * this is \@escape
     */
    function m($arg1, $arg2){}
};
// @formatter:on
