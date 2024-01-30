<?php 

$config = array(
        'login' => array(
                array(
	                'field' => 'correo',
	                'label' => 'Email',
	                'rules' => 'required|valid_email',
	                'errors' => array(
	                    'required' => 'Se requiere el %s para ingresar',
	                    'valid_email' => 'Debe ser un %s válido',
	                ),
	            ),
	            array(
	                'field' => 'pwd',
	                'label' => 'Password',
	                'rules' => 'required',
	                'errors' => array(
	                	'required' => 'Se requiere el %s para ingresar'
	                )
	            )
        ),
        
);