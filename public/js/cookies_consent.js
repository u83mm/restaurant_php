"use strict";

document.addEventListener('DOMContentLoaded', function() {
  const bannerModal = document.getElementById('cookies_config_consent');
  const banner = document.getElementById('cookies_consent_banner');
  const modal = document.getElementById('cookies_config_modal');
  const acceptButton = document.getElementById('accept_cookies');
  const rejectButton = document.getElementById('reject_cookies');
  const configureButton = document.getElementById('configure_cookies');
  const saveConfigButton = document.getElementById('save_config');
  const cancelConfigButton = document.getElementById('cancel_config');
  const analyticsCookies = document.getElementById('analytics_cookies');
  const necessaryCookies = document.getElementById('necessary_cookies');
  const marketingCookies = document.getElementById('marketing_cookies');
  const stickyNav = document.getElementsByClassName('sticky-top')[0];
  const policyLink = document.getElementById('cookies_policy');
  const policyModal = document.getElementById('cookies_policy_modal');
  const configurePolicyButton = document.getElementById('configure_cookies_policy');
  const acceptPolicyButton = document.getElementById('accept_cookies_policy');

  /** Set a cookie with a specified name, value, and expiration time */
  function setCookie(cname, cvalue, days) {
    let expires = "";

    if (days) {
      const date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = cname + "=" + (cvalue || "")  + expires + "; path=/";
  }

  /** The function `getCookie` retrieves the value of a cookie by its name from the document's cookies.*/
  function getCookie(cname) {
    const nameEQ = cname + "=";
    const ca = document.cookie.split(';');

    for(let i=0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) === ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }

    return null;
  }

  function hideBanner() {
    bannerModal.style.display = 'none';
    banner.style.display = 'none';
  }

  function showBanner() {
    if(stickyNav) stickyNav.classList.remove('sticky-top');
    banner.style.display = 'block';
    bannerModal.style.display = 'block';
  }

  function hideConfigModal() {
    modal.style.display = 'none';
  }

  function showConfigModal() {
    if(stickyNav) stickyNav.classList.remove('sticky-top');
    modal.style.display = 'flex';
  }

  function showPolicyModal() {
    if(stickyNav) stickyNav.classList.remove('sticky-top');
    policyModal.style.display = 'flex';
  }

  function hidePolicyModal() {
    policyModal.style.display = 'none';
  }

  function checkCookieConsent() {
    if (getCookie('cookies_consent') !== 'accepted' && getCookie('cookies_consent') !== 'custom' && getCookie('cookies_consent') !== 'rejected') {      
      showBanner();
    }
  }

  acceptButton.addEventListener('click', function() {
    setCookie('cookies_consent', 'accepted', 365);
    hideBanner();   
  });

  rejectButton.addEventListener('click', function() {
    setCookie('cookies_consent', 'rejected', 365);
    hideBanner();
  });

  configureButton.addEventListener('click', function() {
    hideBanner();
    showConfigModal();
  });

  saveConfigButton.addEventListener('click', function() {
    const necessaryConsent = necessaryCookies.checked ? 'accepted' : 'rejected';
    const analyticsConsent = analyticsCookies.checked ? 'accepted' : 'rejected';
    const marketingConsent = marketingCookies.checked ? 'accepted' : 'rejected';

    setCookie('necessary_consent', necessaryConsent, 365);
    setCookie('analytics_consent', analyticsConsent, 365);
    setCookie('marketing_consent', marketingConsent, 365);
    setCookie('cookies_consent', 'custom', 365);

    hideConfigModal();    
  });

  cancelConfigButton.addEventListener('click', function() {
    if(stickyNav) stickyNav.classList.add('sticky-top');
    hideConfigModal();   
    showBanner(); 
  });

  policyLink.addEventListener('click', function() {
    hideBanner();
    showPolicyModal();
  });

  configurePolicyButton.addEventListener('click', function() {
    hidePolicyModal();
    showConfigModal();
  });

  acceptPolicyButton.addEventListener('click', function() {
    setCookie('cookies_consent', 'accepted', 365);
    hidePolicyModal();
  });

  checkCookieConsent();  
});
