<?php 
/**
 * @package     thatlean
 *
 * @copyright   Copyright (C) 2014 Justin Renaud (tghidsgn.com)
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);
JHtml::_('behavior.caption');
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author'));

?>
<article>
	<div class="article<?php echo $this->pageclass_sfx?>">
		<header>
			<div class="article-header">
				<?php if (isset($images->image_fulltext) && !empty($images->image_fulltext)) : ?>
				<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
				<div class="article-image skrollable unrendered">
					<img data-start="top:0px" data--480-top="top:-100px"  
					<?php if ($images->image_fulltext_caption):
					echo 'class="caption"'.' title="' .htmlspecialchars($images->image_fulltext_caption) . '"';
					endif; ?>
					src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/>
				</div>
				<?php endif; ?>
				<?php if ($params->get('show_title') || $params->get('show_author')) : ?>
				<div class="article-title container">
					<h1 data-start="opacity:1;bottom:15px" data--480-top="opacity:0;bottom:0">
						<?php if ($params->get('show_title')) : ?>
							<?php echo $this->escape($this->item->title); ?>
						<?php endif; ?>
					</h1>
					<?php if ($this->item->state == 0) : ?>
					<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
					<?php endif; ?>
					<?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
					<span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
					<?php endif; ?>
					<?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00') : ?>
					<span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		<?php
			if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative){
				echo $this->item->pagination;
			}
		?>
		<?php if (!$useDefList && $this->print) : ?>
			<div id="pop-print" class="btn hidden-print">
				<?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
			</div>
			<div class="clearfix"> </div>
		<?php endif; ?>
		<?php if (!$this->print) : ?>
			<?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
			<div class="btn-group pull-right">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <span class="icon-cog"></span> <span class="caret"></span> </a>
				<?php // Note the actions class is deprecated. Use dropdown-menu instead. ?>
				<ul class="dropdown-menu actions">
					<?php if ($params->get('show_print_icon')) : ?>
					<li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $this->item, $params); ?> </li>
					<?php endif; ?>
					<?php if ($params->get('show_email_icon')) : ?>
					<li class="email-icon"> <?php echo JHtml::_('icon.email', $this->item, $params); ?> </li>
					<?php endif; ?>
					<?php if ($canEdit) : ?>
					<li class="edit-icon"> <?php echo JHtml::_('icon.edit', $this->item, $params); ?> </li>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
		<?php else : ?>
			<?php if ($useDefList) : ?>
				<div id="pop-print" class="btn hidden-print">
					<?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
			<div class="article-info muted">
				<dl class="article-info-list">
				<dt class="article-info-term"></dt>
				<?php if ($params->get('show_publish_date')) : ?>
					<dd class="published">
						<span class="icon-calendar"></span> <?php echo JHtml::_('date', $this->item->publish_up, 'l, F d Y'); ?>
					</dd>
				<?php endif; ?>

				<?php if ($info == 0) : ?>
					<?php if ($params->get('show_modify_date')) : ?>
						<dd class="modified">
							<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, 'l, F d Y')); ?>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_create_date')) : ?>
						<dd class="create">
							<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $this->item->created, 'l, F d Y')); ?> 
						</dd>
					<?php endif; ?>

					<?php if ($params->get('show_hits')) : ?>
						<dd class="hits">
							<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
						</dd>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
					<dd class="createdby">
						<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
						<?php if (!empty($this->item->contact_link) && $params->get('link_author') == true) : ?>
							<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $this->item->contact_link, $author)); ?>
						<?php else: ?>
							<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
						<?php endif; ?>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_parent_category') && !empty($this->item->parent_slug)) : ?>
					<dd class="parent-category-name">
						<?php $title = $this->escape($this->item->parent_title);
						$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';?>
						<?php if ($params->get('link_parent_category') && !empty($this->item->parent_slug)) : ?>
							<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
						<?php else : ?>
							<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
						<?php endif; ?>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_category')) : ?>
					<dd class="category-name">
						<?php $title = $this->escape($this->item->category_title);
						$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)) . '">' . $title . '</a>';?>
						<?php if ($params->get('link_category') && $this->item->catslug) : ?>
							<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
						<?php else : ?>
							<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
						<?php endif; ?>
					</dd>
				<?php endif; ?>
				</dl>
			</div>
		<?php endif; ?>

		<?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
			<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>

			<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
		<?php endif; ?>

		<?php if (!$params->get('show_intro')) : echo $this->item->event->afterDisplayTitle; endif; ?>
		<?php echo $this->item->event->beforeDisplayContent; ?>

		<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position)))
			|| (empty($urls->urls_position) && (!$params->get('urls_position')))) : ?>
		<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>
		<?php if ($params->get('access-view')):?>
		<?php
		if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative):
			echo $this->item->pagination;
		endif;
		?>
		<?php if (isset ($this->item->toc)) :
			echo $this->item->toc;
		endif; ?>
	</header>
	<div class="article">
		<?php echo $this->item->text; ?>
	</div>
	<?php
if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative):
	echo $this->item->pagination;
?>
	<?php endif; ?>
	<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
	<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>
	<?php // Optional teaser intro text for guests ?>
	<?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
	<?php echo $this->item->introtext; ?>
	<?php //Optional link to let them register to see the whole article. ?>
	<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
		$link1 = JRoute::_('index.php?option=com_users&view=login');
		$link = new JUri($link1);?>
	<p class="readmore">
		<a href="<?php echo $link; ?>">
		<?php $attribs = json_decode($this->item->attribs); ?>
		<?php
		if ($attribs->alternative_readmore == null) :
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
		elseif ($readmore = $this->item->alternative_readmore) :
			echo $readmore;
			if ($params->get('show_readmore_title', 0) != 0) :
				echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
			endif;
		elseif ($params->get('show_readmore_title', 0) == 0) :
			echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
		else :
			echo JText::_('COM_CONTENT_READ_MORE');
			echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
		endif; ?>
		</a>
	</p>
	<?php endif; ?>
	<?php endif; ?>
	<?php
if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
	echo $this->item->pagination;
?>
	<?php endif; ?>
	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
</article>