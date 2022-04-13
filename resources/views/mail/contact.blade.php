<h2>{{ $mailData['title'] ?? '' }}</h2>
<p>会社名: {{ $mailData['company_name'] ?? '' }}</p>
<p>氏名: {{ $mailData['sender_name'] ?? '' }}</p>
<p>メールアドレス: {{ $mailData['sender_email'] ?? '' }}</p>
<p>カテゴリー: {{ $mailData['category'] ?? '' }}</p>
<p>詳細: {{ $mailData['detail'] ?? '' }}</p>