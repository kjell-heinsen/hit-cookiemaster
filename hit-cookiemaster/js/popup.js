
// JavaScript zum Anzeigen/Verstecken der Erklärungen zu den Kategorien
document.addEventListener('DOMContentLoaded', function() {
    var categoryTitles = document.querySelectorAll('.category h6');

    for (var i = 0; i < categoryTitles.length; i++) {
        categoryTitles[i].addEventListener('click', function() {
            var categoryContent = this.nextElementSibling;

            if (categoryContent.style.display === 'none') {
                categoryContent.style.display = 'block';
            } else {
                categoryContent.style.display = 'none';
            }
        });
    }
});



document.addEventListener('DOMContentLoaded', function() {
    var btnSave = document.querySelector('.btn-save');
    var marketingCookiesCheckbox = document.getElementById('marketing-cookies');
    var trackingCookiesCheckbox = document.getElementById('tracking-cookies');

    btnSave.addEventListener('click', function() {
        var marketingCookiesAllowed = marketingCookiesCheckbox.checked;
        var trackingCookiesAllowed = trackingCookiesCheckbox.checked;

        // Speichere die Zustimmung des Benutzers in einem Cookie oder einer Datenbank

        if (!marketingCookiesAllowed) {
            blockMarketingCookies();
        }

        if (!trackingCookiesAllowed) {
            blockTrackingCookies();
        }

        // Schließe das DSGVO-Popup
        closeDsgvoPopup();
    });

    function blockMarketingCookies() {
        // Blockiere Marketing-Cookies, indem du ihre Namen in einem Cookie-Blocker-Plugin oder direkt im JavaScript-Code deiner Webseite hinzufügst
        // Beispiel: document.cookie = 'marketing_cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    }

    function blockTrackingCookies() {
        // Blockiere Tracking-Cookies, indem du ihre Namen in einem Cookie-Blocker-Plugin oder direkt im JavaScript-Code deiner Webseite hinzufügst
        // Beispiel: document.cookie = 'tracking_cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    }

    function closeDsgvoPopup() {
        var popupOverlay = document.querySelector('.popup-overlay');
        var popupContainer = document.querySelector('.popup-container');

        popupOverlay.style.display = 'none';
        popupContainer.style.display = 'none';
    }
});


const collapsibleHeaders = document.querySelectorAll('.collapsible-header');

collapsibleHeaders.forEach(header => {
    header.addEventListener('click', () => {
        const content = header.nextElementSibling;
        content.style.display = content.style.display === 'none' ? 'block' : 'none';
    });
});