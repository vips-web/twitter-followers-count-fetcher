# Twitter followers count fetcher

## Twitter Application 登録

1. https://apps.twitter.com/ からアプリケーションを登録
2. Access Token, Token Secretを作成

## .env 環境設定

1. Consumer Key, Consumer Secret, Access Token, Token Secretを.envに記述

## 対象ユーザー登録

`database/database.sqlite`の`target_users`テーブルに対象となるユーザーを登録

## 実行

```sh
$ php artisan fetch-user-followers-count:run 
```
