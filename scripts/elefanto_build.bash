#!/bin/bash

ROOT_PATH="`dirname \"$0\"`"
ROOT_PATH=$(readlink -f $ROOT_PATH)
ROOT_PATH=$(dirname "$ROOT_PATH")
VENDOR_PATH=$ROOT_PATH/vendor
VENDOR_BIN=$VENDOR_PATH/bin
REPORT_PATH=$ROOT_PATH/report

# APIGEN CONF
DOC_TITLE="Elefanto Framework"

# CHECK IF vendor EXISTS
if [ ! -d "$VENDOR_PATH" ]; then
    echo "Error: The path $ROOT_PATH/vendor doesn't exists."
    exit
fi

# CHECK IF report EXISTS
if [ ! -d "$REPORT_PATH" ]; then
    mkdir -p $REPORT_PATH/doc $REPORT_PATH/coverage
fi


# RUN BUILDER
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
