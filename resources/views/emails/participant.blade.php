<br />
<b>{{ $user->name }} 様</b><br />
<br />
この度は「{{ $event->title }}」にご参加いただき、誠にありがとうございます。<br />
イベント開始が 1時間後 に迫りましたので、改めて詳細をご案内いたします。<br />
<br />
<div style="border-top: 0.5px solid;">
    <br />
    <b>イベント詳細</b><br /><br />
    イベント名: {{ $event->title }}<br />
    開始日時: {{ $event->start_datetime->format('Y年m月d日 H:i') }}<br />
    概要:<br />
    {{ $event->body }}
</div>
<br />
<div style="border-top: 0.5px solid;">
    <br />
    <b>注意事項</b><br /><br />
    愛犬のリードや必要なグッズを忘れずにお持ちください。<br />
    万が一遅れる場合は、事前に運営までご連絡ください。 <br />
    <br />
</div>

<div style="border-top: 0.5px solid; text-align: center;">
    <br />
    <b>DogRun山口</b><br />
    <br />
</div>