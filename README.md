# laravel-matching
サービス内容 IT人材と企業のマッチングサービス
使用技術 
バックエンド Laravel Mysql
フロントエンド blade jQuery
その他 stripe

以下URLは全てテスト環境

管理者画面　view(laravel-matching/resources/view/administrator)
http://longopmatch.xsrv.jp/administrator

機能一覧<br>
・ログイン<br>
・新規登録<br>
・管理者追加/管理者削除<br>
・お知らせ機能<br>
・ユーザー検索/ユーザー詳細/ユーザー削除<br>
・企業検索/企業詳細/企業削除/企業へメッセージ<br>
・案件検索/案件詳細/案件削除<br>
・契約情報検索/契約情報詳細/契約情報削除/契約情報状態の可視化(全て、契約満了3日以内、契約満了、人材稼働確認前、支払前、支払済み)<br>
・支払情報確認/支払情報詳細/支払情報削除/支払情報状態の可視化(全て、支払前、支払済み)<br>
・メッセージ機能(to企業)<br>

企業ページ　view(laravel-matching/resources/view/client1)
http://longopmatch.xsrv.jp/client1/

機能一覧<br>
・ログイン<br>
・新規登録<br>
・お知らせ機能<br>
・プロフィール入力/編集<br>
・メッセージ機能(to管理者、人材)<br>
・案件作成/案件詳細/案件編集/案件一覧表示<br>
・案件応募者一覧表示/案件応募者の選定/応募人材お気に入り機能<br>
・人材の選定：確定<br>
・人材稼働確認機能<br>
・契約一覧表示<br>
・支払機能/支払情報確認/領収書のPDF発行(一度のみ)<br>
・パスワード変更<br>

人材ページ　view(laravel-matching/resources/view/client2)
http://longopmatch.xsrv.jp/client2/main<br>
ログイン情報<br>
ID：test@gmail.com<br>
password：test1010<br>

機能一覧<br>
・ログイン<br>
・新規登録<br>
・お知らせ機能<br>
・プロフィール入力/編集<br>
・メッセージ機能(to企業)<br>
・案件検索機能(ワード検索、単価検索、言語検索、業界：業種検索、地域検索、その他項目検索)<br>
・案件詳細/案件掲載企業詳細<br>
・案件応募<br>
・応募案件一覧<br>
・応募落選一覧<br>
・パスワード変更<br>
