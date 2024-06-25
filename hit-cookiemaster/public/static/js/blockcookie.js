// Blockiert das Setzen von Cookies
Object.defineProperty(document, 'cookie', {
    get: function() {
        return '';
    },
    set: function() {
        return false;
    }
});

// Löscht alle vorhandenen Cookies
document.cookie.split(';').forEach(function(cookie) {
    var eqPos = cookie.indexOf('=');
    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT';
});


