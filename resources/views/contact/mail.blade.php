<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>お問い合わせを受け付けました</title>
</head>
<body>
    <p>お問い合わせ内容は以下のとおりとなります</p>
    --------------
    <p>件名：{{ $inputs['title'] }}</p>
    <p>お問い合わせの内容：{{ $inputs['body'] }}</p>
    <p>メールアドレス：{{ $inputs['email'] }}</p>
    --------------
    <p>担当者よりご連絡致しますので、少々お待ちくださいませ</p>
</body>
</html>