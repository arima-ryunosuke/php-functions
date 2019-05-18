/* jquery extends */

// escape selector
$.escape = function (selector) {
    return selector.replace(/[ !"#$%&'()*+,.\/:;<=>?@\[\\\]^`{|}~]/g, '\\$&');
};
// open main content by fqsen
$.open = function (fqsen, noclick) {
    if (!fqsen) {
        return;
    }
    try {
        var menuFrame = window.parent.document.getElementsByName('menu')[0];
    } catch (e) {
        return;
    }
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
    if (!noclick) {
        node[0].click();
    }
};
// title attribute
$.fn.titleattr = function () {
    return this.each(function () {
        var $this = $(this);
        $this.attr('title', $this.find('.ellipsis-text').text());
    });
};
// replace first comment node
$.fn.uncomment = function () {
    return this.not('.uncommented').each(function () {
        this.innerHTML = this.firstChild.nodeValue;
        this.classList.add('uncommented');
        $(this).find('.ellipsis').titleattr();
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
    } else {
        holding.toggle(mode);
    }
    switcher.toggleClass('glyphicon-minus', mode);
};

/* initialize */

var $window = $(window);

hljs.initHighlightingOnLoad();

// frame switching
$('.frame-switch a:eq(0)').attr('href', '../' + window.location.hash);
$('.frame-switch a:eq(1)').attr('href', window.location.href);

if (window.name === 'main') {
    $.open(window.location.hash.substring(1));
    $window.on('hashchange', function () {
        $window.scrollTop($window.scrollTop() - $('h1:first').innerHeight() - 3);
        window.parent.history.replaceState('', '', '#' + window.location.hash.substring(1));
        window.history.replaceState('', '', '#'); // クリアして次の hashchange を促す
    });
    $(function () {
        $window.trigger('hashchange');
    });
}

/* dom events */

var $document = $(document);

// holding
$document.on('click', '.switch-holding', function () {
    $(this).closest('.holding-wrapper').collapse(null, true);
});
$document.on('click', 'a[target=main]', function () {
    $(this).closest('.holding-wrapper').collapse(true, true);
});
// attract focus
$document.on('focus', 'a[id], [tabindex]', function () {
    $('.focused').removeClass('focused');
    $(this).addClass('focused');
});
// reverse menu
$document.on('click', '.structure-title', function () {
    $.open(this.id, true);
    window.parent.history.replaceState('', '', '#' + this.id);
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
    // load class member
    $('.holding-class').on('click', function () {
        $(this).find('.class-member').uncomment();
    });
    // title attribute
    $('.ellipsis').titleattr();
    // description table
    $('table', '.description').addClass('table');
    // link tag
    $('tag_link').each(function () {
        var $this = $(this);
        var $a = $('<a/>');
        if ($this.data('kind') === 'uri') {
            $a.attr('href', $this.data('type'));
            $a.attr('target', '_blank');
        } else {
            var fqsen = $this.data('type-fqsen');
            var suffix = fqsen.slice(-1) === '\\' ? '$namespace' : '$typespace';
            $a.attr('href', fqsen.split('::')[0].split('\\').join('-') + suffix + '.html#' + fqsen);
        }
        $a.text($this.data('description'));
        $this.before($a).hide();
    });
    // source tag
    $('tag_source').each(function () {
        var $this = $(this);
        var $a = $('<a/>');
        var fqsen = $this.data('fqsen');
        var href = $this.closest('.structure-item').find('[data-fqsen="' + $.escape(fqsen) + '"]>.source-link').attr('href');
        $a.attr('href', href);
        $a.attr('target', '_blank');
        $a.text($this.data('description'));
        $this.before($a).hide();
    });
});
