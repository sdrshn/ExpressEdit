"use strict";

var testLink = 'https://websitesetup.org/go/shopify';
var testLink2 = '/express-written-permission/';
document.body.addEventListener('pointermove', function () {
  document.querySelectorAll('.lazy-shopify').forEach(item => {
    item.innerHTML = item.innerHTML.link(testLink);
    item.classList.remove('lazy-shopify');
  });
});
document.body.addEventListener('pointermove', function () {
  document.querySelectorAll('.lazy-test').forEach(item => {
    item.innerHTML = item.innerHTML.link(testLink2);
    item.classList.remove('lazy-test');
  });
});