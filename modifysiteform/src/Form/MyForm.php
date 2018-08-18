<?php

namespace Drupal\Modifysiteform\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

//ConfigFormBase is a base class that is used to implement system configuration forms.

class MyForm extends ConfigFormBase{
	
	//gets the configuration name
	
    protected function getEditableconfigNames(){
	    return[
		'siteform.adminsettings',
		];
	}
	
	//returns the form’s unique ID
	
	public function getFormId(){
	   return 'welcome_form';
	}
	
	//returns the form array
	
	public function buildForm(array $form, FormStateInterface $form_state){
		
		//This initialises the config variable. siteform.adminsettings is the module's configuration name, so this will load the admin settings.
		$config = $this->config('siteform.adminsettings');
		
		//one element to this form, the welcome message textarea
		$form['siteapikey_value'] = [
		   '#type' => 'textfield',
		   '#title'=> $this->t('Site Api Key Value'),
		   '#description' => $this->t('Site Api Key Value Exist In the System'),
		   //The default value is returned from the configuration object. It calls the get() method with the name of the property to get, which is siteapikey_value. You will add the code to save this when the form saves shortly.
		   '#default_value' => $config->get('siteapikey_value'),
		];
		return parent::buildForm($form, $form_state);
	}
	
	public function submitForm(array &$form, FormStateInterface $form_state) {  
		parent::submitForm($form, $form_state);  
        //$this is the admin settings form class.
		$this->config('siteform.adminsettings') //siteform.adminsettings is the name of the module's configuration.
		  ->set('siteapikey_value', $form_state->getValue('siteapikey_value'))  
		  ->save();  
    }
	
	
}