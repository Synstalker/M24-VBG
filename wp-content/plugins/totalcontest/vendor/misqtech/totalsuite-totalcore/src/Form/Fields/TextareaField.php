<?php

namespace TotalContestVendors\TotalCore\Form\Fields;
! defined( 'ABSPATH' ) && exit();



use TotalContestVendors\TotalCore\Form\Field as FieldAbstract;
use TotalContestVendors\TotalCore\Helpers\Html;

/**
 * Class TextareaField
 * @package TotalContestVendors\TotalCore\Form\Fields
 */
class TextareaField extends FieldAbstract {

	/**
	 * @return Html
	 */
	public function getInputHtmlElement() {
		$field = new Html(
			'textarea',
			$this->getAttributes(),
			$this->getValue()
		);
		$field->appendToAttribute( 'class', \TotalContestVendors\TotalCore\Application::getInstance()->env( 'slug' ) . '-form-field-input' );

		return $field;
	}

	/**
	 * @return array
	 */
	public function getAttributes() {
		$attributes = array_diff_key( parent::getAttributes(), array_flip( [ 'value', 'type' ] ) );

		return $attributes;
	}

}