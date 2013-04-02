<?php

namespace BEAR\Package\Provide\TemplateEngine;

use BEAR\Package\Provide\TemplateEngine\Smarty\SmartyAdapter;

class SmartyAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SmartyAdapter
     */
    private $smartyAdapter;

    /**
     * @var string
     */
    private $tpl;

    public function setUp()
    {
        $this->smartyAdapter = new SmartyAdapter(new \Smarty);
        $this->tpl = __DIR__ . '/test.';
    }

    public function testNew()
    {
        $this->assertInstanceOf('\BEAR\Package\Provide\TemplateEngine\Smarty\SmartyAdapter', $this->smartyAdapter);
    }

    public function testAssign()
    {
        $this->smartyAdapter->assign('greeting', 'adios');
        $result = $this->smartyAdapter->fetch($this->tpl);
        $this->assertSame('greeting is adios', $result);
    }

    public function testAssignAll()
    {
        $this->smartyAdapter->assignAll(['greeting' => 'adios']);
        $result = $this->smartyAdapter->fetch($this->tpl);
        $this->assertSame('greeting is adios', $result);
    }

    /**
     * @expectedException \BEAR\Sunday\Exception\TemplateNotFound
     */
    public function testTemplateNotExists()
    {
        $this->smartyAdapter->assignAll(['greeting' => 'adios']);
        $this->smartyAdapter->fetch('INVALID');
    }

    public function testGetTemplate()
    {
        $this->smartyAdapter->assignAll(['greeting' => 'adios']);
        $this->smartyAdapter->fetch($this->tpl);
        $templateFile = $this->smartyAdapter->getTemplateFile();
        $this->assertSame(__DIR__ . '/test.tpl', $templateFile);
    }

    public function testProd()
    {
        $this->smartyAdapter->setIsProd(true)->init();
        $this->smartyAdapter->assignAll(['greeting' => 'adios']);
        $this->smartyAdapter->fetch($this->tpl);
        $templateFile = $this->smartyAdapter->getTemplateFile();
        $this->assertSame(__DIR__ . '/test.tpl', $templateFile);
    }
}
