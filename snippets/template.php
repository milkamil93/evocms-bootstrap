<?php

$template = \EvolutionCMS\Models\SiteTemplate::where('id', $modx->documentObject['template'])->first();

if ($template) {
    return $template['templatealias'] . '-page';
}
