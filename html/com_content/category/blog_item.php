<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;?>
<?php
// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$canEdit = $this->item->params->get('access-edit');
JHtml::_('behavior.framework');
$layoutPath = JPATH_ROOT . '/templates/' . $template .'/layouts/';

?>
<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
	<div class="system-unpublished">
<?php endif; ?>

<?php $header = new JLayoutFile('content.article.header', $layoutPath);  ?>
<?php echo $header->render(
		array(
			'item' => $this->item, 
			'params' => $params,
			'print' => false,
			'position' => 'above'
		)
	); 
?>

<?php // Todo Not that elegant would be nice to group the params ?>
<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') ); ?>

<?php if ($useDefList) : ?>
	<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
<?php endif; ?>

<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>

<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>
<?php echo $this->item->event->beforeDisplayContent; ?> <?php echo $this->item->introtext; ?>

<?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	else :
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
		$link = new JUri($link1);
		$link->setVar('return', base64_encode($returnURL));
	endif; ?>

	<p class="readmore"><a class="btn btn-lg btn-primary" href="<?php echo $link; ?>">

	<?php if (!$params->get('access-view')) :
		echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE') . "&nbsp;&nbsp;&#10093;";
	elseif ($readmore = $this->item->alternative_readmore) :
		echo $readmore;
		if ($params->get('show_readmore_title', 0) != 0) :
		echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit')). "&nbsp;&nbsp;&#10093;";
		endif;
	elseif ($params->get('show_readmore_title', 0) == 0) :
		echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE') . "&nbsp;&nbsp;&#10093;";
	else :
		echo JText::_('COM_CONTENT_READ_MORE');
		echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit')) . "&nbsp;&nbsp;&#10093;";
	endif; ?>

	</a></p>

<?php endif; ?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>