#!/bin/bash
#
# Elefanto Pear Builder
#
# Automating integration testing continues.

# GLOBAL CONF
ROOT_PATH="`dirname \"$0\"`"
ROOT_PATH=$(readlink -f $ROOT_PATH)
ROOT_PATH=$(dirname "$ROOT_PATH")
REPORT_PATH=$ROOT_PATH/report
PHPUNIT_BIN=/usr/bin/phpunit
APIGEN_BIN=/usr/bin/apigen
PHPCS_BIN=/usr/bin/phpcs

# APIGEN CONF
DOC_TITLE="Elefanto Framework"
APIGEN_EXCLUDE_FILES="*/tests/*,*/vendor/*,*/.git/*"

# CHECK IF report EXISTS
if [ ! -d "$REPORT_PATH" ]; then
    mkdir -p $REPORT_PATH/doc $REPORT_PATH/coverage
fi

#
# RUN BUILDER
#
cd $ROOT_PATH

echo ""
echo "+-----------------------+"
echo "| ELEFANTO PEAR BUILDER |"
echo "+-----------------------+"
echo ""

#
# PHPUNIT TEST
#
echo "Start unit test..."
echo ""
if [ ! -f "$PHPUNIT_BIN" ]; then
    echo "PHPUnit not found or not installed."
    echo "  pear channel-discover pear.phpunit.de"
    echo "  pear install --alldeps phpunit/PHPUnit"
else
    $PHPUNIT_BIN --coverage-html=$REPORT_PATH/coverage
fi

#
# APIGEN GENERATOR
#
echo ""
echo "Documentation generation..."
echo ""
if [ ! -f "$APIGEN_BIN" ]; then
    echo "Apigen not found or not installed."
    echo "  pear config-set auto_discover 1"
    echo "  pear install pear.apigen.org/apigen"
    echo ""
    echo "  http://apigen.org/##installation"
else
    $APIGEN_BIN --source $ROOT_PATH --exclude $APIGEN_EXCLUDE_FILES --destination $REPORT_PATH/doc --todo no --title $DOC_TITLE --php no --download yes
fi

#
# PHP CODE SNIFFER
#
echo ""
echo "Start PHP CodeSniffer..."
echo ""
if [ ! -f "$PHPCS_BIN" ]; then
    echo "PHP CodeSniffer not found or not installed."
    echo "  pear install PHP_CodeSniffer"
    echo ""
else
    $PHPCS_BIN --report=summary --standard=PSR2 -p $ROOT_PATH/src
fi

echo ""
echo "Elefanto Builder done."
echo ""

