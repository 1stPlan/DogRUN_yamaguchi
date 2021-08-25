<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Type\Question;
use App\Models\Type\QuestionText;
use App\Models\Type\QuestionSet;

class TypeController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {}


  public function index()
  {
    return view('user.type.type');
  }

  public function select($setid, $textid, Request $request)
  {
    if ($textid != 0) {
      $scenarioParent = Question::parentId($textid)->get(); // 親質問から個質問を取得
      $question_text = QuestionText::QuestionTextId($textid)->first()->question_text; // question_text_idから質問文を取得

      $outputQuestions = [];
      for ($i = 0; $i < count($scenarioParent); $i++) {
        $outputQuestions[$i]['next_text'] = $scenarioParent[$i]->next_text_id;
        $outputQuestions[$i]['question_set_id'] = $scenarioParent[$i]->question_set_id;
        $outputQuestions[$i]['question'] = $scenarioParent[$i]->choice;
      }
      return view('user.type.select')->with([
        'outputQuestions' => $outputQuestions,
        'question_text' => $question_text
      ]);
    }

    $outputQuestion = QuestionSet::questionSetId($setid)->first();
    return view('user.type.select_complete')->with([
      'outputQuestion' => $outputQuestion
    ]);
  }
}
