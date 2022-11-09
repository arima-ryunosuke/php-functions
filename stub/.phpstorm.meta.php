<?php
namespace PHPSTORM_META {

    override(\ChainObject::__call(),
        map([
            '' => \ChainObject::class,
        ])
    );
    override(\ChainObject::__invoke(),
        map([
            '' => \ChainObject::class,
        ])
    );
}
