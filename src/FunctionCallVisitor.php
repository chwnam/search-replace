<?php

namespace Changwoo\SearchReplace;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class FunctionCallVisitor extends NodeVisitorAbstract {
	private array $textdomains = [];

	public function leaveNode( Node $node ) {
		$this->findTextDomains( $node );
	}

	public function getTextDomains(): array {
		return $this->textdomains;
	}

	public function findTextDomains( Node $node ) {
		if (
			$node instanceof Node\Expr\FuncCall &&
			(
				(
					2 === count( $node->args ) &&
					in_array( $node->name->parts[0], [
						'__',
						'_e',
						'esc_attr__',
						'esc_attr_e',
						'esc_html__',
						'esc_html_e',
					], true )
				) ||
				(
					3 === count( $node->args ) &&
					in_array( $node->name->parts[0], [ '_ex', '_n_noop', '_x', 'esc_attr_x', 'esc_html_x' ], true )
				) ||
				(
					4 === count( $node->args ) &&
					in_array( $node->name->parts[0], [ '_n', '_nx_loop' ], true )
				) ||
				(
					5 === count( $node->args ) &&
					$node->name->parts[0] === '_nx'
				)
			)
		) {
			$arg = $node->args[ count( $node->args ) - 1 ];

			if ( $arg->value instanceof Node\Scalar\String_ ) {
				$this->textdomains[] = [
					$arg->getAttribute( 'startFilePos' ) + 1, // String is enclosed with quotation marks.
					$arg->value->value,
				];
			}
		}
	}
}