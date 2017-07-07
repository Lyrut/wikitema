<?php

namespace Authentification\Form;

use Authentification\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;
use Zend\Validator\Regex;

class UserForm extends Form {

    /**
     * Scenario ('create' or 'update').
     * @var string 
     */
    private $scenario;

    /**
     * Entity manager.
     * @var EntityManager 
     */
    private $entityManager = null;

    /**
     * Current user.
     * @var User 
     */
    private $user = null;

    /**
     * Constructor.     
     */
    public function __construct($scenario = 'create', $entityManager = null, $user = null, $roles = []) {
        // Define form name
        parent::__construct('user-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->user = $user;

        $this->addElements($roles);
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements($roles) {
        
        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 300
                ]
            ],
        ]);
        
        // Add "email" field
        $this->add([
            'type' => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'E-mail',
            ],
        ]);
        
        // Add "pseudo" field
        $this->add([
            'type' => 'text',
            'name' => 'pseudo',
            'options' => [
                'label' => 'Pseudo',
            ],
        ]);

        // Add "full_name" field
        $this->add([
            'type' => 'text',
            'name' => 'full_name',
            'options' => [
                'label' => 'Full Name',
            ],
        ]);

        if ($this->scenario == 'create') {

            // Add "password" field
            $this->add([
                'type' => 'password',
                'name' => 'password',
                'options' => [
                    'label' => 'Password',
                ],
            ]);

            // Add "confirm_password" field
            $this->add([
                'type' => 'password',
                'name' => 'confirm_password',
                'options' => [
                    'label' => 'Confirm password',
                ],
            ]);
        }
        
        // Add "select_role" field
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'select_role',
            'options' => [
                    'label' => 'Select role',
                    'value_options' => $roles
                ],
        ));

        // Add the Submit button
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Créer'
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "email" field
        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 128
                    ],
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/[a-z\d]+([\.\_]?[a-z\d]+)+@(hitema)(\.com)/i',
                        'messages' =>  [
                            Regex::INVALID => 'Invalid input, only a-z, 0-9 & - _ . characters allowed',
                            Regex::NOT_MATCH => "Le mail n'est pas valide, veuillez vérifier que votrre mail correspond au mail d'Hitema",
                        ],
                    ],
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => Hostname::ALLOW_DNS,
                        'useMxCheck' => false,
                    ],
                ],
            ],
        ]);
        
        if ($this->scenario == 'create') {

            // Add input for "password" field
            $inputFilter->add([
                'name' => 'password',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags']
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 6,
                            'max' => 64
                        ],
                    ],
                ],
            ]);

            // Add input for "confirm_password" field
            $inputFilter->add([
                'name' => 'confirm_password',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags']
                ],
                'validators' => [
                    [
                        'name' => 'Identical',
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
            ]);
        }
    }

}
