function updateButtons(page) {
  document.getElementById("prev").setAttribute("style", "visibility: " + ((page != 1) ? "visible" : "hidden"));
  document.getElementById("next").setAttribute("style", "visibility: " + ((document.getElementById("notLast")) ? "visible" : "hidden"));
}

function updateURL(page) {
  var url = window.url.origin + window.url.pathname + "?q=" + window.url.searchParams.get("q") + "&p=" + page;
  history.pushState(null, document.title, url);
  window.url = new URL(window.location);
}

function getPage(page, rewriteURL=true) {
  var req = new XMLHttpRequest();
  req.onreadystatechange = function() {
    if (this.readyState == XMLHttpRequest.DONE) {
      if (this.status == 200) {
        document.getElementById("results").innerHTML = this.responseText;
        if (rewriteURL) updateURL(page);
        updateButtons(page);
      }
      else {
        document.getElementById("results").innerHTML = "An error has occurred.";
      }
    }
  };
  req.open("POST", "update", true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  req.send("q=" + url.searchParams.get("q") + "&p=" + page);
};

function requestPrev() {
  getPage(+url.searchParams.get("p") - 1);
};

function requestNext() {
  getPage(+url.searchParams.get("p") + 1);
};

var url = new URL(window.location);
