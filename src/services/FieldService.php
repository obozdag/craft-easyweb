<?php

namespace fklavye\easyweb\services;

use Craft;
use craft\base\Component;
use craft\fields\PlainText;
use craft\models\FieldGroup;

class FieldService extends Component
{
    public function createPlainTextField(): void
    {
        $fieldsService = Craft::$app->getFields();

        // Avoid creating if it already exists
        if ($fieldsService->getFieldByHandle('plainText')) {
            Craft::info('Field "plainText" already exists.', __METHOD__);
            return;
        }

        // Find or create the field group
        $group = $fieldsService->getGroupByHandle('easywebFields');
        if (!$group) {
            $group = new FieldGroup();
            $group->name = 'Easyweb Fields';
            if (!$fieldsService->saveGroup($group)) {
                Craft::error('Failed to create field group.', __METHOD__);
                return;
            }
        }

        // Create the Plain Text field
        $field = new PlainText();
        $field->groupId = $group->id;
        $field->name = 'Plain Text';
        $field->handle = 'plainText';
        $field->instructions = 'Created by the Easyweb plugin.';
        $field->multiline = false;

        if ($fieldsService->saveField($field)) {
            Craft::info('Plain Text field created.', __METHOD__);
        } else {
            Craft::error('Could not save Plain Text field.', __METHOD__);
        }
    }
}
