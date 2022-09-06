!function (e) {
    "use strict";
    e(document).ready(function () {
        function t(t) {
            return t.id ? e('<span><img src="../assets/images/flags/' + t.element.value.toLowerCase() + '.png" class="img-flag" /> ' + t.text + "</span>") : t.text
        }

        e(".js-example-basic-select2").select2(), e(".js-example-templating").select2({
            templateResult: t,
            templateSelection: t,
            allowClear: !0
        });
        e(".js-example-data-array").select2({
            data: [{id: 0, text: "Enhancement"}, {id: 1, text: "Bug"}, {
                id: 2,
                text: "Duplicate"
            }, {id: 3, text: "Invalid"}, {id: 4, text: "Wontfix"}]
        }), e(".js-data-example-ajax").select2({
            placeholder: "Choose your github repo",
            ajax: {
                url: "https://api.github.com/search/repositories", dataType: "json", delay: 250, data: function (e) {
                    return {q: e.term, page: e.page}
                }, processResults: function (e) {
                    return {results: e.items}
                }, processResults: function (e, t) {
                    return t.page = t.page || 1, {results: e.items, pagination: {more: 30 * t.page < e.total_count}}
                }, cache: !0
            },
            escapeMarkup: function (e) {
                return e
            },
            minimumInputLength: 1,
            templateResult: function (e) {
                if (e.loading) return e.text;
                var t = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'><img src='" + e.owner.avatar_url + "' /></div><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.full_name + "</div>";
                return e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>"), t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + e.forks_count + " Forks</div><div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + e.stargazers_count + " Stars</div><div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + e.watchers_count + " Watchers</div></div></div></div>"
            },
            templateSelection: function (e) {
                return e.full_name || e.text
            }
        })
    })
}(window.jQuery);