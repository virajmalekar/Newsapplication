<!doctype html>

<html lang="en">
@include('include.header')

<body style="margin: 100px">
<div class="container mt-5">
    <h2 class="mb-4">Today's Top Headlines</h2>
    <form class="form-inline" style="justify-content: flex-end"
          onsubmit="News.searchArticle(event)">
        <div class="form-group mx-sm-3 mb-2">
            <input type="text" class="form-control" id="search_article" value="" placeholder="Search Article">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Search</button>
    </form>
    <button id="clearDatatest" class="btn btn-danger mb-2 ml-2" style="float: right">Clear</button>
    <div class="container mt-5 mb-5">
        <h2 class="display-4" id="keyword_div" style="display: none;font-size: 2.5rem;">You have searched topic "<span
                class="keyword_searched" style="font-weight: bold"></span>" <span id="follow_keyword"
                                                                                  style="cursor: pointer;padding: 12px;border: 1px solid;"><i
                    class="fas fa-bookmark"> Follow</i></span></h2>
    </div>
    <table class="table table-bordered top_headlines_table">
        <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div style="clear:both"></div>
</div>
</body>
<script src="{{asset('assets/datatable/jquery.dataTables.min.js',env("APP_ASSETS"))}}"></script>
<script>
    var headlineUrl = '{{ url('fetchTopHeadlines') }}';
    var selectedSource = "";
    var autorefresh = null;
    var followkeywordURL = '{{ url('setFollowedKeyword') }}'
    var token = '{{csrf_token()}}'
    $(document).ready(function () {
        News.init("", "topheadlines", headlineUrl);
        autorefresh = setInterval(function () {
            News.init("", "topheadlines", headlineUrl);
        }, 60000);

    })
    $("#clearDatatest").click(function () {
        $("#search_article").val("");
        $("#keyword_div").hide();
        News.init("", "topheadlines", headlineUrl);
        autorefresh = setInterval(function () {
            News.init("", "topheadlines", headlineUrl);
        }, 60000);
    });
    $("#follow_keyword").click(function () {
        News.setFollowedItem($('#search_article').val(),'addkeyword')
    })
</script>
<script src="{{asset('assets/scripts/News.js',env("APP_ASSETS"))}}"></script>

</html>
