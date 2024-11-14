#!/bin/bash

CWD=$(pwd)

XPONLMS_DIR=$(dirname "$(dirname "$(dirname "$(realpath "$0")")")")
OUTPUT_FILE=/tmp/XponLms-lastbuild.tar.gz
OUTPUT_DIR=/tmp/xpon-plugin-build/

rm -r /tmp/xpon-plugin-build/
mkdir $OUTPUT_DIR &> /dev/null

echo "Plugin dir is: $XPONLMS_DIR"
echo "Output dir is: $OUTPUT_DIR"
echo


cd "$XPONLMS_DIR" || exit

DIR_TO_COPY=(
  modules
  templates
  doc/XponLms.sql
  README.md
  XponLms.php
  public/css/*.css*
  public/js/*.js*
  public/img
  src/XponLmsPlugin/Controller
  src/XponLmsPlugin/Exception
  src/XponLmsPlugin/Handler
  src/XponLmsPlugin/Lib
  src/XponLmsPlugin/Model
  src/XponLmsPlugin/XponLmsPlugin.php
);

for i in "${DIR_TO_COPY[@]}"; do
  echo "Copy $i"
  # shellcheck disable=SC2086
  cp -vr --parents XponLms/$i "$OUTPUT_DIR"
done

cd $OUTPUT_DIR

tar -zcpvf "$OUTPUT_FILE" -- .

echo "Saved as $OUTPUT_FILE"


cd "$CWD" || exit
