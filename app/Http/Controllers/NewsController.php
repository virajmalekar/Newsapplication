<?php

namespace App\Http\Controllers;

use App\Models\FollowKeyword;
use App\Models\Source;
use Cron\FieldFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Enums\ApiDetails;

class NewsController extends Controller
{
    public function fetchTopNewsView()
    {
        return view('top-headlines');
    }

    /**
     * Fetches the data for Datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function fetchTopHeadlines(Request $request)
    {
//        if ($request->ajax()) {
            $data = $this->fetchAPIData($request->all());
            return Datatables::of($data)
                ->addColumn('urlToImage', function ($row) {
                    if (!empty($row->urlToImage) && $row->urlToImage != "") {
                        $image = '<img src="' . $row->urlToImage . '" alt="HeadLine Image" width="100" height="100">';
                    } else {
                        $image = '<img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg" alt="HeadLine Image" width="100" height="100">';
                    }
                    return $image;
                })
                ->addColumn('title', function ($row) {
                    $image = '<a href="' . $row->url . '" target="_blank"> ' . $row->title . '</a>';
                    return $image;
                })
                ->addColumn('publishedAt', function ($row) {
                    $row->publishedAt = str_replace('T', ' ', $row->publishedAt);
                    $row->publishedAt = str_replace('Z', ' ', $row->publishedAt);
                    $row->publishedAt = date('l, F d y h:i a', strtotime($row->publishedAt));
                    return $row->publishedAt;
                })
                ->rawColumns(['urlToImage', 'title', 'publishedAt'])
                ->make(true);
        }
//    }

    /**
     * Fetches the data from the API of NewsAPI.org
     *
     * @param $filters
     * @return mixed
     */
    public function fetchAPIData($filters)
    {
        dump($filters);
        if ($filters['sources'] != "" && $filters['searchKeyword'] != "") {
            $apiUrl = ApiDetails::api_url . ApiDetails::search_everything . "?q=" . $filters['searchKeyword'] . "&sources=" . urlencode($filters['sources']) . "&apiKey=" . ApiDetails::api_key . "";
        } else if ($filters['action'] == 'searchbykeyword' && $filters['searchKeyword'] != "") {
            $apiUrl = ApiDetails::api_url . ApiDetails::search_everything . "?q=" . $filters['searchKeyword'] . "&apiKey=" . ApiDetails::api_key . "";
        } else if ($filters['action'] == 'exploreBySources' && $filters['sources'] != "") {
            $apiUrl = ApiDetails::api_url . ApiDetails::search_everything . "?sources=" . urlencode($filters['sources']) . "&apiKey=" . ApiDetails::api_key . "";
        } else {
            $apiUrl = ApiDetails::api_url . ApiDetails::top_headlines . "?country=" . urlencode(ApiDetails::api_country) . "&apiKey=" . ApiDetails::api_key . "";
        }
        $data = file_get_contents($apiUrl);
        $data = json_decode($data);
        $data = $data->articles;
        return $data;
    }

    public function setFollowedKeyword(Request $request)
    {
        $this->validate($request, [
            'followKeyword' => 'required',
        ], [
            'title.required' => 'Please select a valid keyword to follow',
        ]);
        if ($request->action == "addkeyword") {
            $checkkeyword = FollowKeyword::where("keyword", "=", $request->followKeyword)->first();
            if ($checkkeyword == "") {
                $insert = array('user_id' => auth()->user()->id, 'keyword' => $request->followKeyword, 'created_at' => date("Y-m-d h:i:s"));
                FollowKeyword::insert($insert);
                return "true";
            } else {
                return "false";
            }
        } else {
            $checkkeyword = FollowKeyword::where("keyword", "=", $request->followKeyword);
            $checkkeyword->delete();
            dd($checkkeyword);
            return "deleted";
        }

    }

    public function exploreNewsTopics()
    {
        $sources_list = file_get_contents("https://newsapi.org/v2/sources?apiKey=" . ApiDetails::api_key . "");
        $sources_list = json_decode($sources_list);

        $sources_list = $sources_list->sources;
//        $sources_list = json_decode(json_encode($sources_list), true);
//        $sources_list = array_map(function ($tag) {
//            return array(
//                  "source_id" => $tag["id"],
//                  "name" => $tag["name"],
//                  "description" => $tag["description"],
//                  "url" => $tag["url"],
//                  "category" => $tag["category"],
//                  "language" => $tag["language"],
//                  "country" => $tag["country"],
//                  "created_at" => date("Y-m-d h:i:s"),
//            );
//        }, $sources_list);
//
//        $sources = Source::insert($sources_list);
        return view("explore", ['source_lists' => $sources_list]);
    }

    public function followedKeywords()
    {
        $followedTopics = FollowKeyword::where('deleted_at', NULL)->get();
        return view('followed_topics', ['followedTopics' => $followedTopics]);
    }


}
