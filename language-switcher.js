document.addEventListener('DOMContentLoaded', (event) => {
    var selector = document.getElementById('language-selector');
    if (selector) {
        selector.addEventListener('change', function() {
            changeLanguage(this);
        });
    }
});

function changeLanguage(select) {
    var language = select.value;
    window.location.search = '?lang=' + language;
}

function changeLanguage(select) {
    console.log("Sprachwechsel erfolgt: " + select.value);
    // window.location.search = '?lang=' + select.value;
}