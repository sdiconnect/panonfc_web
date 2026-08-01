/**
 * PANONFC — product configurator (price estimator).
 *
 * Mirrors the design prototype's pricing model. It updates the unit price,
 * total and discount label instantly on every change.
 *
 * IMPORTANT: the coefficients below are DESIGN ASSUMPTIONS from the handoff.
 * Only the 40x60 base (24,40 €) and the quantity discount tiers are real
 * data from the current site. When wiring to real WooCommerce variations,
 * override window.PANONFC_CFG (see the data-config attribute) or read the
 * variation prices via the woocommerce_variation JSON.
 */
(function () {
  'use strict';

  var root = document.querySelector('[data-configurator]');
  if (!root) return;

  // Defaults (design assumptions). Can be overridden from PHP via data-config.
  var CFG = {
    base: { '4060': 24.40, '6080': 34.90, '80120': 50.90 },
    techDelta: { qr: -2.50, nfc: 0, both: 2.00 },
    duplexMultiplier: 1.35,
    eyelets: 1.50,
    tiers: [
      { min: 100, d: 0.4098, label: '−41 %' },
      { min: 50, d: 0.3607, label: '−36 %' },
      { min: 25, d: 0.3115, label: '−31 %' },
      { min: 10, d: 0.2213, label: '−22 %' },
      { min: 5, d: 0.1311, label: '−13 %' },
      { min: 1, d: 0, label: '' }
    ]
  };

  try {
    if (root.dataset.config) {
      CFG = Object.assign(CFG, JSON.parse(root.dataset.config));
    }
  } catch (e) { /* keep defaults */ }

  var state = { dim: '4060', tech: 'both', print: 'recto', eyelets: 'yes', qty: 10 };

  var labels = {
    dim: { '4060': '40 × 60 cm', '6080': '60 × 80 cm', '80120': '80 × 120 cm' },
    tech: { qr: 'QR code seul', nfc: 'NFC seul', both: 'QR code + NFC' },
    print: { recto: 'recto seul', duplex: 'recto-verso' },
    eyelets: { yes: 'avec 4 œillets', no: 'sans œillets' }
  };

  function tier(q) {
    for (var i = 0; i < CFG.tiers.length; i++) {
      if (q >= CFG.tiers[i].min) return CFG.tiers[i];
    }
    return CFG.tiers[CFG.tiers.length - 1];
  }

  // French formatting: narrow no-break thousands, comma decimals.
  function eur(v) {
    var parts = v.toFixed(2).split('.');
    var intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    return intPart + ',' + parts[1] + ' €';
  }

  function unitPrice() {
    var t = tier(state.qty);
    var u = (CFG.base[state.dim] + CFG.techDelta[state.tech]);
    if (state.print === 'duplex') u *= CFG.duplexMultiplier;
    if (state.eyelets === 'yes') u += CFG.eyelets;
    u *= (1 - t.d);
    return { unit: u, tier: t };
  }

  function q(sel) { return root.querySelector(sel); }

  function render() {
    var r = unitPrice();
    var t = r.tier;

    var unitEl = q('[data-out="unit"]');
    var totalEl = q('[data-out="total"]');
    var discEl = q('[data-out="discount"]');
    var qtyEl = q('[data-out="qty"]');
    var sumEl = q('[data-out="summary"]');

    if (unitEl) unitEl.textContent = eur(r.unit);
    if (totalEl) totalEl.textContent = eur(r.unit * state.qty);
    if (discEl) discEl.textContent = t.label ? t.label + ' appliqués' : '';
    if (qtyEl) qtyEl.textContent = state.qty;
    if (sumEl) {
      sumEl.textContent = labels.dim[state.dim] + ' · ' + labels.tech[state.tech] + ' · ' +
        labels.print[state.print] + ' · ' + labels.eyelets[state.eyelets] +
        ' · identifiant unique et design inclus.';
    }

    // Reflect active options.
    root.querySelectorAll('[data-opt]').forEach(function (btn) {
      var group = btn.getAttribute('data-group');
      var val = btn.getAttribute('data-opt');
      btn.classList.toggle('is-active', state[group] === val);
      btn.setAttribute('aria-pressed', state[group] === val ? 'true' : 'false');
    });

    // Expose current selection for any WooCommerce add-to-cart wiring.
    root.dispatchEvent(new CustomEvent('panonfc:change', { detail: Object.assign({}, state, { unit: r.unit }) }));
  }

  root.addEventListener('click', function (e) {
    var opt = e.target.closest('[data-opt]');
    if (opt) {
      state[opt.getAttribute('data-group')] = opt.getAttribute('data-opt');
      render();
      return;
    }
    var qty = e.target.closest('[data-qty]');
    if (qty) {
      var action = qty.getAttribute('data-qty');
      if (action === 'inc') state.qty += 1;
      else if (action === 'dec') state.qty = Math.max(1, state.qty - 1);
      else state.qty = parseInt(action, 10) || 1;
      render();
    }
  });

  render();
})();
