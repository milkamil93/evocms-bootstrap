<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use EvolutionCMS\Models\SiteTemplate;

class Templates extends Migration
{
    private $templates = [
        ['templatealias' => 'main',     'templatename' => 'Главная'],
        ['templatealias' => 'info',     'templatename' => 'По умолчанию'],
        ['templatealias' => 'newslist', 'templatename' => 'Список новостей'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SiteTemplate::truncate();

        foreach ($this->templates as $tpl) {
            SiteTemplate::create($tpl);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SiteTemplate::truncate();
    }
}
