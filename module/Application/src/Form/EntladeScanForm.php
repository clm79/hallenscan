<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class EntladeScanForm extends Form {

    /**
     * Constructor.     
     */
    public function __construct(string $submitValue) {
        // Define form name
        parent::__construct('post-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements($submitValue);
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements(string $submitValue) {
        $this->add([
            'name' => 'barcode',
            'type' => 'text',
            'options' => [
                'label' => 'Barcode',
            ],
        ]);
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => $submitValue,
                'id' => 'submitbutton',
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    protected function addInputFilter() {
        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'barcode',
            'required' => true,
            'filters' => [
                ['name' => \Zend\Filter\StripTags::class],
                ['name' => \Zend\Filter\StringTrim::class],
            ],
        ]);


        $this->setInputFilter($inputFilter);

        return $inputFilter;
    }

}
