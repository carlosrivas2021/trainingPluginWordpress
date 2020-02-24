<?php

/**
 * @package CRivasPlugin
 */

namespace Inc;

final class Init
{
    public static function get_services()
    {
        return [
            Pages\Dashboard::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\CustomPostTypeController::class,
            Base\CustomTaxonomyController::class,
            Base\GalleryController::class,
            Base\MediaController::class,
            Base\TestimonialController::class,
            Base\TemplateController::class,
            Base\LoginController::class,
            Base\MembershipsController::class,
            Base\ChatsController::class,
        ];
    }

    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    private static function instantiate($class)
    {
        return new $class();
    }
}
