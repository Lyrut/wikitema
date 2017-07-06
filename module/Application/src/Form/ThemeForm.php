<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

class ThemeForm extends Form {

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager = null;

    /**
     * Current theme.
     * @var Application\Entity\Theme 
     */
    private $theme = null;

    /**
     * Constructor.     
     */
    public function __construct($entityManager = null, $theme = null) {
        // Define form name
        parent::__construct('theme-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->entityManager = $entityManager;
        $this->theme = $theme;

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() {
        // Add "email" field
        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Nom',
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Envoyer'
            ],
        ]);

        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 300
                ]
            ],
        ]);
    }

    private function addInputFilter() {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "name" field
        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 128
                    ],
                ],
            ],
        ]);
    }

}

