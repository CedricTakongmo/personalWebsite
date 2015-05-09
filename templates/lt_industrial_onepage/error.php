<?php
/**
 * @package Helix Framework
 * @author LTheme http://www.ltheme.com
 * @copyright Copyright (c) 2010 - 2013 LTheme
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

    defined('_JEXEC') or die;

    $this->helix = Helix::getInstance();

    if (!isset($this->error))
    {
        $this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
        $this->debug = false;
    }
    //get language and direction
    $doc = JFactory::getDocument();
    $this->language = $doc->language;
    $this->direction = $doc->direction;

    $this->helix->getDocument()->setTitle($this->error->getCode() . ' - '.$this->title);

    $this->helix->header()->addLess('error', 'error');

    require_once(JPATH_LIBRARIES.'/joomla/document/html/renderer/head.php');
    $header_renderer = new JDocumentRendererHead($doc);
    $header_contents = $header_renderer->render(null);
	
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"  lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"  lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"  lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $this->language; ?>"> <!--<![endif]-->
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php echo $header_contents; ?>
</head>
<body<?php echo $this->helix->bodyClass('bg clearfix'); ?>>
    <?php 
    // Get default menu - JMenu object, look at JMenu api docs
   /* $menu = $app->getMenu();
    $menu_items = $menu->getItems('menutype', 'mainmenu');
    print_r($menu_items);*/
    ?>
	<div id="error-page" class="container">
		<div>
            <div class="error-content">

            </div>
            <div class="error-content-text">
                <h2>Page not Found</h2>
                <p>The page you are looking for could have been deleted or never have existed*</p>
            </div>
		</div>
        <div class="error-content-text-bottom">
            <p><?php echo JText::_('GO_BACK'); ?> <a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('HOME'); ?>"></i> <?php echo JText::_('HOME'); ?></a></p>
        </div>
	</div>
</body>
</html>