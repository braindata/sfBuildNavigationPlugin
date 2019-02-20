<?php

/**
 * sfBuildNavigation
 */
class sfBuildNavigation
{
  protected $config = null;
  protected $module = null;
  protected $action = null; 
  protected $items = array();
  protected $area = array();

  public function __construct($context, $navi = "main_navi")
  {
    $this->module = $context->getModuleName();
    $this->action = $context->getActionName();
    $this->route  = $context->getRequest()->getAttribute('sf_route');;
    $this->navi   = $navi;
    
    if ($this->route instanceof sfDoctrineRoute)
      $this->object = $this->route->getObject();
    
    $this->getConfig();
    $this->buildNavigation();
  }

  public function getConfig()
  {
    if($this->config == null)
    {
      if ($config = sfConfig::get('app_sfBuildNavigationPlugin_'.$this->navi))
        $this->config = $config;
    }
    
    return $this->config;
  }
  
  public function getItems()
  {
    return $this->items;
  }

  public function getArea()
  {
    return $this->area;
  }
  
  protected function buildNavigation()
  {
    if ($config = $this->getConfig())
    {
      $this->items = $config['items'];

      foreach ($this->items as $name => $item)
      {
        $item['is_active'] = false;
        
        if (is_array($item['modules']) && in_array($this->module, $item['modules']))
        {
          if (isset($item['param']) && isset($this->object)) {

            foreach ($item['param'] as $data_key => $data_value){
              $method_key = $data_key;
              $method_value = $data_value;
            }

            $method = "get".sfInflector::camelize($method_key);
            $value = call_user_func(array($this->object, $method));
            
            if ($method_value == $value)
              $item['is_active'] = true;

          } else {  
            $item['is_active'] = true;
          }
        }
        
        if (!isset($item['param']))
          $item['param'] = array();
        
        $this->items[$name] = $item;
      }
    }
  }
  
  protected function getCaseForItem($item)
  {
    $case = isset($item['case']) ? $item['case'] : null;
	
    if($case == null)
    {
        $config = $this->getConfig();
        $case = isset($config['_default_case']) ? $config['_default_case'] : null;
    }
	
    return $case;
  }
  
  protected function switchCase($name, $case)
  {
    switch($case)
    {
      case 'ucfirst':
        $name = ucfirst(mb_strtolower($name,'UTF-8'));
        break;
	
	  case 'lcfirst':
        $name = lcfirst(mb_strtolower($name,'UTF-8'));
        break;
      
	  case 'strtolower':
        $name = mb_strtolower($name,'UTF-8');
        break;
		
	  case 'strtoupper':
        $name = mb_strtoupper($name,'UTF-8');
        break;
		
      case 'ucwords':
        $name = ucwords(mb_strtolower($name,'UTF-8'));
        break;
    }
	
	return $name;
  }
  
}
?>