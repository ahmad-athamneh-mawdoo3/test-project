<?php

namespace mawdoo3\test\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \mawdoo3\test\Models\SavedResult;

class SearchController extends Controller
{
    /**
     * Get Search Result from Google Custom Search
     *
     * @param  String  $searchWord
     * @return Array
     */
    public function getSearch($searchWord = '')
    {
        $cx = config('customSearch.cx');
        $key = config('customSearch.key');
        $searchWord = ($searchWord === '') ? (isset($_GET['search'])) ? $_GET['search'] : '' : $searchWord;
        
        $ch = curl_init("https://www.googleapis.com/customsearch/v1?q=$searchWord&cx=$cx&num=10&start=1&key=$key&alt=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $response = json_decode($server_output);
        if ($status == 200 && isset($response->items)) {
            $data = [];
            foreach ($response->items as $key => $value) {
                array_push($data, [
                    'title' => $value->title,
                    'description' => $value->pagemap->metatags[0]->{'og:description'},
                    'link' => $value->link,
                    'formattedUrl' => $value->formattedUrl,
                    'comment' => '',
                    'isSelected' => false,
                ]);
            }
            return $data;

        } else {
            return [];
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return HTML view and data from getSearch() function
     */
    public function search($searchWord = '')
    {

        return view('task::search', ['searchData' => $this->getSearch($searchWord), 'searchWord' => $searchWord]);
        //
    }
    /**
     * Show All saved Results
     *
     * @return HTML view and data from DB SavedResult Model
     */
    public function savedResults()
    {
        return view('task::saved_results', ['data' => SavedResult::all()]);
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $data = $request->all()['item'];
        $filtered = array_filter($data, function ($item) {return isset($item['isSelected']) && $item['isSelected'] == "true";});
        $filtered = array_values($filtered);
        $filtered = array_map(function ($item) {
            unset($item['isSelected']);
            $item['created_at'] = now();
            return $item;
        }, array_values($filtered));
        SavedResult::insert(array_values($filtered));
        return view('task::saved_results', ['data' => SavedResult::all()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SavedResult  $result
     * @return  redirect to another route
     */
    public function update(Request $request, $result)
    {
        $result->update(['comment' => $request->comment]);
        return redirect()->route('savedResults');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return  redirect to another route
     */
    public function destroy($result)
    {
        //
        $result->delete();
        return redirect()->route('savedResults');
    }

    /**
     * redirect the specified function depend on action.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to another function
     */
    public function chooseAction(Request $request, $id)
    {
        $result = SavedResult::find($id);
        return ($request->all()['action'] == 'Delete') ? $this->destroy($result) : $this->update($request, $result);
    }
    /**
     * redirect the specified function depend on action.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to another function
     */
    public function testRoute(Request $request)
    {
        dd($request->all());
        return ; 
    }
}
