document.addEventListener('DOMContentLoaded', function () {
    const $ = document.$.bind(document);
    const $$ = document.$$.bind(document);
    const html = $('html');
    const body = $('body');
    const scroller = $('.wy-side-scroll');
    const outline = $('.markdown-toc');
    const article = $('.markdown-body>article');
    const sentinel = $('.sentinel');
    const controlPanel = $('.control-panel');

    mermaid.initialize({
        startOnLoad: false,
        theme: 'neutral',
    });

    let vizPromise;

    function renderDot(src) {
        if (typeof vizPromise === "undefined") {
            vizPromise = Viz.instance();
        }

        return vizPromise.then(viz => viz.renderSVGElement(src));
    }

    // ハイライト
    let svg_id = 0;
    const highlight = function (element) {
        if (element.classList.contains('complete-highlight')) {
            return;
        }
        element.classList.add('complete-highlight');
        if (element.classList.contains('mermaid')) {
            mermaid.render(`mermaid_svg-${++svg_id}`, element.textContent, (svgCode, bindFunctions) => {
                element.innerHTML = svgCode;
                if (bindFunctions) {
                    bindFunctions(element);
                }
            }, element);
        }
        else if (element.classList.contains('dot')) {
            renderDot(element.textContent)
                .then(function (svg) {
                    element.innerHTML = '';
                    element.appendChild(svg);
                })
                .catch(error => console.error(error))
            ;
        }
        else {
            hljs.highlightBlock(element);
            const lines = element.innerHTML.split('\n');
            if (lines.length > 1) {
                element.classList.add('row-numbers', `digit${lines.length.toString().length}`);
                element.innerHTML = lines.map(line => `<span class="row-number"></span>${line}`).join('\n');
            }
        }
    };

    /// 印刷前の処理
    const readyprint = function () {
        // Intersection で highlight.js してるので、されていないものが居る
        article.$$('pre>div').forEach(highlight);

        // details を開かないと印刷されない
        article.$$('details').open = true;
    };
    window.$on('beforeprint', readyprint);

    /// エクスポート
    document.$on('click', '#button-export', async function (e) {
        readyprint();

        const root = html.cloneNode(true);

        root.dataset.exported = 'true';
        root.$$('header,footer').remove();
        root.$$('[data-section-count]').$data.sectionCount = 0;

        const promises = [];
        promises.push(root.$$('img[src]').$asyncMap(async function (e) {
            e.replaceWith(document.$createElement('img', {src: await (await e.$contents()).$dataURL()}));
        }));
        promises.push(root.$$('link[href]').$asyncMap(async function (e) {
            e.replaceWith(document.$createElement('style', {id: e.id}, await e.$contents()));
        }));
        promises.push(root.$$('script[src]').$asyncMap(async function (e) {
            e.replaceWith(document.$createElement('script', {}, await e.$contents()));
        }));
        await Promise.all(promises);

        new Blob([root.outerHTML]).$download(html.$('title').innerText + '.html');
    });

    /// トグルイベント
    document.$on('click', '[data-toggle-class]', function (e) {
        const target = e.target;
        const targets = target.dataset.toggleTarget ? $$(e.target.dataset.toggleTarget) : [target];
        targets.$class.toggle(target.dataset.toggleClass);
    });

    /// コンパネ
    const SAVENAME = 'ht-setting2';
    const alldata = html.matches('[data-exported]') ? {} : JSON.parse(localStorage.getItem(SAVENAME) ?? '{}');
    const directory = null ?? location.pathname.split('/').slice(0, -1).join('/');
    controlPanel.$on('input', function (e) {
        if (!e.target.validity.valid) {
            return;
        }
        if (!e.target.matches('.savedata')) {
            return;
        }
        const font_size = $('#fontSize');
        $(`[for=${font_size.id}]`).textContent = font_size.$value + 'px';
    });
    controlPanel.$on('change', function (e) {
        if (!e.target.validity.valid) {
            return;
        }
        if (!e.target.matches('.savedata')) {
            return;
        }
        controlPanel.sync();
        controlPanel.save();
    });
    controlPanel.sync = function () {
        this.$$('.savedata').forEach(function (input) {
            html.dataset[input.id] = input.$value ?? '';
        });
        $('.wy-nav-side').style.width = ''; // reset dragging
        const font_size = $('#fontSize');
        $(`[for=${font_size.id}]`).textContent = font_size.$value + 'px';
        const highlight_style = $('#highlight_style');
        highlight_style.href = highlight_style.dataset.cdnUrl + $('#highlightCss').$value + '.min.css';
        html.$style({
            '--side-width': `min(${$('#tocWidth').$value}px, ${$('#tocVisible').checked ? 9999 : 0}px)`,
            '--font-family': $('#fontFamily').$value,
            '--font-size': font_size.$value,
            '--section-indent': $('#sectionIndent').$value,
        });
    };
    controlPanel.save = function () {
        const savedata = {};
        this.$$('.savedata').forEach(function (input) {
            savedata[input.id] = input.$value ?? '';
        });
        alldata[directory] = savedata;
        localStorage.setItem(SAVENAME, JSON.stringify(alldata));
    };
    controlPanel.load = function () {
        const dir = Object.keys(alldata).sort((a, b) => b.length - a.length).find(dir => directory.indexOf(dir) === 0);
        const savedata = alldata[dir] ?? Object.assign({}, html.dataset);
        this.$$('.savedata').forEach(function (input) {
            input.$value = savedata[input.id] ?? input.dataset.defaultValue;
        });
        controlPanel.sync();
    };
    controlPanel.load();

    /// DOM ビルド
    if (!html.matches('[data-exported]')) {
        /// セクション由来のアウトラインの構築
        const levels = (new Array(6)).fill(0);
        const idmap = {};
        article.$$('.section').forEach(function (section) {
            const sectionId = `toc-${section.id}`;
            const sectionTitle = section.$('.section-header').textContent;
            const sectionContents = section.$('.section-header').$textNodes();
            const sectionLevel = +section.dataset.sectionLevel;

            levels[sectionLevel - 1]++;
            levels.fill(0, sectionLevel);

            const leading = levels.findIndex(v => v !== 0);
            const trailing = levels.findLastIndex(v => v !== 0);
            const currentLevels = levels.slice(leading, trailing + 1);
            const blockId = currentLevels.join('.');
            const parentId = currentLevels.slice(0, -1).join('.');
            section.firstChild.$prepend(document.$createElement('span', {data: {sectionNumber: blockId}}));

            idmap[blockId] = sectionId;
            const parent = document.getElementById(idmap[parentId]);
            if (parent) {
                parent.dataset.childCount = (+parent.dataset.childCount + 1) + '';
            }

            outline.$append(document.$createElement('a', {
                    id: sectionId,
                    href: `#${section.id}`,
                    title: sectionTitle,
                    class: ['toc-h', `toc-h${sectionLevel}`],
                    data: {
                        sectionCount: '0',
                        sectionLevel: sectionLevel,
                        blockId: blockId,
                        parentBlockId: parentId,
                        childCount: '0',
                        state: '',
                    },
                },
                document.$createElement('b', {class: 'toggler icon'}),
                document.$createElement('span', {
                    data: {
                        tocNumber: blockId,
                    },
                }),
                ...[...sectionContents].map(function (e) {
                    const span = document.createElement('span');
                    if (e.nodeName === '#text') {
                        span.textContent = e.nodeValue;
                    }
                    if (e.nodeName === '#comment') {
                        span.innerHTML = e.nodeValue;
                    }
                    return span;
                })
            ));
        });
    }

    /// コードブロックの highlight.js 監視
    article.$on('intersect', 'pre>div', function (e) {
        if (e.$original.entry.isIntersecting) {
            highlight(e.target);
        }
    }, {
        ownself: true,
        threshold: 0,
        rootMargin: '0px 0px 10% 0px',
    });

    /// アウトラインのハイライト監視
    article.$on('intersect', '.section', function (e) {
        let toch = document.getElementById(`toc-${e.target.id}`);
        if (html.dataset.tocActive === 'none') {
            while (toch.clientHeight <= 1) {
                toch = toch.previousElementSibling;
            }
        }
        toch.dataset.sectionCount = (Math.max(+toch.dataset.sectionCount + (e.$original.entry.isIntersecting ? +1 : -1), 0)) + '';
    }, {
        ownself: true,
        threshold: 0,
    });

    // アウトラインの自動開閉
    outline.$on('attribute', '[data-section-count]', function (e) {
        if (e.detail.subtype === 'data-section-count' && html.dataset.tocActive !== 'none') {
            const tochs = outline.$$('.toc-h');
            const actives = tochs.$filter(e => e.dataset.sectionCount > 0);
            const firstIndex = tochs.$index(actives[0]);
            const lastIndex = tochs.$index(actives.$at(-1));
            const min = firstIndex == null ? 0 : firstIndex - 3;
            const max = lastIndex == null ? tochs.length - 1 : lastIndex + 3;

            tochs.$class.remove('neighbor-visible', 'brother-visible');

            [...new Set([...actives].map(toch => toch.dataset.parentBlockId))].forEach(function (pid) {
                outline.$$(`[data-parent-block-id="${pid}"]`).$class.add('brother-visible');
            });

            tochs.forEach(function (toch, i) {
                if ((min <= i && i <= max)) {
                    toch.classList.add('neighbor-visible');
                    while (toch) {
                        toch = outline.$(`[data-block-id="${toch.dataset.parentBlockId}"]`);
                        toch?.classList?.add('neighbor-visible');
                    }
                }
            });
            tochs.forEach(function (toch, i) {
                toch.dataset.firstAbove = '0';
                toch.dataset.lastBelow = '0';
                if (i === min) {
                    const brother = outline.$$(`[data-parent-block-id="${toch.dataset.parentBlockId}"]`);
                    toch.dataset.firstAbove = '' + (brother.$slice(0, toch).$filter(node => node.$style.$visibility === 'hidden').length);
                }
                if (i === max) {
                    const brother = outline.$$(`[data-parent-block-id="${toch.dataset.parentBlockId}"]`);
                    toch.dataset.lastBelow = '' + (brother.$slice(toch).$filter(node => node.$style.$visibility === 'hidden').length);
                }
            });
        }
    }, {
        debounce: 16,
        subtree: false,
    });

    /// アウトラインの開閉ボタン
    outline.$on('mouseenter', 'a.toc-h', function (e) {
        const toch = e.target;
        if (toch.dataset.sectionLevel >= html.dataset.tocLevel) {
            if (+toch.dataset.childCount) {
                const tochs = outline.$$(`[data-parent-block-id="${toch.dataset.blockId}"]`);
                const visibles = tochs.$filter(e => e.$style.$visibility !== 'hidden');
                if (tochs.length === visibles.length) {
                    toch.dataset.state = 'close';
                }
                else {
                    toch.dataset.state = 'open';
                }
            }
        }
    }, {capture: true});
    outline.$on('mouseleave', 'a.toc-h', function (e) {
        e.target.dataset.state = '';
    }, {capture: true});
    outline.$on('click', 'b.toggler', function (e) {
        const toch = e.target.parentElement;
        if (toch.dataset.state === 'open') {
            toch.dataset.state = 'close';
            const blocks = outline.$$(`[data-parent-block-id="${toch.dataset.blockId}"]`);
            blocks.$class.add('forced-visible');
            blocks.$data.firstAbove = '0';
            blocks.$data.lastBelow = '0';
        }
        else {
            toch.dataset.state = 'open';
            const blocks = outline.$$(`[data-parent-block-id^="${toch.dataset.blockId}"]`);
            blocks.$class.remove('forced-visible');
        }
        e.preventDefault();
        return false;
    });

    /// アウトラインのクリックイベント
    outline.$on('click', 'a.toc-h', async function (e) {
        e.preventDefault();
        const anchor = e.$delegateTarget.closest('a.toc-h');
        const oldURL = location.href;
        const newURL = anchor.href;
        history.replaceState(null, '', newURL);
        window.dispatchEvent(new HashChangeEvent("hashchange", {
            oldURL: oldURL,
            newURL: newURL,
        }));

        $(anchor.getAttribute('href')).$scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });
    });

    // アウトラインのスクロールの自動追従
    document.$on('scroll', async function () {
        if (html.dataset.tocFollow === '1') {
            if ($('.wy-nav-side').clientWidth > 0) {
                const visibles = $$('.toc-h:not([data-section-count="0"])');
                visibles[Math.floor(visibles.length / 2)]?.$scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });
            }
        }
    }, {
        throttle: 32,
    });

    /// スクロールバーを自動的に隠す
    scroller.$on('scroll', function () {
        scroller.classList.add('scrolling');
    }, {
        throttle: 1000,
    });
    scroller.$on('scrollend', function () {
        scroller.classList.remove('scrolling');
    }, {
        debounce: 3000,
    });

    // アウトラインのドラッグリサイズ
    $('.wy-nav-side').$on('resize', function (e) {
        if (e.$original.entry.contentRect.width) {
            const tocWidth = $('#tocWidth');
            tocWidth.value = e.$original.entry.contentRect.width;
            tocWidth.dispatchEvent(new Event('change', {bubbles: true}));
        }
    }, {
        throttle: 50,
    });

    requestIdleCallback(function () {
        /// stop initial animation
        html.$style['--initial-animation-ms'] = '500ms';

        /// 記事末尾の空白を確保（ジャンプしたときに「え？どこ？」となるのを回避する）
        const lastSection = $('.section:last-child');
        if (lastSection) {
            const height = sentinel.offsetTop - lastSection.offsetTop + parseInt(lastSection.$style.$marginTop);
            sentinel.style.height = `calc(100vh - ${height}px)`;
        }
    });
});
