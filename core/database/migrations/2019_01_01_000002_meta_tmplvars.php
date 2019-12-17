<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use EvolutionCMS\Models\Category;
use EvolutionCMS\Models\SiteTmplvar;
use EvolutionCMS\Models\SiteTemplate;
use EvolutionCMS\Models\SiteTmplvarTemplate;

class MetaTmplvars extends Migration
{
    private $tmplvars = [
        ['type' => 'text',         'name' => 'meta_title',       'caption' => 'META title'],
        ['type' => 'textareamini', 'name' => 'meta_description', 'caption' => 'META description'],
        ['type' => 'textareamini', 'name' => 'meta_keywords',    'caption' => 'META keywords'],
        ['type' => 'text',         'name' => 'og_title',         'caption' => 'OpenGraph title'],
        ['type' => 'image',        'name' => 'og_image',         'caption' => 'OpenGraph image'],
        ['type' => 'textareamini', 'name' => 'og_description',   'caption' => 'OpenGraph description'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $category = Category::where('category', 'SEO')->first();

        if (!$category) {
            $category = Category::create(['category' => 'SEO']);
        }

        $tpls = SiteTemplate::all()->pluck('id');

        foreach ($this->tmplvars as $tv) {
            $tv['category'] = $category->id;
            $id = SiteTmplvar::create($tv)->getKey();

            foreach ($tpls as $tpl_id) {
                SiteTmplvarTemplate::create([
                    'tmplvarid'  => $id,
                    'templateid' => $tpl_id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $rows = SiteTmplvar::whereIn('name', array_column($this->tmplvars, 'name'))->get();
        $ids  = $rows->pluck('id')->toArray();

        SiteTmplvar::whereIn('id', $ids)->forceDelete();
        SiteTmplvarTemplate::whereIn('tmplvarid', $ids)->forceDelete();
    }
}
