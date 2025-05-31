<?php

namespace OpenAdmin\Admin\Quill;

use Illuminate\Support\ServiceProvider;
use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Form;

class QuillServiceProvider extends ServiceProvider
{
    public $public_path = 'vendor/open-admin-ext/quill/';

    /**
     * @inheritdoc
     */
    public function boot(QuillExtention $extension)
    {
        if (!QuillExtention::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'open-admin-quill');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [
                    $assets => public_path($this->public_path),
                ],
                'open-admin-quill'
            );
        }

        Admin::booting(function () {
            Admin::js($this->public_path.'quill.js');
            Admin::css($this->public_path.'quill.snow.css');
            Admin::css($this->public_path.'quill.open-admin-form.css');
            Form::extend('quill', QuillField::class);
        });
    }
}
