/**
 * PANONFC — refresh form security tokens ONLY when the page was served from
 * an old full-page cache.
 *
 * The baked hidden fields (nonce + signed time token) are fine on a freshly
 * generated page. They only go stale when the HTML is served from cache
 * (WP Rocket / Cloudflare) for a long time — then the nonce can be expired and
 * the token old. To avoid adding a dynamic REST request on every page view
 * (which would pile up on a server short on PHP-FPM workers), we inspect the
 * baked time token: if it is recent, we do nothing; only if it is old do we
 * fetch a fresh nonce + token from the no-cache REST endpoint.
 */
(function () {
  'use strict';

  var cfg = window.PANONFC_FORMS || {};
  if (!cfg.tokenUrl) return;

  // Refresh only if the baked token is older than this (seconds).
  var STALE_AFTER = 10 * 60;

  document.addEventListener('DOMContentLoaded', function () {
    var forms = document.querySelectorAll('.panonfc-form');
    if (!forms.length) return;

    // Read the baked token age from the first form.
    var bakedInput = forms[0].querySelector('input[name="panonfc_t"]');
    var fresh = false;
    if (bakedInput && bakedInput.value.indexOf(':') !== -1) {
      var ts = parseInt(bakedInput.value.split(':')[0], 10);
      if (ts && (Math.floor(Date.now() / 1000) - ts) < STALE_AFTER) {
        fresh = true; // page is fresh — baked tokens are valid, do nothing.
      }
    }
    if (fresh) return;

    fetch(cfg.tokenUrl, { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(function (r) { return r.ok ? r.json() : null; })
      .then(function (data) {
        if (!data) return;
        forms.forEach(function (form) {
          var nonce = form.querySelector('input[name="panonfc_form_nonce"]');
          var token = form.querySelector('input[name="panonfc_t"]');
          if (nonce && data.nonce) nonce.value = data.nonce;
          if (token && data.t) token.value = data.t;
        });
      })
      .catch(function () { /* keep the baked tokens as fallback */ });
  });
})();
