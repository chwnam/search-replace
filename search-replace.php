#!/usr/bin/env php
<?php

use Changwoo\SearchReplace\ClassVisitor;
use Changwoo\SearchReplace\FunctionCallVisitor;
use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\Lexer;

require_once __DIR__ . '/vendor/autoload.php';

if ( PHP_SAPI !== 'cli' ) {
	die( 'This is a CLI script.' );
}

ini_set( 'xdebug.max_nesting_level', 3000 );

$lexer  = new Lexer\Emulative( [ 'usedAttributes' => [ 'startFilePos' ] ] );
$parser = ( new ParserFactory() )->create( ParserFactory::PREFER_PHP7, $lexer );
$code   = file_get_contents( __DIR__ . '/test/translations.php' );

if ( $code ) {
	try {
		$nodes       = $parser->parse( $code );
		$traverser   = new NodeTraverser();
		$clsVisitor  = new ClassVisitor();
		$funcVisitor = new FunctionCallVisitor();

		$traverser->addVisitor( $clsVisitor );
		$traverser->addVisitor( $funcVisitor );
		$traverser->traverse( $nodes );

		foreach ( $funcVisitor->getTextDomains() as [$offset, $value] ) {
			$extracted = substr( $code, $offset, strlen( $value ) );
			echo $extracted . PHP_EOL;
		}

		foreach ( $clsVisitor->getClasses() as [$offset, $value] ) {
			$extracted = substr( $code, $offset, strlen( $value ) );
			echo $extracted . PHP_EOL;
		}
	} catch ( Error $e ) {
		die( 'Parser error: ' . $e->getMessage() );
	}
}