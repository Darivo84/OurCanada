updateClientInfo();
var CdAtE = new Date();

function detectBrowser() {
    var N = navigator.appName;
    var UA = navigator.userAgent;
    var temp;
    var browserVersion = UA.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
    if (browserVersion && (temp = UA.match(/version\/([\.\d]+)/i)) != null)
        browserVersion[2] = temp[1];
    browserVersion = browserVersion ? [browserVersion[1], browserVersion[2]] : [N, navigator.appVersion, '-?'];
    return browserVersion;
};

function genFormHtml() {
    $("input,select,textarea").each(function() {

        if ($(this).is("[type='checkbox']") || $(this).is("[type='radio']")) {
            $(this).attr("checked", $(this).is(":checked"));
        } else if ($(this).prop("tagName") == "SELECT") {
            $(this).find('option[value="' + $(this).val() + '"]').attr('selected', true);
        } else {
            $(this).attr("value", $(this).val());
        }
    });
}

function updateClientInfo() {
    console.log(detectBrowser().toString());
    currentRequest = $.ajax({
        dataType: 'json',
        url: "bg_ajax.php?h=updateclientInfo",
        type: 'POST',
        data: {
            'browser': detectBrowser().toString(),
            'timezone': Intl.DateTimeFormat().resolvedOptions().timeZone,
            'cdatetime': (new Intl.DateTimeFormat('en-GB', { dateStyle: 'full', timeStyle: 'long' }).format(CdAtE))
        },
        success: function(data) {

        },
        error: function(data) {
            // updateClientInfo();
        }
    });
}