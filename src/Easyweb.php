<?php

namespace fklavye\easyweb;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use fklavye\easyweb\models\Settings;
use fklavye\easyweb\services\FieldService;

/**
 * Easyweb plugin
 *
 * @method static Easyweb getInstance()
 * @method Settings getSettings()
 * @author Fklavye <support@fklavye.net>
 * @copyright Fklavye
 * @license https://craftcms.github.io/license/ Craft License
 */
class Easyweb extends Plugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                'fields' => FieldService::class, // Register the service here
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        // Safe to use Craft services here after app init
        Craft::$app->onInit(function () {
            // You can defer code here if needed
        });
    }

    public function install(): bool
    {
        $installed = parent::install();

        if ($installed) {
            // Call the service to create the field on install
            $this->fields->createPlainTextField();
        }

        return $installed;
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('easyweb/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
    }
}
