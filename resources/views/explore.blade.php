<!doctype html>
<html lang="en">
@include('include.header')
<body style="margin: 100px">
<div class="col-md-8 mt-5 offset-2">
    <label style="font-weight: bold">Select News Source</label>
    <select class="form-control p-3" id="select2">
        @foreach($source_lists as $key=>$list)
            @if($key === 0)
                <option value="{{ $list->id }}" selected>{{ $list->name }}</option>
            @else
                <option value="{{ $list->id }}">{{ $list->name }}</option>
            @endif
        @endforeach
    </select>
</div>
<div class="container mt-5">
    <h2 class="mb-4">Explore News</h2>
    <form class="form-inline" style="justify-content: flex-end"
          onsubmit="News.searchArticle(event)">
        <div class="form-group mx-sm-3 mb-2">
            <input type="text" class="form-control" id="search_article" value="" placeholder="Search Article">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Search</button>
    </form>
    <button id="clearDatatest" class="btn btn-danger mb-2 ml-2" style="float: right">Clear</button>
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
</div>
</body>
<script src="{{asset('assets/datatable/jquery.dataTables.min.js',env("APP_ASSETS"))}}"></script>
<link href="{{asset("assets/select2/select2.min.css",env("APP_ASSETS"))}}" rel="stylesheet"/>
<script src="{{asset("assets/select2/select2.min.js",env("APP_ASSETS"))}}"></script>
<script>
    var selectedSource = null;
    var headlineUrl = '{{ url('fetchTopHeadlines') }}';
    var token = '{{csrf_token()}}'
    $(document).ready(function () {
        selectedSource = $("#select2").val();
        $('#select2').select2();
        $('#select2').on('change', function (e) {
            selectedSource = $('#select2').select2("val");
            News.init("", "exploreBySources", headlineUrl, selectedSource);
        });
        News.init("", "exploreBySources", headlineUrl, selectedSource);
    })
    $("#clearDatatest").click(function () {
        $("#search_article").val("");
        News.init("", "exploreBySources", headlineUrl, selectedSource);
    });
</script>
<script src="{{asset('assets/scripts/News.js',env("APP_ASSETS"))}}"></script>

</html>
