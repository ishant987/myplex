function addParamToURL(key, value, urlQueryString) {
    newParam = key + '=' + value,
        params = '?' + newParam;
    newParam = key + '=' + value,
        params = '?' + newParam;
    if (urlQueryString) {
        keyRegex = new RegExp('([\?&])' + key + '[^&]*');


        if (urlQueryString.match(keyRegex) !== null) {
            params = urlQueryString.replace(keyRegex, "$1" + newParam);
        } else {
            params = urlQueryString + '&' + newParam;
        }
    }
    return params;
}

$('ul.pagination li a.page-link').click(function (event) {
    event.preventDefault();
    var loc = window.location;
    var href = $(this).attr('href');
    var url = new URL(href);
    key = 'page';
    value = url.searchParams.get("page");
    perams = addParamToURL(key, value, loc.search);
    window.location = loc.protocol + '//' + loc.hostname + loc.port + loc.pathname + params;
});

$('#m_search_form').on('submit', function (e) {
    e.preventDefault();
    var loc = window.location;
    var urlQueryString = loc.search;
    var key = 'ms';
    var value = $('#m_search_text').val();
    params = addParamToURL(key, value, urlQueryString);
    window.location = loc.protocol + '//' + loc.hostname + loc.port + loc.pathname + params;
});

jQuery(".postsReply").hide();

function toggleAnswer(id) {
    jQuery(".postsReply#postsReply" + id).slideToggle("slow");
}