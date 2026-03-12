<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Component Locations
    |--------------------------------------------------------------------------
    |
    | This value sets the root directories that will be used to resolve view-
    | based components like single and multi-file components. The make
    | command will use the first directory in this array to add new component
    | files to.
    |
    */

    'component_locations' => [
        resource_path('views/components'),
        resource_path('views/livewire'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Component Namespaces
    |--------------------------------------------------------------------------
    |
    | This value sets default namespaces that will be used to resolve view-
    | based components like single-file and multi-file components. These
    | folders will also be referenced when creating new components via the
    | make command.
    |
    */

    'component_namespaces' => [
        'layouts' => resource_path('views/layouts'),
        'pages' => resource_path('views/pages'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Page Layout
    |--------------------------------------------------------------------------
    |
    | The view that will be used as the layout when rendering a single
    | component as an entire page via `Route::livewire(...)`. The contents
    | of the component are rendered into the layout's $slot.
    |
    */

    'component_layout' => 'layouts::app',

    /*
    |--------------------------------------------------------------------------
    | Lazy Loading Placeholder
    |--------------------------------------------------------------------------
    |
    | Livewire allows you to lazy load components that would otherwise slow down
    | the initial page load. Every component can have a custom placeholder or
    | you can define the default placeholder view for all components below.
    |
    */

    'component_placeholder' => null,

    /*
    |--------------------------------------------------------------------------
    | Make Command
    |--------------------------------------------------------------------------
    |
    | This value determines the default configuration for the artisan make
    | command. You can configure the component type (sfc, mfc, class) and
    | whether to use the high-voltage (⚡) emoji as a prefix in the component
    | name.
    |
    */

    'make_command' => [
        'type' => 'sfc',
        'emoji' => true,
        'with' => [
            'js' => false,
            'css' => false,
            'test' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the root class namespace for Livewire component classes
    | in your application. This value will change where component auto-discovery
    | finds components.
    |
    */

    'class_namespace' => 'App\\Http\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | Class Path
    |--------------------------------------------------------------------------
    |
    | This value is used to specify the path where Livewire component class
    | files are created when running creation commands like `artisan make:livewire`.
    |
    */

    'class_path' => app_path('Http/Livewire'),

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | This value is used to specify where Livewire component Blade templates
    | are stored when running file creation commands like `artisan make:livewire`.
    |
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Livewire stores uploads temporarily before they are stored permanently.
    | Configure this here.
    |
    */

    'temporary_file_upload' => [
        'disk' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK'),
        'rules' => null,
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5,
        'cleanup' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Render On Redirect
    |--------------------------------------------------------------------------
    |
    | This value determines if Livewire will run a component's render() method
    | after a redirect has been triggered.
    |
    */

    'render_on_redirect' => false,

    /*
    |--------------------------------------------------------------------------
    | Legacy Model Binding
    |--------------------------------------------------------------------------
    |
    | Starting in Livewire v3 the magic model-binding behavior is opt-in.
    |
    */

    'legacy_model_binding' => false,

    /*
    |--------------------------------------------------------------------------
    | Auto-inject Frontend Assets
    |--------------------------------------------------------------------------
    |
    | Disable this if you want to manually include @livewireStyles and
    | @livewireScripts in your layout.
    |
    */

    'inject_assets' => true,

    /*
    |--------------------------------------------------------------------------
    | Navigate (SPA mode)
    |--------------------------------------------------------------------------
    |
    | Configure Livewire navigation options.
    |
    */

    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#2299dd',
    ],
];
