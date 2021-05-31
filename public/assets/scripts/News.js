var News = function () {

    var handleRecords = (searchString = "", action = "", URL = "", sources = "") => {
        var table = $('.top_headlines_table').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: {
                'url': URL,
                "data": function (d) {
                    d.searchKeyword = searchString;
                    d.action = action;
                    d.sources = sources;
                }
            },
            searching: false,
            columns: [
                {data: 'urlToImage', name: 'urlToImage'},
                {data: 'title', name: 'title'},
                {data: 'publishedAt', name: 'publishedAt'},
            ]
        });


    };
    var searchArticle = (e) => {
        if ($('#search_article').val() === "") {
            alert("Please enter a valid article name")
        }
        e.preventDefault();
        handleRecords($('#search_article').val(), "searchbykeyword", headlineUrl, selectedSource)
        $("#keyword_div").show();
        $(".keyword_searched").html($('#search_article').val())
        clearInterval(autorefresh);
    }
    var setFollowedItem = (keyword, action) => {
        if ($('#search_article').val() === "") {
            alert("Please enter a valid article name to follow")
        }
        $.ajax({
            type: "POST",
            url: followkeywordURL,
            data: {
                "followKeyword": keyword,
                "action": action,
                '_token': token
            },
            cache: false,
            success: function (result) {
                if (result == "true") {
                    alert("Keyword added to followed successfully")
                } else if (result === "false") {
                    alert("Keyword is already added to the followed list")
                } else {
                    alert("Entry Deleted Successfully")
                    location.reload();
                }
            }
        });
    }
    var getFollowedItem = () => {
        $.ajax({
            type: "POST",
            url: followkeywordURL,
            data: {
                '_token': token
            },
            cache: false,
            success: function (result) {
            }
        });
    }
    return {
        init: handleRecords,
        searchArticle: searchArticle,
        setFollowedItem: setFollowedItem,
        getFollowedItem: getFollowedItem
    };


}();

