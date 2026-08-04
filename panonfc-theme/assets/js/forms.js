/**
 * PANONFC — refresh form security tokens on cached pages.
 *
 * A heavily-cached page bakes a stale nonce and time token into the HTML,
 * which makes submissions fail ("La session a expiré") or get silently
 * dropped. This fetches a fresh nonce + time token from a no-cache REST
 * endpoint and injects them into the form on load, so the form works even
 * when the page itself is served from full-page cache (WP Rocket / Cloudflare).
 */
(function () {
  'use strict';

  var cfg = window.PANONFC_FORMS || {};
  if (!cfg.tokenUrl) return;

  document.addEventListener('DOMContentLoaded', function () {
    var forms = document.querySelectorAll('.panonfc-form');
    if (!forms.length) return;

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
