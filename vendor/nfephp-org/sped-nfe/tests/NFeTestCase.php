<?php

namespace NFePHP\NFe\Tests;

use PHPUnit\Framework\TestCase;

class NFeTestCase extends TestCase
{
    public $fixturesPath = '';
    public $configJson = '';
    public $contentpfx = '';
    public $passwordpfx = '';

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ];
        $this->contentpfx = file_get_contents($this->fixturesPath . "certs/test_certificate.pfx");
        $this->passwordpfx = 'nfephp';
        $this->configJson = json_encode($config);
    }
}
