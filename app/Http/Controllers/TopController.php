<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event\Event;
use App\Models\MyTube;

class TopController extends Controller
{

  public function first()
  {
      return view('first');

  }
  public function index()
  {
    // var_dump("top");
    // return exit;

      // $events = Event::take(3)->get();
      // $myTubes = MyTube::take(4)->get();

     // instagramの投稿を取得
    //  $url = 'https://graph.facebook.com/v3.0/' . env('INSTAGRAM_USER_ID', '') . '?fields=name%2Cmedia.limit(4)%7Bcaption%2Clike_count%2Cmedia_url%2Cpermalink%2Ctimestamp%2Cusername%7D&access_token=' . env('INSTAGRAM_TOKEN', '');
    //    $curl = curl_init($url);
    //    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // メソッド指定
    //    // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
    //    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列で受け取る
    //    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //    $response = curl_exec($curl);
    //    // $data = $response['media'];
    //    curl_close($curl);
    //    $jsonResponse = json_decode($response);
    //    $data = $jsonResponse->media->data;

      return view('home')->with([
      // 'events' => $events,
      // 'myTubes' => $myTubes
      // 'data' => $data
    ]);

  }
}

//①youtube サムネイル保存

// $mov_id = strstr($data['movie_url'], 'v=');
// $mov_id = mb_substr($mov_id, 2);

// $thumb_size = "default.jpg";
// $data['movie_thumbnail']  = sprintf("http://img.youtube.com/vi/%s/%s", $mov_id, $thumb_size);

// <div class="video_flex video_top">
// @foreach ($customerReviews as $customerReview)
//   <div class="video">
//     <iframe src="https://www.youtube.com/embed/{{ $customerReview->movie_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
//     <p class="video_description">{{ $customerReview->title }}</p>
//     <p class="video_sub_description">{{ $customerReview->description }}</p>
//   </div>
// @endforeach
// </div>

//②ローカルでの取得
  //拡張子を取得
  // $extension = $request->file('main_image')->getClientOriginalExtension();
  // $main_url_path = Storage::disk('local')->putFileAs('public/part_image/parts_main', $data['main_image'], date('YmdHis').".".$extension, 'public');
  // $content->parts_main_image_url = Storage::url($main_url_path);
  // <img src="{{ asset($cont->parts_main_image_url) }}" width="300px" >

  // ③インスタの反映

  //       // instagramの投稿を取得
  //       $url = 'https://graph.facebook.com/v3.0/' . env('INSTAGRAM_USER_ID', '') . '?fields=name%2Cmedia.limit(3)%7Bcaption%2Clike_count%2Cmedia_url%2Cpermalink%2Ctimestamp%2Cusername%7D&access_token=' . env('INSTAGRAM_TOKEN', '');

  //       $curl = curl_init($url);

  //       curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // メソッド指定
  //       // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
  //       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列で受け取る
  //       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  //       $response = curl_exec($curl);
  //       // $data = $response['media'];
  //       curl_close($curl);


  //       $jsonResponse = json_decode($response);

  //       $data = $jsonResponse->media->data;
