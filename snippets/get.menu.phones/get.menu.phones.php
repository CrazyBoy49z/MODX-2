<?php

$parents = $modx->getOption('parents', $scriptProperties);
$parents = explode(',', $parents);

if (empty($parents)) {
    return false;
}

$itemsCount = (int)$modx->getOption('itemsCount', $scriptProperties, 4);

/**
 * Get parent and child resources with tvs
 */
$q = $modx->newQuery('modResource');
$q->leftJoin('modTemplateVarResource', 'menu_popular_services', 'modResource.id = menu_popular_services.contentid AND menu_popular_services.tmplvarid = 92');
$q->leftJoin('modTemplateVarResource', 'menu_popular_problems', 'modResource.id = menu_popular_problems.contentid AND menu_popular_problems.tmplvarid = 93');
$q->leftJoin('modTemplateVarResource', 'brand_series', 'modResource.id = brand_series.contentid AND brand_series.tmplvarid = 80');
$q->leftJoin('modTemplateVarResource', 'model_series', 'modResource.id = model_series.contentid AND model_series.tmplvarid = 81');
$q->select([
    'modResource.id as id',
    'modResource.parent as parent',
    'modResource.pagetitle as pagetitle',
    'modResource.menutitle as menutitle',
    'menu_popular_services.value as services',
    'menu_popular_problems.value as problems',
    'brand_series.value as brand_series',
    'model_series.value as model_series',
]);
$q->where([
    [
        'parent:IN' => $parents,
        'OR:id:IN' => $parents,
    ],
    [
        'published' => true,
        'deleted' => false
    ]
]);
$q->sortby('menuindex', 'asc');

//$q->prepare();
//$sql = $q->toSQL();
//die($sql);

$resources = $modx->getCollection('modResource', $q);

$arResources = [];
$servicesIds = [];
$problemsIds = [];

foreach ($resources as $res) {

    $id = $res->get('id');
    $parent = $res->get('parent');

    if (in_array($id, $parents)) {

        // Parent
        $arResources[$id]['name'] = $res->get('pagetitle');
        $arResources[$id]['url'] = $modx->makeUrl($id);

        $brands = json_decode($res->get('brand_series'));
        foreach ($brands as $brand) {
            $arResources[$id]['series'][$brand->MIGX_id] = $brand->name;
        }

    } else {

        // Resource
        if (!empty($res->get('model_series'))) {

            $series = $res->get('model_series');

            $services = array_slice(explode('||', $res->get('services')), 0, $itemsCount);
            $problems = array_slice(explode('||', $res->get('problems')), 0, $itemsCount);

            $arResources[$parent]['items'][$series][$id] = [
                'name' => $res->get('menutitle'),
                'url' => $modx->makeUrl($id),
                'services' => !empty($services[0]) ? $services : [],
                'problems' => !empty($problems[0]) ? $problems : [],
            ];

            $servicesIds = array_merge($servicesIds, $arResources[$parent]['items'][$series][$id]['services']);
            $problemsIds = array_merge($problemsIds, $arResources[$parent]['items'][$series][$id]['problems']);
        }
    }
}


/**
 * Get all popular service resources
 */
$c = $modx->newQuery('modResource');
$c->select([
    'modResource.id as id',
    'modResource.longtitle as longtitle',
    'modResource.menutitle as menutitle'
]);
$c->where([
    'published' => true,
    'deleted' => false,
    'id:IN' => $servicesIds
]);
$resources = $modx->getCollection('modResource', $c);

$arServices = [];
foreach ($resources as $res) {
    $id = $res->get('id');
    $arServices[$id] = [
        'name' => !empty($res->get('menutitle')) ? $res->get('menutitle') : $res->get('longtitle'),
        'url' => $modx->makeUrl($id)
    ];
}


/**
 * Get all popular problems resources
 */
$c = $modx->newQuery('modResource');
$c->select([
    'modResource.id as id',
    'modResource.longtitle as longtitle',
    'modResource.menutitle as menutitle'
]);
$c->where([
    'published' => true,
    'deleted' => false,
    'id:IN' => $problemsIds
]);
$resources = $modx->getCollection('modResource', $c);

$arProblems = [];
foreach ($resources as $res) {
    $id = $res->get('id');
    $arProblems[$id] = [
        'name' => !empty($res->get('menutitle')) ? $res->get('menutitle') : $res->get('longtitle'),
        'url' => $modx->makeUrl($id)
    ];
}


/**
 * Templating
 */
$tplOuterChunk = $modx->getOption('tplOuter', $scriptProperties, '');
$tpInnerChunk = $modx->getOption('tplInner', $scriptProperties, '');
$tplChunk = $modx->getOption('tpl', $scriptProperties, '');

$innerClass = $modx->getOption('innerClass', $scriptProperties, '');
$default = $modx->getOption('default', $scriptProperties, '');

$tplOuter = parseChunk($tplOuterChunk);
$tplInner = parseChunk($tpInnerChunk);
$tpl = parseChunk($tplChunk);

$brands = '';
$series = '';
$models = '';
$services = '';
$problems = '';


foreach ($arResources as $parentId => $arParent) {

    $brands .= $tplChunk->process([
        'parent' => $parentId,
        'id' => $parentId,
        'url' => $arParent['url'],
        'name' => $arParent['name']
    ], $tpl);

    foreach ($arParent['items'] as $seriesId => $arModels) {

        $series .= $tplChunk->process([
            'parent' => $parentId,
            'id' => $parentId . '-' . $seriesId,
            'url' => '/' . $arParent['url'] . '#model_list',
            'name' => !empty($arParent['series'][$seriesId]) ? $arParent['series'][$seriesId] : ''
        ], $tpl);

        foreach ($arModels as $modelId => $arModel) {

            $models .= $tplChunk->process([
                'parent' => $parentId . '-' . $seriesId,
                'id' => $modelId,
                'url' => '/' . $arModel['url'],
                'name' => $arModel['name']
            ], $tpl);

            if (!empty($arServices)) {
                foreach ($arModel['services'] as $serviceID) {
                    if (isset($arServices[$serviceID])) {
                        $services .= $tplChunk->process([
                            'parent' => $modelId,
                            'id' => $serviceID,
                            'url' => $arServices[$serviceID]['url'],
                            'name' => $arServices[$serviceID]['name']
                        ], $tplInner);
                    }
                }
            }

            if (!empty($arProblems)) {
                foreach ($arModel['problems'] as $problemID) {
                    if (isset($arProblems[$problemID])) {
                        $problems .= $tplChunk->process([
                            'parent' => $modelId,
                            'id' => $problemID,
                            'url' => $arProblems[$problemID]['url'],
                            'name' => $arProblems[$problemID]['name']
                        ], $tplInner);
                    }
                }
            }
        }
    }
}

// Бренды
$brand_inner = $tpInnerChunk->process([
    'section' => 'Бренд',
    'wrapper' => $brands,
    'inner_class' => '',
], $tplInner);

$output = $tplOuterChunk->process(['wrapper' => $brand_inner], $tplOuter);

// Ленейки
$series_inner = $tpInnerChunk->process([
    'section' => 'Линейка',
    'wrapper' => $series,
    'inner_class' => $innerClass
], $tplInner);

$output .= $tplOuterChunk->process(['wrapper' => $series_inner], $tplOuter);

// Модели
$models_inner = $tpInnerChunk->process([
    'section' => 'Модель',
    'wrapper' => $models,
    'inner_class' => $innerClass
], $tplInner);

$output .= $tplOuterChunk->process(['wrapper' => $models_inner], $tplOuter);

// Популярные услуги
$service_inner = $tpInnerChunk->process([
    'section' => 'Популярные услуги',
    'wrapper' => $services,
    'inner_class' => $innerClass
], $tplInner);

// Популярные поломки
$problems_inner = $tpInnerChunk->process([
    'section' => 'Популярные поломки',
    'wrapper' => $problems,
    'inner_class' => $innerClass
], $tplInner);

$output .= $tplOuterChunk->process(['wrapper' => $service_inner . $problems_inner . $default], $tplOuter);

/**
 * parseChunk
 * @param $tpl
 * @return bool|mixed
 */
if (!function_exists('parseChunk')) {
    function parseChunk(&$tpl)
    {
        $modx = new modX();
        if (stristr($tpl, '@INLINE') !== false) {
            $text = str_replace('@INLINE', '', $tpl);
            $uniqid = uniqid();
            $tpl = $modx->newObject('modChunk', array('name' => "{tmp}-{$uniqid}"));
        } else {
            $text = false;
            $tpl = $modx->getParser()->getElement('modChunk', $tpl);
            $tpl->_processed = false;
        }
        $tpl->setCacheable(false);
        return $text;
    }
}

return $output;