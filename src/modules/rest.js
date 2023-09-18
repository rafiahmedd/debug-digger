const request =  function (method, route, data = {}) {
    const url = `${window.debugDiggerAdmin.rest.url}/${route}`;

    const headers = {'X-WP-Nonce': window.debugDiggerAdmin.rest.nonce};

    if (['GET', 'PUT', 'PATCH', 'DELETE'].indexOf(method.toUpperCase()) !== -1) {
        headers['X-HTTP-Method-Override'] = method;
        method = 'POST';
    }

    return window.jQuery.ajax({
        url: url,
        type: method,
        data: data,
        headers: headers
    });
}
// Composable function to access the REST API. This function can be used in any component.
// Right now, it only has the get and put methods base on the app requirement. You can add more methods as needed.
export function useRestApi() {
    function get(route, data) {
        return request('GET', route, data)
    }

    function post(route, data) {
        return request('POST', route, data);
    }

    function put(route, data) {
        return request('PUT', route, data);
    }

    return {
        get, post, put
    }
}


jQuery(document).ajaxSuccess((event, xhr, settings) => {
    const nonce = xhr.getResponseHeader('X-WP-Nonce');
    if (nonce) {
        window.debugDiggerAdmin.rest.nonce = nonce;
    }
});