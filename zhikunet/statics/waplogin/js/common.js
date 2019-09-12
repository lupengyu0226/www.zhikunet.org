function pageBack() {
	var a = window.location.href;
	if (/#top/.test(a)) {
		window.history.go(-2);
		window.location.load(window.location.href)
	} else {
		window.history.back();
		window.location.load(window.location.href)
	}
}
$(function() {
	$(".search input").attr("autocomplete", "off");
	if (jQuery("#keyword").length > 0) {
		old_keyword = $("#keyword").val().trim();
		searchTipContent();
		old_keyword2 = old_keyword;
		$("#keyword").focus(function() {
			if (old_keyword2 == $("#keyword").val().trim()) {
				$("#keyword").val("")
			}
		});
		$("#keyword").blur(function() {
			if ($("#keyword").val().trim() == "") {
				$("#keyword").val(old_keyword2);
				$("#keyword").attr("style", "color:#999999;")
			}
		})
	}
	if ($("#btnJdkey")) {
		$("#btnJdkey").click(function() {
			if ($("#jdkey").css("display") == "none") {
				$("#jdkey").show()
			} else {
				$("#jdkey").hide()
			}
		})
	}
	var a = window.location.href.replace(/(^http:\/\/)|(\/*$)/g, "");
	if (a.indexOf("/") < 0 || (a.split("/").length <= 2 && a.indexOf("/index") >= 0)) {
		$("#jdkey .new-tbl-cell").eq(0).children().addClass("on")
	}
	if (a.indexOf("/category/all.html") > -1) {
		$("#jdkey .new-tbl-cell").eq(1).children().addClass("on")
	}
	if (a.indexOf("/cart/cart.action") > -1) {
		$("#jdkey .new-tbl-cell").eq(2).children().addClass("on")
	}
	if ((a.indexOf("/user/") > -1) || (a.indexOf("/myJd/") > -1) || (a.indexOf("/wallet/") > -1) || (a.indexOf("jrapp.jd.com/") > -1)) {
		$("#jdkey .new-tbl-cell").eq(3).children().addClass("on")
	}
});