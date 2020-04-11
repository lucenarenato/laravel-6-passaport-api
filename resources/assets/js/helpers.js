const notyf = new Notyf();

/**
 * Check if the variable is empty
 *
 * @param {*} variable
 * @returns {boolean}
 */
function empty(variable) {
    if(typeof variable == "object")
        return !(Object.keys(variable).length) ? true : false;
    else
        return (variable == undefined || variable == null || variable.length <= 0) ? true : false;
}

/**
 * Returns the base URL with the current segment and, if passed, append another segment path.
 * To rewrite the current segment path, set the second parameter to true
 *
 * @param {string} [segment_path]
 * @param {boolean} [replace]
 * @returns {string}
 */
function url(segment_path, replace) {
    segment_path = empty(segment_path) ? '' : segment_path;
    replace = empty(replace) ? false : replace;

    var url = window.location.href,
        last_separator = n = url.lastIndexOf("/");

    if(replace || ++(last_separator) == url.length)
        url = url.substring(0,n);

    url += '/';
    url += segment_path;
    return url;
}

/**
 * Return the base URL with, if passed, the segment path
 *
 * @param {string} [segment_path]
 * @returns {string}
 */
function base_url(segment_path) {
    segment_path = empty(segment_path) ? '' : segment_path;
    var url  = document.location.origin;

    url += '/';
    url += segment_path;
    return url;
}

/**
 * Redirect the browser to the url passed
 *
 * @param {string} url
 * @returns {undefined}
 */
function redirect(url) {
    window.location.href = url;
}

function button(selector) {
    return {
        selector: selector,
        enabled: function() {
            $(this.selector).prop("disabled",false).removeClass('disabled');
        },
        disabled: function () {
            $(this.selector).prop("disabled",true).addClass('disabled');
        }
    }
}