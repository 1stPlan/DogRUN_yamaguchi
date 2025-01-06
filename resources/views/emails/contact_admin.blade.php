<br />
お客様からのお問い合わせを受付けましたので、ご連絡いたします。<br>
<br />
<div style="border-top: 0.5px solid; border-bottom: 0.5px solid;"><br />
    <br />
    <b>お客様のお名前：</b><br />{{ $inputs['name_top'] }} 様<br />
    <br />
    <b>お客様のメールアドレス：</b><br />{{ $inputs['mail'] }} <br />
    <br>
    <b>お問い合わせ内容：</b><br />
    <?php echo nl2br(htmlspecialchars($inputs['content'])); ?><br />
    <br />
    内容を確認のうえ、管理画面よりご回答をお願い致します。<br />
    <br />
</div>
<div style="border-top: 0.5px solid; text-align: center;">
    <br />
    <b>DogRun山口</b><br />
    <br />
</div>