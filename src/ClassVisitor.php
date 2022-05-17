<?php

namespace Changwoo\SearchReplace;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class ClassVisitor extends NodeVisitorAbstract {
	private array $classes = [];

	public function leaveNode( Node $node ) {
		$this->findClass( $node );
	}

	public function getClasses(): array {
		return $this->classes;
	}

	private function findClass( Node $node ) {
		if ( $node instanceof Node\Stmt\Class_ ) {
			$name = $node->name;

			$this->classes[] = [ $name->getAttribute( 'startFilePos' ), $name->name ];
		}
	}
}