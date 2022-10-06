export default {
    methods: {
        addParamToURL(key, value) {
            let loc = window.location
            let urlQueryString = loc.search
            let newParam = key + '=' + value,
                params = '?' + newParam;
            if (urlQueryString) {
                let keyRegex = new RegExp('([\?&])' + key + '[^&]*');
                if (urlQueryString.match(keyRegex) !== null) {
                    params = urlQueryString.replace(keyRegex, "$1" + newParam);
                } else {
                    params = urlQueryString + '&' + newParam;
                }
            }
            let newURL = loc.protocol + '//' + loc.hostname + loc.port + loc.pathname + params
            window.history.pushState({ path: newURL }, '', newURL);
        },
        removeURLParameter(key) {

            let loc = window.location
            let urlQueryString = loc.search
            var urlparts = urlQueryString.split('?');
            let params = ''
            if (urlparts.length >= 2) {

                var prefix = encodeURIComponent(key) + '=';
                var pars = urlparts[1].split(/[&;]/g);


                for (var i = pars.length; i-- > 0;) {

                    if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                        pars.splice(i, 1);
                    }
                }

                params = urlparts[0] + '?' + pars.join('&');
                params = (params == '?') ? '' : params

            }
            let newURL = loc.protocol + '//' + loc.hostname + loc.port + loc.pathname + params
            window.history.pushState({ path: newURL }, '', newURL);
        },
        getURLParams(key) {
            let uri = window.location.search.substring(1);
            let params = new URLSearchParams(uri);
            return params.get(key)
        },
        isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        },
        
    }
}