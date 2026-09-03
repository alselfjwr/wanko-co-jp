#!/usr/bin/env bash
# テーマをZIP化します（WordPress管理画面「外観 > テーマ > 新規追加 > テーマのアップロード」用）。
# 使い方: ./build.sh  → dist/wanko.zip が生成されます
set -euo pipefail
cd "$(dirname "$0")"
mkdir -p dist
rm -f dist/wanko.zip
( cd wp-content/themes && zip -rq ../../dist/wanko.zip wanko -x '*.DS_Store' '*/.git*' )
echo "created: dist/wanko.zip ($(du -h dist/wanko.zip | cut -f1))"
