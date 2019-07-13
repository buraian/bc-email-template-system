/**
 * Create selectable wrapper around unsubscribe text
 */
(function tweakUnsubscribe () {
    const el = document.querySelector('td[width="380"][height="30"][valign="middle"]')
    if (el) el.innerHTML = `<div id="unsubscribe">${el.innerHTML}</div>`
})();

/**
 * Create selectable wrapper around web version link
 */
(function tweakWebVersionLink () {
    const el = document.querySelector('td[width="110"][height="30"][valign="middle"] a')
    if (el) {
        el.style.color = ''
        el.id = "webVersionLink"
    }
})();
