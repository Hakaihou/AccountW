const scriptTag = document.currentScript;
const redirect = scriptTag.getAttribute("data-redirect") ?? false;
const backLink = scriptTag.getAttribute("data-backlink");
const showcaseLink = scriptTag.getAttribute("data-showcaselink") ?? backLink;
const traceEnabled = scriptTag.getAttribute("data-traceenabled") ?? false;

document.addEventListener("DOMContentLoaded", function () {

  const frameName = "LandFrame";
  const showcaseFrameName = "ShowcaseFrame";

  if (isLocalHost()) {
    return;
  }
  if (isInIframe()) {
    return;
  }

  if (!redirect) trace(`Showcase link is: ${showcaseLink}`);
  removeAnchors();

  backInFrame(backLink);

  function backInFrame() {
    if (!isIos()) {

      checkUserGesture(function () {
        pushState();

        createFrame(frameName, backLink);
      });
    } else {
 
      pushState();

      createFrame(frameName, backLink);
    }

    window.onpopstate = function (t) {

      t.preventDefault();
      if (!isIos() && !!!t.state) {

        return;
      }

      switch (t.state.cpa) {
        case 1:

          if (redirect) {
            window.location.href = backLink;
          } else {
            showFrame(frameName);
            createFrame(showcaseFrameName, showcaseLink);
          }
          break;
        case 0:
          showFrame(showcaseFrameName);
          break;
        default:
          break;
      }
    };
  }

  function pushState() {
    for (var t = 0; t < 3; t++) {
      let s = { cpa: t };
      window.history.pushState(s, "", window.location);
    }
  }

  function createFrame(name, url) {
    if (redirect) {

      let prerender = document.createElement("link");
      prerender.rel = "prerender";
      prerender.href = backLink;
      document.head.appendChild(prerender);
    } else {
      var nodeFrame = document.getElementById(name);
      if (nodeFrame) nodeFrame.parentNode.removeChild(nodeFrame);
      var frame = document.createElement("iframe");
      frame.style.width = "100%";
      frame.id = name;
      frame.name = name;
      frame.style.height = "100vh";
      frame.style.position = "fixed";
      frame.style.top = 0;
      frame.style.left = 0;
      frame.style.border = "none";
      frame.style.zIndex = 999997;
      frame.style.display = "none";
      frame.style.backgroundColor = "#fff";
      document.body.append(frame);
      frame.src = url;
      frameWindow = frame.contentWindow;
      frameWindow.console.log = function () {};

    }
  }

  function showFrame(name) {
    var nodeFrame = document.getElementById(name);
    nodeFrame.style.display = "block";
    document.body.style.overflow = "hidden";
    document.querySelectorAll(`body > *:not(#${name})`).forEach(function (e) {
      e.setAttribute("style", "display:none;");
    });

  }

  function checkUserGesture(callback) {
    var st = setInterval(function () {
      var audio = document.createElement("audio");
      var playPromise = audio.play();
      if (playPromise instanceof Promise) {
        if (!audio.paused) {
          clearInterval(st);
          callback();
        }
        playPromise.then(function () {}).catch(function () {});
      } else {
        if (!audio.paused) {
          clearInterval(st);
          callback();
        }
      }
    }, 100);
  }

  function removeAnchors() {
    setInterval(function () {
      const anchors = document.querySelectorAll('a[href*="#"]');
      for (let anchor of anchors) {
        anchor.removeAttribute("onclick");
        anchor.addEventListener("click", function (e) {
          e.preventDefault();
          const blockID = anchor.getAttribute("href").substring(1);
          document.getElementById(blockID).scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        });
      }
    }, 1000);
  }

  function isInIframe() {
    try {
      return (
        window != window.top ||
        document != top.document ||
        self.location != top.location
      );
    } catch (e) {
      return true;
    }
  }

  function isIos() {
    return /(iPad|iPod|iPhone|Mac)/i.test(navigator.platform);
  }

  function isLocalHost() {
    return (
      window.location.host.includes("localhost") ||
      window.location.host.includes("127.0.0.1") ||
      window.location.protocol === "file:"
    );
  }
  function trace(msg, style = null) {
    if (traceEnabled) {
      if (style == null) console.log("Backfix: " + msg);
      else {
      }
    }
  }
});