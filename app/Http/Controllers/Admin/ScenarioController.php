<?php

namespace App\Http\Controllers\Admin\Scenario;

use App\Http\Controllers\Controller;
use App\Models\BasicScenario;
use App\Models\LifeScenario;
use App\Models\MainScenario;
use App\Models\MotionCheck;
use App\Models\Movie;
use Aws\S3\S3Client;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Storage;

class ScenarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {

        $basicscenario = BasicScenario::orderBy('id', 'ASC')->get();
        $lifescenario = LifeScenario::orderBy('id', 'ASC')->get();
        $mainscenario = MainScenario::orderBy('id', 'ASC')->get();
        $motion_check = MotionCheck::orderBy('id', 'ASC')->get();

        $scenarioLists = [];

        $count_main = count($mainscenario);

        for ($i = 0; $i < $count_main; $i++) {

            $movie = Movie::movieId($mainscenario[$i]->movie_id)->first();
            $count = $i + 1;

            $scenarioLists[$i]['id'] = $mainscenario[$i]->id;
            $scenarioLists[$i]['set_id'] = $count;
            $scenarioLists[$i]['name'] = $mainscenario[$i]->name;
            $scenarioLists[$i]['movie'] = empty($movie->url) ? '×' : '〇';  // movieが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['thumbnail'] = empty($movie->thumbnail_url) ? '×' : '〇';  // thumbnailが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['movie_id'] = $mainscenario[$i]->movie_id;
            $scenarioLists[$i]['text'] = isset($mainscenario[$i]->point) ? '〇' : '×';
            $scenarioLists[$i]['type'] = 'main';
        }
        // return exit;
        $count_basic = count($basicscenario) + $count_main;

        for ($i = $count_main; $i < $count_basic; $i++) {
            $j = $i - $count_main;

            $movie = Movie::movieId($basicscenario[$j]->movie_id)->first();
            $count = $i + 1;

            $scenarioLists[$i]['id'] = $basicscenario[$j]->id;
            $scenarioLists[$i]['set_id'] = $count;
            $scenarioLists[$i]['name'] = $basicscenario[$j]->name;
            $scenarioLists[$i]['movie'] = empty($movie->url) ? '×' : '〇';  // movieが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['thumbnail'] = empty($movie->thumbnail_url) ? '×' : '〇';  // thumbnailが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['movie_id'] = $basicscenario[$j]->movie_id;
            $scenarioLists[$i]['text'] = isset($basicscenario[$j]->point) ? '〇' : '×';
            $scenarioLists[$i]['type'] = 'basic';
        }

        $count_life = count($lifescenario) + $count_basic;

        for ($i = $count_basic; $i < $count_life; $i++) {
            $j = $i - $count_basic;
            $movie = Movie::movieId($lifescenario[$j]->movie_id)->first();
            $count = $i + 1;

            $scenarioLists[$i]['id'] = $lifescenario[$j]->id;
            $scenarioLists[$i]['set_id'] = $count;
            $scenarioLists[$i]['name'] = $lifescenario[$j]->name;
            $scenarioLists[$i]['movie'] = empty($movie->url) ? '×' : '〇';  // movieが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['thumbnail'] = empty($movie->thumbnail_url) ? '×' : '〇';  // thumbnailが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['movie_id'] = $lifescenario[$j]->movie_id;
            $scenarioLists[$i]['text'] = isset($lifescenario[$j]->point) ? '〇' : '×';
            $scenarioLists[$i]['type'] = 'life';
        }

        $count_motion = count($motion_check) + $count_life;

        for ($i = $count_life; $i < $count_motion; $i++) {
            $j = $i - $count_life;
            $movie = Movie::movieId($motion_check[$j]->movie_id)->first();
            $count = $i + 1;

            $scenarioLists[$i]['id'] = $motion_check[$j]->id;
            $scenarioLists[$i]['set_id'] = $count;
            $scenarioLists[$i]['name'] = $motion_check[$j]->name;
            $scenarioLists[$i]['movie'] = empty($movie->url) ? '×' : '〇';  // movieが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['thumbnail'] = empty($movie->thumbnail_url) ? '×' : '〇';  // thumbnailが歩かないかはURLの有無でとる？
            $scenarioLists[$i]['movie_id'] = $motion_check[$j]->movie_id;
            $scenarioLists[$i]['text'] = '-';
            $scenarioLists[$i]['type'] = 'motion';
        }

        return view('admin.scenario.index')->with(['scenarioLists' => $scenarioLists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $type, $id)
    {

        $scenarioList = [];
        if ($type == 'main') {

            $mainscernaro = MainScenario::mainId($id)->first();
            $movie = Movie::movieId($mainscernaro->movie_id)->first();

            $scenarioList = $mainscernaro;

            if ($movie) {
                $scenarioList['movie_url'] = $movie->url;
                $scenarioList['movie_id'] = $movie->id;
            }
        } elseif ($type == 'life') {
            $lifescenario = LifeScenario::lifeId($id)->first();
            $movie = Movie::movieId($lifescenario->movie_id)->first();
            $scenarioList = $lifescenario;
            if ($movie) {
                $scenarioList['movie_url'] = $movie->url;
                $scenarioList['movie_id'] = $movie->id;
            }
        } elseif ($type == 'basic') {
            $basicscenario = BasicScenario::basicId($id)->first();
            $movie = Movie::movieId($basicscenario->movie_id)->first();
            $scenarioList = $basicscenario;

            if ($movie) {
                $scenarioList['movie_url'] = $movie->url;
                $scenarioList['movie_id'] = $movie->id;
            }
        } else {
            $motion_check = MotionCheck::motionId($id)->first();
            $movie = Movie::movieId($motion_check->movie_id)->first();
            $scenarioList = $motion_check;

            if ($movie) {
                $scenarioList['movie_url'] = $movie->url;
                $scenarioList['movie_id'] = $movie->id;
            }
        }

        return view('admin.scenario.edit')->with(['scenarioList' => $scenarioList, 'type' => $type, 'id' => $id, 'movie' => $movie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type, $id)
    {

        // S3用の署名用関数を定義-----------------------------------------------

        /**
         * @param  \App\Http\Requests\GetPresignedUrlRequest  $request
         * @return \Illuminate\Http\JsonResponse
         */

        // function getPresignedUrl($key)
        // {
        //     $s3Client = new S3Client([
        //       'region' => config('filesystems.disks.s3.region'),
        //       'version' => config('filesystems.disks.s3.aws_sdk.version'),
        //   ]);

        //   $cmd = $s3Client->getCommand('PutObject', [
        //       'Bucket' => config('filesystems.disks.s3.bucket'),
        //       'Key' => $key,
        //     //   'ACL' => 'public-read', // 画像は一般公開されます
        //   ]);

        //   $presignedRequest = $s3Client->createPresignedRequest(
        //       $cmd,
        //       config('filesystems.disks.s3.aws_sdk.pre_signed_url.expired_time')
        //   );

        //   return response()->json([
        //     'pre_signed_url' => (string) $presignedRequest->getUri()
        //   ]);

        // }
        // ---------------------------------------------------------------------------

        if ($type == 'main') {

            $mainscernaro = MainScenario::mainId($id)->first();
            $movie = Movie::movieId($mainscernaro->movie_id)->first();

            $data = $request->all();

            DB::transaction(function () use ($id, $type, $mainscernaro, $movie, $data) {
                if (isset($data['file']) || isset($data['thumbnail_file'])) {
                    if (isset($data['file'])) {
                        // url取得(s3)
                        $url_path = Storage::disk('s3')->putFileAs('/movie', $data['file'], $type.$id.'.mp4');
                        $new_movie_path = Storage::disk('s3')->url($url_path);

                        // url取得(s3 署名付き)※いつか対応
                        // $key = 'movie/'. $type . $id.'.mp4';
                        // $date = getPresignedUrl($key);
                        // $url = $date->original["pre_signed_url"];
                        // // $filename = $date->original["key"];
                        // $client = new \GuzzleHttp\Client();
                        // $client->put($url, [
                        //     'form_params' => [
                        //         'Key' =>  file($data['file']),
                        //         'content-type' => "video/mp4"
                        //     ],
                        // ]);

                    } else {
                        // 古いurl取得
                        $old_movie = $movie->url;
                        $new_movie_path = $old_movie;
                    }

                    if (isset($data['thumbnail_file'])) {

                        $thumbnail_path = Storage::disk('s3')->putFileAs('/thumbnail', $data['thumbnail_file'], $type.$id.'.jpg');
                        $new_thumbnail_path = Storage::disk('s3')->url($thumbnail_path);

                        // url取得(s3 署名付き)※作成中
                        // $key = 'thumbnail/'. $type . $id.'.jpg';
                        // $date = getPresignedUrl($key);
                        // $url = $date->original["pre_signed_url"];
                        // $client = new \GuzzleHttp\Client();

                        // $client->put($url, [
                        //     'form_params' => [
                        //         // 'Key' =>  fopen($request->file('thumbnail_file'), "r"),
                        //         'Key' => $data['thumbnail_file'],
                        //         'content-type' => "image/jpg"

                        //     ],
                        // ]);
                        // $new_thumbnail_path = $key;

                    } else {
                        // 古いthumbnail_url取得
                        $old_thumbnail = $movie->thumbnail_url;
                        $new_thumbnail_path = $old_thumbnail;
                    }

                    if (! $mainscernaro->movie_id) {
                        // $new_movie = Movie::create(['url' => Storage::disk('local')->url($path)]);
                        // $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);
                        $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                    } else {
                        // Movie::find($mainscernaro->movie_id)->delete();

                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);
                        $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                    }
                }

                $mainscernaro->fill(['point' => $data['point']])->save();
            });
        } elseif ($type == 'life') {

            $lifescenario = LifeScenario::lifeId($id)->first();
            $movie = Movie::movieId($lifescenario->movie_id)->first();

            $data = $request->all();

            DB::transaction(function () use ($id, $type, $lifescenario, $movie, $data) {
                if (isset($data['file']) || isset($data['thumbnail_file'])) {
                    if (isset($data['file'])) {
                        // url取得
                        // $url_path = Storage::disk('local')->putFileAs('public/movie', $data['file'], $type . $id . '.mp4', 'public');
                        // $new_movie_path = Storage::disk('local')->url($url_path);
                        $url_path = Storage::disk('s3')->putFileAs('/movie', $data['file'], $type.$id.'.mp4');
                        $new_movie_path = Storage::disk('s3')->url($url_path);
                    } else {
                        // 古いurl取得
                        $old_movie = $movie->url;
                        $new_movie_path = $old_movie;
                    }

                    if (isset($data['thumbnail_file'])) {
                        // thumbnail_url取得
                        // $thumbnail_path = Storage::disk('local')->putFileAs('public/thumbnail', $data['thumbnail_file'], $type . $id . '.jpg', 'public');
                        // $new_thumbnail_path = Storage::disk('local')->url($thumbnail_path);
                        $thumbnail_path = Storage::disk('s3')->putFileAs('/thumbnail', $data['thumbnail_file'], $type.$id.'.jpg');
                        $new_thumbnail_path = Storage::disk('s3')->url($thumbnail_path);
                    } else {
                        // 古いthumbnail_url取得
                        $old_thumbnail = $movie->thumbnail_url;
                        $new_thumbnail_path = $old_thumbnail;
                    }

                    if (! $lifescenario->movie_id) {
                        // $new_movie = Movie::create(['url' => Storage::disk('local')->url($path)]);
                        // $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);

                        $lifescenario->fill(['movie_id' => $new_movie->id])->save();
                    } else {
                        // // Movie::find($mainscernaro->movie_id)->delete();
                        // $new_movie = Movie::create(['url' => Storage::disk('local')->url($path)]);
                        // $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                        // // $movie->fill(['url' => Storage::disk('local')->url($path)])->save();
                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);

                        $lifescenario->fill(['movie_id' => $new_movie->id])->save();
                    }
                }

                $lifescenario->fill(['point' => $data['point']])->save();
            });
        } elseif ($type == 'basic') {
            $basicscenario = BasicScenario::basicId($id)->first();
            $movie = Movie::movieId($basicscenario->movie_id)->first();

            $data = $request->all();

            DB::transaction(function () use ($id, $type, $basicscenario, $movie, $data) {
                if (isset($data['file']) || isset($data['thumbnail_file'])) {
                    if (isset($data['file'])) {
                        // url取得
                        // $url_path = Storage::disk('local')->putFileAs('public/movie', $data['file'], $type . $id . '.mp4', 'public');
                        // $new_movie_path = Storage::disk('local')->url($url_path);
                        $url_path = Storage::disk('s3')->putFileAs('/movie', $data['file'], $type.$id.'.mp4');
                        $new_movie_path = Storage::disk('s3')->url($url_path);
                    } else {
                        // 古いurl取得
                        $old_movie = $movie->url;
                        $new_movie_path = $old_movie;
                    }

                    if (isset($data['thumbnail_file'])) {
                        // thumbnail_url取得
                        // $thumbnail_path = Storage::disk('local')->putFileAs('public/thumbnail', $data['thumbnail_file'], $type . $id . '.jpg', 'public');
                        // $new_thumbnail_path = Storage::disk('local')->url($thumbnail_path);
                        $thumbnail_path = Storage::disk('s3')->putFileAs('/thumbnail', $data['thumbnail_file'], $type.$id.'.jpg');
                        $new_thumbnail_path = Storage::disk('s3')->url($thumbnail_path);
                    } else {
                        // 古いthumbnail_url取得
                        $old_thumbnail = $movie->thumbnail_url;
                        $new_thumbnail_path = $old_thumbnail;
                    }

                    if (! $basicscenario->movie_id) {
                        // $new_movie = Movie::create(['url' => Storage::disk('local')->url($path)]);
                        // $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);

                        $basicscenario->fill(['movie_id' => $new_movie->id])->save();
                    } else {
                        // // Movie::find($mainscernaro->movie_id)->delete();
                        // $new_movie = Movie::create(['url' => Storage::disk('local')->url($path)]);
                        // $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                        // // $movie->fill(['url' => Storage::disk('local')->url($path)])->save();
                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);

                        $basicscenario->fill(['movie_id' => $new_movie->id])->save();
                    }
                }

                $basicscenario->fill(['point' => $data['point']])->save();
            });
        } else {
            $motion_check = MotionCheck::motionId($id)->first();
            $movie = Movie::movieId($motion_check->movie_id)->first();

            $data = $request->all();

            DB::transaction(function () use ($id, $type, $motion_check, $movie, $data) {
                if (isset($data['file']) || isset($data['thumbnail_file'])) {
                    // 古いurl取得
                    $old_movie = $movie->url;
                    // 古いthumbnail_url取得
                    $old_thumbnail = $movie->thumbnail_url;

                    if (isset($data['file'])) {
                        // url取得
                        // $url_path = Storage::disk('local')->putFileAs('public/movie', $data['file'], $type . $id . '.mp4', 'public');
                        // $new_movie_path = Storage::disk('local')->url($url_path);
                        $url_path = Storage::disk('s3')->putFileAs('/movie', $data['file'], $type.$id.'.mp4');
                        $new_movie_path = Storage::disk('s3')->url($url_path);
                    } else {
                        $new_movie_path = $old_movie;
                    }

                    if (isset($data['thumbnail_file'])) {
                        // thumbnail_url取得
                        // $thumbnail_path = Storage::disk('local')->putFileAs('public/thumbnail', $data['thumbnail_file'], $type . $id . '.jpg', 'public');
                        // $new_thumbnail_path = Storage::disk('local')->url($thumbnail_path);
                        $thumbnail_path = Storage::disk('s3')->putFileAs('/thumbnail', $data['thumbnail_file'], $type.$id.'.jpg');
                        $new_thumbnail_path = Storage::disk('s3')->url($thumbnail_path);
                    } else {
                        $new_thumbnail_path = $old_thumbnail;
                    }

                    if (! $motion_check->movie_id) {
                        // $new_movie = Movie::create(['url' => Storage::disk('local')->url($path)]);
                        // $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);

                        $motion_check->fill(['movie_id' => $new_movie->id])->save();
                    } else {
                        // // Movie::find($mainscernaro->movie_id)->delete();
                        // $new_movie = Movie::create(['url' => Storage::disk('local')->url($path)]);
                        // $mainscernaro->fill(['movie_id' => $new_movie->id])->save();
                        // // $movie->fill(['url' => Storage::disk('local')->url($path)])->save();
                        $new_movie = Movie::create([
                            'url' => $new_movie_path,
                            'thumbnail_url' => $new_thumbnail_path,
                        ]);

                        $motion_check->fill(['movie_id' => $new_movie->id])->save();
                    }
                }
                // $motion_check->fill(['point' => $data['point']])->save();
            });
        }

        return redirect('admin/scenario/'.$type.'/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //
    // public function b() {
    //   return view('admin.scenario.edit');
    // }
}
