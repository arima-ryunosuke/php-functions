<?php

/**
 * cpu_timer 関数のためのクラススタブ
 *
 * @used-by \cpu_timer()
 * @used-by \ryunosuke\Functions\cpu_timer()
 * @used-by \ryunosuke\Functions\Package\cpu_timer()
 */
class CpuTimer
{
    public function start(): void { }

    /**
     * @return array{real:float, user:float, system:float, time:float, idle:float, "user%":float, "system%":float, "time%":float, "idle%":float}
     */
    public function result(): array { }

    /**
     * @return array{real:float, user:float, system:float, time:float, idle:float, "user%":float, "system%":float, "time%":float, "idle%":float}
     */
    public function __invoke(callable $callback): array { }
}
