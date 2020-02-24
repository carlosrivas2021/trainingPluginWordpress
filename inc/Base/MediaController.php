<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;
use Inc\Api\Widgets\MediaWidget;

class MediaController extends BaseController
{

    public function register()
    {

        if (!$this->activated('media_widgets')) {
            return;
        }

        $media_widget = new MediaWidget();

        $media_widget->register();

    }



}
