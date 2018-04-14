/* jquery extends */

// escape selector
$.escape = function (selector) {
    return selector.replace(/[ !"#$%&'()*+,.\/:;<=>?@\[\\\]^`{|}~]/g, '\\$&');
};
// open main content by fqsen
$.open = function (fqsen) {
    if (!fqsen) {
        return;
    }
    var menuFrame = window.parent.document.getElementsByName('menu')[0];
    var parts = fqsen.split('::');
    // 遅延ロードしてるので dom として存在しないことがある
    if (parts.length > 1) {
        var node = $('#' + $.escape(parts[0]), menuFrame.contentWindow.document);
        node.closest('.holding-wrapper').find('.class-member').uncomment();
    }
    // 開いてフォーカスして遷移
    var node = $('#' + $.escape(fqsen), menuFrame.contentWindow.document);
    node.parents('.holding-wrapper').collapse(true, false);
    node.focus();
    node[0].click();
};
// replace first comment node
$.fn.uncomment = function () {
    return this.not('.uncommented').each(function () {
        this.innerHTML = this.firstChild.nodeValue;
        this.classList.add('uncommented');
    });
};
// open/close holding
$.fn.collapse = function (mode, animation) {
    var $this = $(this);
    var holding = $this.find('.holding:eq(0)');
    var switcher = $this.find('.switch-holding:eq(0)');
    if (mode === null) {
        mode = !switcher.hasClass('glyphicon-minus');
    }
    if (animation) {
        var slideToggle = mode ? 'slideDown' : 'slideUp';
        holding[slideToggle](133);
    }
    else {
        holding.toggle(mode);
    }
    switcher.toggleClass('glyphicon-minus', mode);
};

/* initialize */

hljs.initHighlightingOnLoad();

if (window.name === 'main') {
    $.open(window.location.hash.substring(1));
    $(window).on('hashchange', function () {
        window.parent.history.replaceState('', '', '#' + window.location.hash.substring(1));
    });
    $(function () {
        $(window).trigger('hashchange');
    });
}

/* dom events */

var $document = $(document);

// load class member
$document.on('click', '.holding-class', function () {
    $(this).find('.class-member').uncomment();
});
// holding
$document.on('click', '.switch-holding', function () {
    $(this).closest('.holding-wrapper').collapse(null, true);
});
$document.on('click', 'a[target=main]', function () {
    $(this).closest('.holding-wrapper').collapse(true, false);
});

/* content ready */

$(function () {
    // typeahead
    var $search = $('#search');
    $search.typeahead({
        source: $search.data('source'),
        items: 16,
        minLength: 0,
        showHintOnFocus: true,
        updater: function (item) {
            $.open(item);
            return item;
        },
        matcher: function (item) {
            var it = this.displayText(item).toLowerCase();
            return this.query.toLowerCase().split(' ').filter(Boolean).every(function (v) {
                return ~it.indexOf(v);
            });
        },
        highlighter: function (item) {
            var htmlchars = {'<': '&lt;', '>': '&gt;', '&': '&amp;', '"': '&quot;', "'": '&#39;', '`': '&#x60;'};
            var it = item.replace(/[<>&"'`]/g, function (m) { return htmlchars[match]; });
            this.query.toLowerCase().split(' ').filter(Boolean).map(function (v) {
                it = it.replace(new RegExp(v, 'gi'), '<strong class="matched">$&</strong>');
            });
            return it;
        },
    });
    // title attribute
    $('.ellipsis').each(function () {
        var $this = $(this);
        var content = $this.find('.ellipsis-text');
        $this.attr('title', content.length ? content.text() : $this.text());
    });
    // link tag
    $('tag-link').each(function () {
        var $this = $(this);
        var $a = $('<a/>');
        if ($this.data('kind') === 'uri') {
            $a.attr('href', $this.data('type'));
            $a.attr('target', '_blank');
        }
        else {
            var fqsen = $this.data('type-fqsen');
            $a.attr('href', fqsen.split('::')[0].split('\\').join('-') + '$typespace.html#' + fqsen);
        }
        $a.text($this.data('description') || $a.attr('href'));
        $this.before($a);
    });
});
