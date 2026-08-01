/**
 * PANONFC — front-end interactions.
 * Burger menu (< 1000px) and smooth in-page anchors.
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;
    var burger = document.querySelector('[data-burger]');
    var drawer = document.querySelector('[data-mobile-nav]');
    var closeBtn = document.querySelector('[data-mobile-close]');

    function openNav() {
      if (!drawer) return;
      drawer.classList.add('is-open');
      body.classList.add('mobile-nav-open');
      drawer.setAttribute('aria-hidden', 'false');
      if (burger) burger.setAttribute('aria-expanded', 'true');
      var firstLink = drawer.querySelector('a, button');
      if (firstLink) firstLink.focus();
    }

    function closeNav() {
      if (!drawer) return;
      drawer.classList.remove('is-open');
      body.classList.remove('mobile-nav-open');
      drawer.setAttribute('aria-hidden', 'true');
      if (burger) {
        burger.setAttribute('aria-expanded', 'false');
        burger.focus();
      }
    }

    if (burger) burger.addEventListener('click', openNav);
    if (closeBtn) closeBtn.addEventListener('click', closeNav);

    if (drawer) {
      drawer.addEventListener('click', function (e) {
        if (e.target.tagName === 'A') closeNav();
      });
    }

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer && drawer.classList.contains('is-open')) {
        closeNav();
      }
    });

    // Close the drawer if the viewport grows past the breakpoint.
    var mq = window.matchMedia('(min-width: 1000px)');
    var onChange = function () {
      if (mq.matches && drawer && drawer.classList.contains('is-open')) closeNav();
    };
    if (mq.addEventListener) {
      mq.addEventListener('change', onChange);
    } else if (mq.addListener) {
      mq.addListener(onChange);
    }
  });
})();
