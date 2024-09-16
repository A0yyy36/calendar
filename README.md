# スケジュール管理アプリ

## 概要
このアプリはスケジュールを管理するWebアプリケーションです．月単位のカレンダーを表示し，クリックした日の予定を入力するとデータベースにデータが格納され，月のカレンダーにも内容が表示されるというアプリケーションです．

## 特徴
- 祝日のデータ
  - 総務省のホームページに載っている祝日データを使用して，スケジュール管理アプリに祝日を表示しています．1955年1月からの祝日のデータが保存されています．
- 月移動
  - 「<」ボタンと「>」ボタンにより，前月と翌月に移動できるようにしています．
- 予定追加
  - データベースを使用して，予定の挿入や削除を行っています．

## 使用方法
### 使用言語
- HTML
- CSS
- JavaScript
- PHP
- SQL

### 使用ファイル
- index.html
  - カレンダーの表示やユーザーインターフェースの定義を行うメインのHTMLファイルです．
- style.css
  - index.htmlで使用するCSSスタイルシートです．カレンダーのデザインやレイアウトを定義しています．
- calendar.js
  - カレンダーのロジックや動的な操作を行うJavaScriptファイルです．カレンダーの描画やイベント処理を担当します．
- calendarEdit.css
  - calendarEdit.php で使用するCSSスタイルシートです．カレンダー編集ページのスタイルを定義します．
- calendarUpdate.php
  - スケジュールデータの更新を行うPHPスクリプトです．スケジュールを追加，更新，削除します．
- schedule.php
  - スケジュールデータを提供するPHPスクリプトです．データベースからスケジュールデータを読み取り，JSON形式で返します．
- calendarEdit.php
  - カレンダーの日付を編集するためのPHPスクリプトです．指定された日付のスケジュールを編集するUIを提供します．
- holiday.php
  - 祝日データを提供するPHPスクリプトです．CSVファイルから祝日データを読み取り，JSON 形式で返します．
- calendar.db
  - カレンダーアプリ内のスケジュールを管理するためのデータベースファイルです．
- jquery-3.7.1.min.js
  - JavaScriptライブラリであるjQueryのバージョン3.7.1の「ミニファイド（minified）」バージョンです．jQueryは，HTMLドキュメントの操作や，イベント処理，アニメーション，Ajaxリクエストの簡素化を目的とした非常に広く使われているライブラリです．
- holiday.csv
  - 1955年1月からの祝日のデータが保存されているファイルです．

 ### 必要環境
- PHP: Apacheを使用するためにXAMPPがインストールされていることを確認してください．
- jQuery: jQueryのホームページ (https://jquery.com) よりjQueryのプログラムファイルがインストールされていることを確認してください．本プログラムではjquery-3.7.1.min.jsを使用しています．
- データベース: スケジュールを管理するためにデータベースを使用します．データベースを使用するためにSQLiteがインストールされていることを確認してください．

### 使用方法
- XAMPPを起動してApacheをスタートする．
- ローカルでホストされているWebページindex.htmlを開く．
- 


