<?php

namespace Drupal\Modifysiteform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Response;


class ModifySiteController extends ControllerBase{
  
  public function description($site_api_key='', $nid=''){
	
	$node_response = new Response(); //create response object
	$node_response->headers->set('Content-Type', 'application/json');
    $read_config = \Drupal::config('siteform.adminsettings'); //To read system variable use immutable config object
    $types = $read_config->get('siteapikey_value'); //Fetch data of welcome_message field from config form
	
	//Check site api key is match with url parameter or not
	
	if($types == $site_api_key){
		$node_details = Node::load($nid); //getting node details
	    //Validating whether the node is exist or not
     	if($node_details != NULL){
			$node_type = $node_details->type->entity->get(type); //Fetching node type from node object
			
			//Check whether node is a cotent of basic page or not
			if($node_type == 'page'){
				
				$t_serialize = \Drupal::service('serializer');  // Initialize serializer service
			    $data = $t_serialize->serialize($node_details, 'json'); // serialize node data in json format   
                $node_response->setContent($data); //set content in response object
			}
			else{
				
				$node_response->setContent(json_encode(array('Access Denied'))); //set 'Access Denied' in response object
			}
		}
        else{
			           	
			$node_response->setContent(json_encode(array('Access Denied'))); //set 'Access Denied' in response object
        }			
    }
	else{
		$node_response->setContent(json_encode(array('Access Denied'))); //set 'Access Denied' in response object
	}
	return $node_response;
  }
}