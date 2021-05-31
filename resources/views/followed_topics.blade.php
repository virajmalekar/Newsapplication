<!doctype html>
<html lang="en">
@include('include.header')
<body style="margin: 100px">
<div class="col-md-8 mt-5 offset-2">
    <label style="font-weight: bold">Select Followed Topics</label>
    <select class="form-control p-3" id="select2">
        @foreach($followedTopics as $key=>$topic)
            @if($key === 0)
                <option value="{{ $topic->keyword }}" selected>{{ $topic->keyword }}</option>
            @else
                <option value="{{ $topic->keyword }}">{{ $topic->keyword }}</option>
            @endif

        @endforeach
    </select>
</div>
<div class="container mt-5">
    @if(count($followedTopics)>0)
        <h4>Search Results for topic "<span class="topic"></span>"&nbsp&nbsp&nbsp<span
                style="padding: 10px; border: 1px solid;cursor: pointer" id="unfollow_topic"><i
                    class="fas fa-trash-alt">&nbsp;Unfollow</i></span></h4>

    @endif
    <h2 class="mb-4">Explore News</h2>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    var followedTopics = null;
    var headlineUrl = '{{ url('fetchTopHeadlines') }}';
    var token = '{{csrf_token()}}'
    var followkeywordURL = '{{ url('setFollowedKeyword') }}'
    $(document).ready(function () {
        followedTopics = $("#select2").val();
        $(".topic").html(followedTopics);
        News.init(followedTopics, "searchbykeyword", headlineUrl, "");
        $('#select2').select2();
        $('#select2').on('change', function (e) {
            followedTopics = $('#select2').select2("val");
            $(".topic").html(followedTopics);
            News.init(followedTopics, "searchbykeyword", headlineUrl, "");
        });
    })
    $("#unfollow_topic").click(function () {
        News.setFollowedItem(followedTopics, "deleteKeyword")
    })
</script>
<script src="{{asset('assets/scripts/News.js',env("APP_ASSETS"))}}"></script>

</html>
