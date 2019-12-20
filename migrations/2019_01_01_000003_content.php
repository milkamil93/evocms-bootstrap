<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use EvolutionCMS\Models\SiteContent;
use EvolutionCMS\Models\SystemSetting;

class Content extends Migration
{
    private $content = [
        [
            'id'            => 1,
            'pagetitle'     => 'Контент',
            'alias'         => 'content',
            'published'     => 1,
            'isfolder'      => 1,
            'hidemenu'      => 1,
            'alias_visible' => 0,
        ], [
            'id'        => 2,
            'pagetitle' => 'Главная',
            'alias'     => 'index',
            'published' => 1,
            'parent'    => 1,
            'template'  => 1,
        ], [
            'id'        => 4,
            'pagetitle' => '404',
            'alias'     => '404',
            'published' => 1,
            'content'   => '<p>Страница не найдена!</p>',
            'template'  => 2,
            'menuindex' => 1003,
            'hidemenu'  => 1,

        ],
    ];

    private $settings = [
        'site_start'               => 2,
        'error_page'               => 3,
        'unauthorized_page'        => 3,
        'default_template'         => 2,
        'auto_template_logic'      => 'sibling',
        'friendly_url_suffix'      => '/',
        'global_tabs'              => 0,
        'manager_theme_mode'       => 2,
        'login_form_position'      => 'center',
        'tinymce4_theme'           => 'full',
        'tinymce4_custom_buttons1' => 'undo redo | cut copy paste | searchreplace | fontsizeselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent blockquote | forecolor backcolor | styleselect',
        'tinymce4_custom_plugins'  => 'advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen spellchecker insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor codesample colorpicker textpattern imagetools paste modxlink youtube',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SiteContent::truncate();

        foreach ($this->content as $row) {
            SiteContent::create($row);
        }

        foreach ($this->settings as $name => $value) {
            SystemSetting::where('setting_name', $name)->update(['setting_value' => $value]);
        }

        EvolutionCMS()->clearCache('full');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SiteContent::truncate();
    }
}
