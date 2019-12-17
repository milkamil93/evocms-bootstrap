<?php

namespace EvolutionCMS\Bootstrap;

class FormsDispatcher
{
    private $result = [];

    public function __construct()
    {

    }

    public function process($data)
    {
        $this->result = ['response' => 'fail'];

        if (!(!empty($data['formid']) && is_string($data['formid']) && preg_match('/^[a-z]{2,32}$/', $data['formid']))) {
            return false;
        }

        $evo = EvolutionCMS();
        $formid = $data['formid'];

        $to = $evo->getConfig('client_email_recipients_' . $formid);
        if (empty($to)) {
            $to = $evo->getConfig('client_email_recipients');
        }

        $params = [
            'formid'            => $formid,
            'to'                => $to,
            'api'               => 1,
            'apiFormat'         => 'raw',
            'saveObject'        => '_FormLister',
            'parseMailerParams' => 1,
        ];

        foreach (['common', $formid] as $required => $filename) {
            $filename = __DIR__ . '/../forms/' . $filename . '.inc.php';

            if (!is_readable($filename)) {
                if ($required) {
                    return false;
                }

                continue;
            }

            $config = include $filename;

            foreach (['prepare', 'prepareProcess', 'prepareAfterProcess'] as $param) {
                if (empty($config[$param])) {
                    $config[$param] = [];
                } else if (!is_array($config[$param])) {
                    $config[$param] = [$config[$param]];
                }
            }

            $params = array_merge($params, $config);
        }

        $params['prepareProcess'][] = [$this, 'prepareSetPage'];
        $params['prepareProcess'][] = [$this, 'prepareSetUTMLabels'];

        $data = $evo->runSnippet('FormLister', $params);

        if (empty($data['status'])) {
            $this->result = [
                'response' => 'fail',
                'fields'   => $data['errors'],
                'messages' => $data['messages'],
            ];
        } else {
            $fl = $evo->getPlaceholder('_FormLister');

            $this->result = [
                'response' => 'success',
                'messages' => [$fl->getCFGDef('successMessage', 'Заявка отправлена!')],
            ];
        }

        return true;
    }

    public function getJsonResult()
    {
        return json_encode($this->result, JSON_UNESCAPED_UNICODE);
    }

    public function prepareSetPage($evo, $data, $FL, $name)
    {
        if (isset($data['pid']) && is_numeric($data['pid'])) {
            $FL->setField('page', $evo->runSnippet('DLCrumbs', [
                'id'           => $data['pid'],
                'hideMain'     => 1,
                'showCurrent'  => 1,
                'addWhereList' => 'c.id != 1',
                'tpl'          => '@CODE:[+title+] -&nbsp;',
                'tplLast'      => '@CODE:[+title+]',
                'ownerTPL'     => '@CODE:[+crumbs.wrap+]',
            ]));
        }
    }

    public function prepareSetUTMLabels($evo, $data, $FL, $name)
    {
        $utm = '';

        foreach (['sreferer' => 'Параметры перехода', 'squery' => 'Параметры визита'] as $section => $sectionname) {
            if (isset($data[$section]) && is_string($data[$section])) {
                $params = $this->parseQueryParams($data[$section]);

                if (!empty($params)) {
                    $out = '';

                    foreach ($params as $key => $value) {
                        $out .= '<tr><td>' . $key . ':&nbsp;</td><td>' . htmlspecialchars($value) . '</td></tr>';
                    }

                    $utm .= '<br><b>' . $sectionname . ':</b>' . '<table><tbody>' . $out . '</tbody></table>';
                }
            }
        }

        $FL->setPlaceholder('utm', $utm);
    }

    private function parseQueryParams($query)
    {
        $utmparams = [
            'utm_source'   => 'Рекламная система',
            'utm_campaign' => 'Кампания',
            'utm_content'  => 'Содержание объявления',
            'utm_term'     => 'Ключевое слово',
            'keyword'      => 'Ключевое слово',
            'q'            => 'Поисковая фраза',
            'query'        => 'Поисковая фраза',
            'text'         => 'Поисковая фраза',
            'words'        => 'Поисковая фраза',
        ];

        $crawlers = ['yandex.ru', 'rambler.ru', 'google.ru', 'google.com', 'mail.ru', 'bing.com', 'qip.ru'];

        $out = $params = [];

        if (preg_match('/\?(.+)$/', urldecode($query), $parts)) {
            foreach ($crawlers as $crawler) {
                if (stristr($parts[1], $crawler)) {
                    $out['Система'] = $crawler;
                }
            }

            parse_str($parts[1], $params);

            foreach ($utmparams as $name => $title) {
                if (!empty($params[$name])) {
                    $out[$title] = (md5($params[$name]) == md5(iconv('UTF-8', 'UTF-8', $params[$name])) ? $params[$name] : iconv('cp1251', 'utf-8', $params[$name]));
                }
            }

            if (!empty($out)) {
                return $out;
            }
        }

        return null;
    }
}
