## Docker LAMP Laravel構成
|構成|バージョン|
|---|---|
|Apache||
|PHP|7.4|
|mysql|5.7|
|Laravel|6.20.34|
|PhpMyAdmin|latest|
|nodejs|12.x|

## ホームディレクトリ直下にあるDockerPracticeディレクトリに移動
```bash
$ cd findy
```
## Dockerイメージを作成
```bash
$ docker-compose build
```
## Dockerを起動
 -d でバックグランド起動
```bash

$ docker-compose up -d
```
## 起動しているコンテナが表示される
```bash
$ docker ps
```

## appコンテナ（名称：laravel_app）に入ります
```bash
$ winpty docker-compose exec app bash
```
## Laravelプロジェクト作成
```bash
$ composer create-project --prefer-dist laravel/laravel laravelfindy "6.20.*"
```

## Laravelプロジェクト移動
```bash
$ cd laravelfindy
```
## ストレージの権限変更
```bash
$ chmod 777 -R storage/
$ php artisan key:generate
```
