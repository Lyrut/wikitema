<?php

namespace Authentification\Form;

use Authentification\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;
use Zend\Validator\Regex;

class LoginForm extends Form {

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
    public function __construct($entityManager = null, $user = null) {
        // Define form name
        parent::__construct('login-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->entityManager = $entityManager;
        $this->user = $user;

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
            'name' => 'email',
            'options' => [
                'label' => 'E-mail',
            ],
        ]);

        // Add "password" field
        $this->add([
            'type' => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Login'
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
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => Hostname::ALLOW_DNS,
                        'useMxCheck' => false,
                    ],
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/[a-z\d]+([\.\_]?[a-z\d]+)+@(hitema)(\.com)/i',
                        'messages' =>  [
                            Regex::INVALID => 'Invalid input, only a-z, 0-9 & - _ . characters allowed',
                            Regex::NOT_MATCH => "Le mail n'est pas valide, veuillez vérifier que votre mail correspond au mail d'Hitema",
                        ],
                    ],
                ],
            ],
        ]);

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
    }

}
