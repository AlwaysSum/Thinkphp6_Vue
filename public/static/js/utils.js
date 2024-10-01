const VueUtils = {
  //修复URL
  fixurl(url) {
    if (url.substr(0, 1) !== "/") {
      var r = new RegExp("^(?:[a-z]+:)?//", "i");
      if (!r.test(url)) {
        url = Config.moduleurl + "/" + url;
      }
    } else if (url.substr(0, 8) === "/addons/") {
      url = Config.__PUBLIC__.replace(/(\/*$)/g, "") + url;
    }
    return url;
  },
};
