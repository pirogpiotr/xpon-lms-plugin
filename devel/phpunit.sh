#!/bin/bash

BASEDIR=$(dirname "$0")

# Przy samej opcji testdox nie pokazuje szczegółów wyjątku
# $BASEDIR/../vendor/bin/phpunit --testdox "$@"

# Przydatne opcje:
# --verbose - wyswietla output
# --testdox - wyswietla ladniejsze nazwy

"$BASEDIR"/../vendor/bin/phpunit "$@"
