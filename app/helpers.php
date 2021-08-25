<?php
use App\Helpers\DataFormatter;
use Carbon\Carbon;

// viewファイルでも使えるようにするファイル
// グローバルの関数になるので、気をつけて使う。 //記述方法確認

function zipCodeForInput($zipCode)
{
    return DataFormatter::zipCodeForInput($zipCode);
}

function zipCodeForDisplay($zipCode1, $zipCode2)
{
    return DataFormatter::zipCodeForDisplay($zipCode1, $zipCode2);
}

function dateTimeFormatNoYear(Carbon $startDateTime, Carbon $endDateTime)
{
    return $startDateTime->isoFormat('M/D（ddd）HH:mm') . '~' . $endDateTime->isoFormat('HH:mm');
}

function dateTimeFormatFullYear(Carbon $startDateTime, Carbon $endDateTime)
{
    return $startDateTime->isoFormat('YYYY/M/D HH:mm') . '~' . $endDateTime->isoFormat('HH:mm');
}

function escapedMultiLineText($text)
{
    return nl2br(e($text));
}

function sliceText($text, $length)
{
    $text = strip_tags($text);

    if(mb_strlen($text) > $length) {
      return mb_substr($text, 0, $length) . '...';
    }
    return mb_substr($text, 0, $length);
}


// 以下、イベント系の出力周り
// $a = argument
function showToolPw($a)
{
    return $a ? escapedMultiLineText($a) : 'なし';
}

function showFreeFlg($a)
{
    return $a ? '無料' : '有料';
}

function showTicketPrice($a)
{
//    NOTE: 無料出力を入れてるのは、開催申請確認画面で背景色のシマシマがずれるため。
    return $a ? number_format($a) . '円（税別）' : '無料';
}

function showCapacity($a)
{
    return $a ? number_format($a) . '人' : '上限なし';
}

function showPreferredPublishDateTimeDesignationFlg($a)
{
//    HACK: こういう文言管理もどっかでやった方が修正漏れなさそう。
    return $a ? '公開開始日時を設定' : '審査後すぐ（2 営業日以降）';
}

function showEntryDeadlineDateTimeDesignationFlg($a)
{
//    HACK: こういう文言管理もどっかでやった方が修正漏れなさそう。
    return $a ? '申込締切を指定' : '開催開始時間まで参加受付け';
}

function showPreferredPublishDatetime($a)
{
    return $a ? $a : '希望なし';
}
