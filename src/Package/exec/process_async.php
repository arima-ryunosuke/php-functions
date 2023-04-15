<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * proc_open ～ proc_close の一連の処理を行う（非同期版）
 *
 * @package ryunosuke\Functions\Package\exec
 * @see process()
 *
 * @param string $command 実行コマンド
 * @param array|string $args コマンドライン引数。文字列はそのまま結合され、配列は escapeshellarg された上でキーと結合される
 * @param string|resource $stdin 標準入力（string を渡すと単純に読み取れられる。resource を渡すと fread される）
 * @param string|resource $stdout 標準出力（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
 * @param string|resource $stderr 標準エラー（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
 * @param ?string $cwd 作業ディレクトリ
 * @param ?array $env 環境変数
 * @return \ProcessAsync|object プロセスオブジェクト
 */
function process_async($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null)
{
    if (is_array($args)) {
        $statement = [$command];
        foreach ($args as $k => $v) {
            if (!is_int($k)) {
                $statement[] = $k;
            }
            $statement[] = $v;
        }
    }
    else {
        $statement = escapeshellcmd($command) . " $args";
    }

    $proc = proc_open($statement, [
        0 => is_resource($stdin) ? $stdin : ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ], $pipes, $cwd, $env);

    if ($proc === false) {
        // どうしたら失敗するのかわからない
        throw new \RuntimeException("$command start failed."); // @codeCoverageIgnore
    }

    if (!is_resource($stdin)) {
        fwrite($pipes[0], $stdin);
        fclose($pipes[0]);
    }
    if (!is_resource($stdout)) {
        $stdout = '';
    }
    if (!is_resource($stderr)) {
        $stderr = '';
    }

    stream_set_blocking($pipes[1], false);
    stream_set_blocking($pipes[2], false);
    stream_set_read_buffer($pipes[1], 4096);
    stream_set_read_buffer($pipes[2], 4096);

    return new class($proc, $pipes, $stdout, $stderr) {
        private $proc;
        private $pipes;
        private $status;
        private $destructAction;
        public  $stdout;
        public  $stderr;

        public function __construct($proc, $pipes, &$stdout, &$stderr)
        {
            $this->proc = $proc;
            $this->pipes = $pipes;
            $this->stdout = &$stdout;
            $this->stderr = &$stderr;
            $this->destructAction = 'close';
        }

        public function __destruct()
        {
            if ($this->destructAction === 'close') {
                $this->__invoke();
            }
            if ($this->destructAction === 'terminate') {
                $this->terminate();
            }
        }

        public function __invoke()
        {
            if ($this->proc === null) {
                return $this->status['exitcode'];
            }

            try {
                /** @noinspection PhpStatementHasEmptyBodyInspection */
                while ($this->update()) {
                    // noop
                }
            }
            finally {
                $this->status = proc_get_status($this->proc);
                fclose($this->pipes[1]);
                fclose($this->pipes[2]);
                $rc = proc_close($this->proc);
                $this->proc = null;
            }

            return $this->status['running'] ? $rc : $this->status['exitcode'];
        }

        public function setDestructAction($action)
        {
            $this->destructAction = $action;
            return $this;
        }

        public function update()
        {
            if ($this->proc === null || (feof($this->pipes[1]) && feof($this->pipes[2]))) {
                return false;
            }

            $read = [$this->pipes[1], $this->pipes[2]];
            $write = $except = null;
            if (stream_select($read, $write, $except, 1) === false) {
                // （システムコールが別のシグナルによって中断された場合などに起こりえます）
                throw new \RuntimeException('stream_select failed.'); // @codeCoverageIgnore
            }
            foreach ($read as $fp) {
                $buffer = fread($fp, 1024);
                if ($fp === $this->pipes[1]) {
                    if (!is_resource($this->stdout)) {
                        $this->stdout .= $buffer;
                    }
                    else {
                        fwrite($this->stdout, $buffer);
                    }
                }
                elseif ($fp === $this->pipes[2]) {
                    if (!is_resource($this->stderr)) {
                        $this->stderr .= $buffer;
                    }
                    else {
                        fwrite($this->stderr, $buffer);
                    }
                }
            }
            return true;
        }

        public function status()
        {
            $this->update();
            return $this->status ?? proc_get_status($this->proc);
        }

        public function terminate()
        {
            if ($this->proc === null) {
                return !$this->status['running'];
            }

            fclose($this->pipes[1]);
            fclose($this->pipes[2]);
            proc_terminate($this->proc);
            // terminate はシグナルを送るだけなので終了を待つ（さらに SIGTERM なので終わらないかもしれないので1秒ほどで打ち切る）
            for ($i = 0; $i < 100; $i++, usleep(10_000)) {
                $this->status = proc_get_status($this->proc);
                if (!$this->status['running']) {
                    break;
                }
            }
            $this->proc = null;
            return !$this->status['running'];
        }
    };
}
