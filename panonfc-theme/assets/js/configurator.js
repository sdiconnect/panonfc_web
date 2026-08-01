/**
 * PANONFC — product configurator.
 *
 * Progressive enhancement of the NATIVE WooCommerce variations form:
 *   - Turns each variation <select> into design pill buttons (auto-adapts to
 *     the product's real attributes: dimensions, technologie, œillets, …).
 *   - Reads the REAL variation price from WooCommerce's `found_variation`
 *     event (works with inline JSON and with AJAX matching for many variations).
 *   - Applies the degressive quantity tiers to build a live unit/total estimate.
 *   - Leaves the real qty input + add-to-cart button in charge of purchasing,
 *     so the exact price and discounts are computed by WooCommerce at cart.
 *
 * No hardcoded prices: every amount comes from the store's own variations.
 */
(function () {
  'use strict';

  if (typeof window.jQuery === 'undefined') return;

  jQuery(function ($) {
    var $form = $('.variations_form');
    if (!$form.length) return;

    var CFG = window.PANONFC_CFG || {};
    var TIERS = (CFG.tiers && CFG.tiers.length) ? CFG.tiers.slice() : [
      { min: 100, d: 0.4098, label: '−41 %' },
      { min: 50, d: 0.3607, label: '−36 %' },
      { min: 25, d: 0.3115, label: '−31 %' },
      { min: 10, d: 0.2213, label: '−22 %' },
      { min: 5, d: 0.1311, label: '−13 %' },
      { min: 1, d: 0, label: '' }
    ];
    // Sort tiers descending by min so the first match wins.
    TIERS.sort(function (a, b) { return b.min - a.min; });
    var I18N = CFG.i18n || {};

    var root = document.querySelector('[data-configurator]') || $form.get(0);

    // ---- 1. Build the pill fields container from the native selects -------
    var $fields = $('<div class="cfg-fields"></div>');

    $form.find('.variations select').each(function () {
      var $sel = $(this);
      var name = $sel.attr('name') || $sel.attr('data-attribute_name') || '';
      // Label: the matching <th>/<label> in the variations table.
      var labelTxt = '';
      var $row = $sel.closest('tr');
      if ($row.length) {
        labelTxt = $row.find('th label, .label label, th, .label').first().text();
      }
      labelTxt = $.trim(labelTxt) || $.trim($sel.attr('data-attribute_name') || name.replace(/^attribute_(pa_)?/, ''));

      var $field = $('<div class="cfg-field"></div>');
      $field.append($('<div class="cfg-field__label"></div>').text(labelTxt));
      var $opts = $('<div class="cfg-options" role="group"></div>');

      $sel.find('option').each(function () {
        var val = $(this).val();
        if (val === '') return; // skip the "Choisir une option" placeholder
        var $b = $('<button type="button" class="cfg-opt"></button>')
          .text($(this).text())
          .attr('data-value', val)
          .attr('aria-pressed', 'false');
        $b.on('click', function () {
          $sel.val(val).trigger('change');
        });
        $opts.append($b);
      });

      $field.append($opts);
      $field.data('select', $sel);
      $fields.append($field);

      // Reflect select state onto the pills.
      $sel.on('change', function () {
        $opts.find('.cfg-opt').each(function () {
          var active = $(this).attr('data-value') === $sel.val();
          $(this).toggleClass('is-active', active).attr('aria-pressed', active ? 'true' : 'false');
        });
      });
    });

    // Insert the pill fields at the top of the form, hide native select rows.
    $form.prepend($fields);
    $form.addClass('is-enhanced');

    // ---- 2. Quantity controls ---------------------------------------------
    // Reuse the native qty input as the source of truth.
    function $qtyInput() { return $form.find('.qty, input[name="quantity"]').first(); }
    function setQty(v) {
      var $q = $qtyInput();
      if (!$q.length) return;
      v = Math.max(1, parseInt(v, 10) || 1);
      $q.val(v).trigger('change');
      $form.find('[data-out="qty"]').text(v);
      render();
    }
    function getQty() {
      var $q = $qtyInput();
      var v = $q.length ? parseInt($q.val(), 10) : 1;
      return Math.max(1, v || 1);
    }

    // Wire the design stepper/shortcuts (rendered in the template) to the qty.
    $(root).on('click', '[data-qty]', function () {
      var action = $(this).attr('data-qty');
      if (action === 'inc') setQty(getQty() + 1);
      else if (action === 'dec') setQty(getQty() - 1);
      else setQty(action);
    });
    $form.on('change', '.qty', function () {
      $form.find('[data-out="qty"]').text(getQty());
      render();
    });

    // ---- 3. Price rendering from the real variation -----------------------
    var currentPrice = null; // real variation unit price (from WooCommerce)

    function tierFor(q) {
      for (var i = 0; i < TIERS.length; i++) {
        if (q >= TIERS[i].min) return TIERS[i];
      }
      return TIERS[TIERS.length - 1];
    }

    function eur(v) {
      var parts = (Math.round(v * 100) / 100).toFixed(2).split('.');
      var intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
      return intPart + ',' + parts[1] + ' ' + (CFG.currencySym || '€');
    }

    function out(key) { return document.querySelector('[data-out="' + key + '"]'); }

    function render() {
      var unitEl = out('unit'), totalEl = out('total'), discEl = out('discount');
      var qty = getQty();

      if (currentPrice === null) {
        if (unitEl) unitEl.textContent = '—';
        if (totalEl) totalEl.textContent = '—';
        if (discEl) discEl.textContent = '';
        return;
      }

      var t = tierFor(qty);
      var unit = currentPrice * (1 - t.d);
      if (unitEl) unitEl.textContent = eur(unit);
      if (totalEl) totalEl.textContent = eur(unit * qty);
      if (discEl) discEl.textContent = t.label ? (t.label + ' ' + (I18N.applied || 'appliqués')) : '';
    }

    // WooCommerce fires these on the variations form.
    $form.on('found_variation', function (event, variation) {
      // display_price respects the store's tax display settings.
      currentPrice = parseFloat(variation.display_price);
      if (isNaN(currentPrice)) currentPrice = null;
      render();
    });
    $form.on('reset_data', function () {
      currentPrice = null;
      render();
    });

    // Initial paint.
    $form.find('[data-out="qty"]').text(getQty());
    render();
  });
})();
