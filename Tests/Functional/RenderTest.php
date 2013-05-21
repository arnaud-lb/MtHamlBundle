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
    public function testRender($path, $insulate, $bundlesFile = 'bundles.php')
    {
        $client = $this->createClient(array('test_case' => 'Render', 'root_config' => 'config.yml', 'bundles_file' => $bundlesFile));
        if ($insulate) {
            $client->insulate();
        }

        $crawler = $client->request('GET', $path);

        $this->assertSame(200, $client->getResponse()->getStatusCode(), $client->getResponse());
        $this->assertSame(1, $crawler->filter('p.render.ok')->count());
    }

    public function getConfigs()
    {
        $ret = array();

        foreach (array('/render', '/renderUsingTemplateAnnotation') as $path) {
            foreach (array(true, false) as $insulate) {
                $ret[] = array($path, $insulate, 'bundles.php');
            }
        }
        $ret[] = array('/render', true, 'minimal_bundles.php');
        $ret[] = array('/render', false, 'minimal_bundles.php');

        return $ret;
    }
}
