<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Successful registration!</title>
  <script src="./js/i18n.min.js"></script>
  <script>
    document.documentElement.setAttribute('lang', getCookie('currentLanguage'));
    loadTranslations(getCookie('currentLanguage'))

    async function loadTranslations(lang) {
      try {
        const response = await fetch('./translate/thanks.json');
        if (!response.ok) {
          throw new Error('Network error: ' + response.statusText);
        }
        const translations = await response.json();
        i18next.init({
          lng: lang,
          debug: false,
          resources: translations
        }, function(err, t) {
          if (err) {
            console.error('Initialisation error i18next:', err);
          } else {
            updateContent();
          }
        });
      } catch (error) {
        console.error('Translation loading error:', error);
      }
    }

    function updateContent() {
      document.title = i18next.t('title')
      const elements = document.querySelectorAll('[data-i18n]');

      elements.forEach(element => {
        const key = element.getAttribute('data-i18n');
        element.textContent = i18next.t(key);
      });
    }

    function changeLanguage(language) {
      i18next.changeLanguage(language, updateContent);
    }

    function getCookie(name) {
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();
        if (cookie.startsWith(name + '=')) {
          return cookie.substring(name.length + 1);
        }
      }
      return null;
    }
  </script>

  <style>
    html {
      line-height: 1.15;
      -webkit-text-size-adjust: 100%;
    }

    body {
      margin: 0;
    }

    h1 {
      font-size: 2em;
      margin: .67em 0
    }

    ::-webkit-file-upload-button {
      -webkit-appearance: button;
      font: inherit
    }

    .specials:after,
    .specials:before {
      content: "";
      position: absolute
    }

    *,
    :after,
    :before {
      -webkit-box-sizing: border-box;
      box-sizing: border-box
    }

    html {
      font-size: 625%
    }

    body {
      font-family: Montserrat, sans-serif;
      font-size: .18rem;
      font-weight: 400;
      line-height: 1.17;
      color: #333;
      background: #fff;
      min-height: 100vh
    }

    h1,
    h2,
    p {
      margin: 0
    }

    ul {
      list-style-type: none
    }

    ul {
      margin: 0;
      padding: 0
    }

    .mk-wrapper {
      background-color: #ffffff;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
      flex-direction: column;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: space-between;
      max-width: 100%;
      min-height: 100vh;
      margin: 0 auto;
      overflow: hidden
    }

    .content {
      width: 100%;
      margin: 0 auto;
      padding: 5px 16px;
    }

    .content__cards {
      margin: .48rem 0
    }

    .cards {
      max-width: 700px;
      margin: 20px auto 0 auto;
    }

    .title {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
      -ms-flex-flow: row nowrap;
      flex-flow: row nowrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: center;
      gap: 10px;
    }

    .title__main {
      font-size: .46rem;
      font-weight: 700;
      margin-bottom: .16rem
    }

    .title__subtitle {
      font-size: .24rem;
      font-weight: 500
    }

    .title__icon {
      width: .74rem;
      height: .57rem;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      margin-bottom: 15px;
    }

    .title__icon svg {
      display: block;
      width: 100%
    }

    .card {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
      -ms-flex-flow: row nowrap;
      flex-flow: row nowrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      border-radius: .08rem;
      margin-bottom: .16rem;
      padding: 20px 5px;
    }

    .card__icon {
      height: auto;
      -ms-flex-negative: 0;
      flex-shrink: 0
    }

    .card__icon svg {
      display: block;
      width: 100%
    }

    .card__text {
      font-weight: 500;
      padding-left: .16rem
    }

    .specials {
      padding: .12rem .64rem;
      background-color: #2194ff;
      border-radius: .08rem;
      position: relative;
      z-index: 1
    }

    .specials:after,
    .specials:before {
      top: calc(50% - .16rem);
      width: .28rem;
      height: .33rem;
      background: url("9a33a4b2d4d8766f11bb649a4ec98b9e561fb078.svg") 50% 50%/contain no-repeat
    }

    .specials:before {
      left: .24rem
    }

    .specials:after {
      right: .24rem
    }

    .specials__title {
      font-size: .24rem;
      font-weight: 700;
      text-align: center;
      color: #fff
    }

    @media (max-width:479px) {
      html {
        font-size: 21vw
      }
    }




    .header-section {
      position: relative;
      background-color: #0b214f;
      /* background-color: white; */
      color: white;
      text-align: center;
      padding: 100px 20px;
      width: 100%;
    }

    .header-section::after {
      content: '';
      display: block;
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 100%;
      height: 100px;
      background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxNDBweCIgdmlld0JveD0iMCAwIDM2MCAxNDAiIHZlcnNpb249IjEuMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTAgMjAuNzEzQzE0Mi4zNTYgNzYuMzU2IDI1MS45MjkgMC4xMjg2NyAzNjAgMS4wOTVWMTQwSDBWMjAuNzEzWiIgZmlsbD0iI2ZmZiIvPgo8L3N2Zz4=') no-repeat bottom center;


      background-size: cover;
    }



    .footer-section {
      position: relative;
      background-color: #0b214f;
      color: #2194ff;
      color: white;
      text-align: center;
      padding: 100px 20px;
      width: 100%;
      transform: rotate(180deg);
    }

    .footer-section::after {
      content: '';
      display: block;
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 100%;
      height: 100px;
      background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxNDBweCIgdmlld0JveD0iMCAwIDM2MCAxNDAiIHZlcnNpb249IjEuMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTAgMjAuNzEzQzE0Mi4zNTYgNzYuMzU2IDI1MS45MjkgMC4xMjg2NyAzNjAgMS4wOTVWMTQwSDBWMjAuNzEzWiIgZmlsbD0iI2ZmZiIvPgo8L3N2Zz4=') no-repeat bottom center;


      background-size: cover;
    }
  </style>

</head>

<body>
  <div class="mk-wrapper">
    <div class="header-section"></div>
    <div class="content">
      <div class="content__title title">
        <div class="title__text">
          <h1 class="title__main" data-i18n="thanksWait">Please wait...</h1>
          <h2 class="title__subtitle" data-i18n="successful">Registration was successful!</h2>
        </div>
        <div class="title__icon">
          <img src="./icons/1.svg" alt="" srcset="">
        </div>
      </div>
      <ul class="content__cards cards">
        <li class="card">
          <div class="card__icon">
            <img src="./icons/2.svg" alt="" srcset="">
          </div>
          <p class="card__text">
            <b data-i18n="first">Wait for the transfer to your personal account!</b><br>
            <span data-i18n="second">You will now be logged into your personal account, where you can start earning money.</span>
          </p>
        </li>
        <li class="card">
          <p class="card__text">
            <b data-i18n="third">Waiting for our call!</b><br>
            <span data-i18n="fourth">Once your registration has been accepted, you will receive a call from one of our managers with the algorithm.</span>

          </p>
          <div class="card__icon">

            <img src="./icons/3.svg" alt="" srcset="">
          </div>
        </li>

      </ul>
    </div>
    <div class="footer-section"></div>
  </div>


  <!-- Facebook Pixel Code -->

  <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var redirect = '<?php echo $_GET['autoLoginUrl']; ?>';
      setTimeout(function() {
        window.location = redirect
      }, 3000)
    })
  </script>
</body>

</html>