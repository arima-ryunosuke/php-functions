<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * phpinfo の opcache 特化版
 *
 * この関数は互換性を考慮しない。
 *
 * @package ryunosuke\Functions\Package\opcache
 */
function opcache_info()
{
    $V = function ($value, $type = null) use (&$V) {
        $type ??= match (true) {
            default          => 'string',
            is_array($value) => 'array',
            is_bool($value)  => 'json',
            is_float($value) => 'percent',
            is_int($value)   => 'integer',
        };

        if ($type === 'array') {
            return "<details><summary>{$V(count($value))} count</summary>{$V(implode("\n", $value))}</details>";
        }

        $value = match ($type) {
            default    => $value,
            'json'     => json_encode($value),
            'integer'  => number_format($value, 0),
            'percent'  => number_format($value, 3) . ' %',
            'datetime' => $value ? date('Y-m-d H:i:s', $value) : '-',
        };
        return htmlspecialchars($value, ENT_QUOTES);
    };

    $opcacheinfo = (function () {
        $config = opcache_get_configuration() ?: [];
        $status = opcache_get_status() ?: [];

        return [
            'version'    => $config['version'] ?? [],
            'directives' => $config['directives'] ?? [],
            'blacklist'  => $config['blacklist'] ?? [],
            'preload'    => $status['preload_statistics'] ?? [
                    'memory_consumption' => 0,
                    'scripts'            => [],
                    'functions'          => [],
                    'classes'            => [],
                ],
            'jit'        => $status['jit'] ?? [],
            'status'     => array_filter($status, fn($v) => !is_array($v)),
            'memory'     => $status['memory_usage'] ?? [],
            'strings'    => $status['interned_strings_usage'],
            'statistics' => $status['opcache_statistics'],
            'scripts'    => $status['scripts'],
        ];
    })();

    ?>
    <style>
        h1 {
            border: 1px solid #666;
            vertical-align: baseline;
            padding: 4px 5px;
            text-align: left;
            font-size: 150%;
            background-color: #99c;
        }

        h2 {
            font-size: 125%;
        }

        table {
            margin: 1em auto;
            text-align: left;
            border-collapse: collapse;
            border: 0;
            width: calc(100vw - 4em);
            box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.2);
        }

        th, td {
            border: 1px solid #666;
            font-size: 75%;
            vertical-align: baseline;
            padding: 4px 5px;
            white-space: pre-line;
        }

        th.header {
            text-align: center;
            position: sticky;
            top: 0;
            background-color: #99c;
            font-weight: bold;
            min-width: 64px;
        }

        td.title {
            background-color: #ccf;
            width: 320px;
            font-weight: bold;
            white-space: nowrap;
        }

        td.value {
            background-color: #ddd;
            max-width: 300px;
            overflow-x: auto;
            word-wrap: break-word;
        }

        td.number {
            text-align: right;
        }

        td.datetime {
            text-align: center;
            width: 120px;
        }

        th .sorter {
            position: relative;
            padding-left: 4px;

            a[data-sort-order] {
                cursor: pointer;
                position: absolute;
                opacity: 0.4;

                &.active {
                    opacity: 1.0;
                }

                &[data-sort-order="asc"] {
                    top: -0.75em;
                }

                &[data-sort-order="desc"] {
                    bottom: -0.75em;
                }
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.sorter').forEach(function (sorter) {
                sorter.addEventListener('click', function (e) {
                    const a = e.target;
                    if (!a.matches('a[data-sort-order]')) {
                        return;
                    }

                    a.closest('thead').querySelectorAll('[data-sort-order]').forEach((a) => a.classList.remove('active'));
                    a.classList.add('active');

                    const unit = a.dataset.sortOrder === 'asc' ? +1 : -1;
                    const index = a.closest('th').cellIndex;
                    const schwartzian = Array.from(a.closest('table').tBodies[0].rows, (tr) => [
                        tr,
                        JSON.parse(tr.cells[index].dataset.sortValue),
                    ]);
                    schwartzian.sort(([, a], [, b]) => (a === b ? 0 : a > b ? +1 : -1) * unit);
                    schwartzian.forEach(([tr]) => tr.parentElement.appendChild(tr));
                });
            });
        });
    </script>

    <h1><?= $V($opcacheinfo['version']['opcache_product_name']) ?> <?= $V($opcacheinfo['version']['version']) ?></h1>

    <h2>Directives</h2>
    <table>
        <thead>
        <tr>
            <th class="header">Name</th>
            <th class="header">Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($opcacheinfo['directives'] as $key => $value): ?>
            <tr>
                <td class="title"><?= $V($key) ?></td>
                <td class="value"><?= match ($key) {
                        'opcache.blacklist_filename' => $V($value) . $V($opcacheinfo['blacklist']),
                        default                      => $V($value),
                    } ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <h2>Preload</h2>
    <table>
        <thead>
        <tr>
            <th class="header">Name</th>
            <th class="header">Value</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="title"><?= $V('memory_consumption') ?></td>
            <td class="value"><?= $V($opcacheinfo['preload']['memory_consumption']) ?></td>
        </tr>
        <tr>
            <td class="title"><?= $V('scripts') ?></td>
            <td class="value"><?= $V($opcacheinfo['preload']['scripts']) ?></td>
        </tr>
        <tr>
            <td class="title"><?= $V('functions') ?></td>
            <td class="value"><?= $V($opcacheinfo['preload']['functions']) ?></td>
        </tr>
        <tr>
            <td class="title"><?= $V('classes') ?></td>
            <td class="value"><?= $V($opcacheinfo['preload']['classes']) ?></td>
        </tr>
        </tbody>
    </table>

    <h2>Jit</h2>
    <table>
        <thead>
        <tr>
            <th class="header">Name</th>
            <th class="header">Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($opcacheinfo['jit'] as $key => $value): ?>
            <tr>
                <td class="title"><?= $V($key) ?></td>
                <td class="value"><?= $V($value) ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <h2>Status</h2>
    <table>
        <thead>
        <tr>
            <th class="header">Name</th>
            <th class="header">Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($opcacheinfo['status'] as $key => $value): ?>
            <tr>
                <td class="title"><?= $V($key) ?></td>
                <td class="value"><?= $V($value) ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <h2>Memory</h2>
    <table>
        <thead>
        <tr>
            <th class="header">Name</th>
            <th class="header">Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($opcacheinfo['memory'] as $key => $value): ?>
            <tr>
                <td class="title"><?= $V($key) ?></td>
                <td class="value"><?= $V($value) ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <h2>Interned strings</h2>
    <table>
        <thead>
        <tr>
            <th class="header">Name</th>
            <th class="header">Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($opcacheinfo['strings'] as $key => $value): ?>
            <tr>
                <td class="title"><?= $V($key) ?></td>
                <td class="value"><?= $V($value) ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <h2>Statistics</h2>
    <table>
        <thead>
        <tr>
            <th class="header">Name</th>
            <th class="header">Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($opcacheinfo['statistics'] as $key => $value): ?>
            <tr>
                <td class="title"><?= $V($key) ?></td>
                <td class="value"><?= match ($key) {
                        'start_time', 'last_restart_time' => $V($value, 'datetime'),
                        default                           => $V($value),
                    } ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <h2>Scripts</h2>
    <table>
        <thead>
        <tr>
            <th class="header">File<span class="sorter"><a data-sort-order="asc">︿</a><a data-sort-order="desc">﹀</a></span></th>
            <th class="header">Hits<span class="sorter"><a data-sort-order="asc">︿</a><a data-sort-order="desc">﹀</a></span></th>
            <th class="header">Memory<span class="sorter"><a data-sort-order="asc">︿</a><a data-sort-order="desc">﹀</a></span></th>
            <th class="header">Hits*Memory<span class="sorter"><a data-sort-order="asc">︿</a><a data-sort-order="desc">﹀</a></span></th>
            <th class="header">Last used<span class="sorter"><a data-sort-order="asc">︿</a><a data-sort-order="desc">﹀</a></span></th>
            <th class="header">Last modified<span class="sorter"><a data-sort-order="asc">︿</a><a data-sort-order="desc">﹀</a></span></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($opcacheinfo['scripts'] as $key => $value): ?>
            <tr>
                <td class="title" data-sort-value="<?= $V($key, 'json') ?>"><?= $V($key) ?></td>
                <td class="value number" data-sort-value="<?= $V($value['hits'], 'json') ?>"><?= $V($value['hits']) ?></td>
                <td class="value number" data-sort-value="<?= $V($value['memory_consumption'], 'json') ?>"><?= $V($value['memory_consumption']) ?></td>
                <td class="value number" data-sort-value="<?= $V($value['hits'] * $value['memory_consumption'], 'json') ?>"><?= $V($value['hits'] * $value['memory_consumption']) ?></td>
                <td class="value datetime" data-sort-value="<?= $V($value['last_used_timestamp'], 'json') ?>"><?= $V($value['last_used_timestamp'], 'datetime') ?></td>
                <td class="value datetime" data-sort-value="<?= $V($value['timestamp'], 'json') ?>"><?= $V($value['timestamp'], 'datetime') ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <?php
}
