<?php

namespace MtHamlBundle\Tests\Functional;

/**
 * @group functional
 */
class RenderTest extends WebTestCase
{
    /**
     * @dataProvider getConfigs
     */
    public function testRender($path, $insulate)
    {
        $client = $this->createClient(array('test_case' => 'Render', 'root_config' => 'config.yml'));
        if ($insulate) {
            $client->insulate();
        }

        $crawler = $client->request('GET', $path);
        $this->assertSame(200, $client->getResponse()->getStatusCode(), $client->getResponse());
        $this->assertSame(1, $crawler->filter('p.render.ok')->count());
    }

    public function getConfigs()
    {
        $configs = array(
            'renderCanRenderHamlTemplates' => array('/render'),
            'templateAnnotationCanUseHamlEngine' => array('/renderUsingTemplateAnnotation'),
        );

        $ret = array();

        foreach ($configs as $key => $config) {
            $config[1] = false;
            $ret[$key] = $config;
            $config[1] = true;
            $ret[$key."_insulated"] = $config;
        };

        return $ret;
    }
}
