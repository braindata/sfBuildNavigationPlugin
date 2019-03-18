<?php

/**
 * @package    sfOrmBreadcrumbsPlugin
 * @subpackage modules
 * @author     Nicolò Pignatelli <info@nicolopignatelli.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BasesfBuildNavigationComponents extends sfComponents
{
  public function executeNavigation(sfWebRequest $request)
  {
    $module = $this->getContext()->getModuleName();
    $action = $this->getContext()->getActionName();

    if ($request->hasParameter('scope')){
      $this->scope = $request->getParameter('scope');
    } else {
      $this->scope = null;
    }

    $this->navigation = new sfBuildNavigation($module, $action, $this->scope, $this->navi);

    $this->items = $this->navigation->getItems();
    $this->area = $this->navigation->getArea();

    $this->style = "";
  }
}