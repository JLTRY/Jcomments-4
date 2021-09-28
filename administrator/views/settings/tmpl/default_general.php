<?php
/**
 * JComments - Joomla Comment System
 *
 * @version 3.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2013 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;
?>
<div class="row-fluid">
	<div class="span6">
		<fieldset class="options-form">
			<legend><?php echo Text::_('A_CATEGORIES'); ?></legend>
            <?php foreach ($this->form->getFieldset('categories') as $field) : ?>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $field->label; ?>
                    </div>
                    <div class="controls">
                        <?php echo $field->input; ?>
                    </div>
                </div>
            <?php endforeach; ?>
		</fieldset>
		<fieldset class="options-form">
			<legend><?php echo Text::_('A_MISC'); ?></legend>
            <?php foreach ($this->form->getFieldset('misc') as $field) : ?>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $field->label; ?>
                    </div>
                    <div class="controls">
                        <?php echo $field->input; ?>
                    </div>
                </div>
            <?php endforeach; ?>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="options-form">
			<legend><?php echo Text::_('A_NOTIFICATIONS'); ?></legend>
			<?php foreach ($this->form->getFieldset('notifications') as $field) : ?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label; ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</fieldset>
		<fieldset class="options-form">
			<legend><?php echo Text::_('A_REPORTS'); ?></legend>
			<?php foreach ($this->form->getFieldset('reports') as $field) : ?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label; ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</fieldset>
	</div>
</div>
