#!/bin/bash

ROOT_PATH="`dirname \"$0\"`"
ROOT_PATH=$(readlink -f $ROOT_PATH)
ROOT_PATH=$(dirname "$ROOT_PATH")
VENDOR_PATH=$ROOT_PATH/vendor
VENDOR_BIN=$VENDOR_PATH/bin
REPORT_PATH=$ROOT_PATH/report

# APIGEN CONF
DOC_TITLE="Elefanto Framework"


cd $ROOT_PATH

echo ""
echo -e "\033[1m\033[46m Elefanto Builder \033[0m"
echo ""

echo "Start unit test..."
echo ""
$VENDOR_BIN/phpunit --coverage-html=$REPORT_PATH/coverage

echo ""
echo "Documentation generation..."
echo ""
apigen --source $ROOT_PATH --exclude "*/tests/*,*/vendor/*,*/.git/*" --destination $REPORT_PATH/doc --todo no --title $DOC_TITLE --php no --download yes

echo ""
echo "Start PHP CodeSniffer..."
echo ""
phpcs --standard=PSR2 $ROOT_PATH/src

echo "Elefanto Builder done."
echo ""
