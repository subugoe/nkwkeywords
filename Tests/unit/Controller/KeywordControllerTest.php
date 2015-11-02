<?php
namespace Controller;

use TYPO3\CMS\Core\Tests\BaseTestCase;

class KeywordControllerTest extends BaseTestCase
{

    /**
     * @var \Subugoe\Nkwkeywords\Controller\KeywordController
     */
    protected $fixture;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject<\TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository>
     */
    protected $categoryRepository;

    /**
     * @test
     */
    public function checkIfListActionReturnsSomething()
    {
        $this->assertSame($this->fixture->listAction(), null);
    }

    protected function setUp()
    {
        $this->fixture = $this->getMock('Subugoe\\Nkwkeywords\\Controller\\KeywordController', [], [], '',
            FALSE);
        $this->categoryRepository = $this->getMock(
            'TYPO3\\CMS\\Extbase\\Domain\\Repository\\CategoryRepository', [], [], '', FALSE
        );

        $this->inject($this->fixture, 'categoryRepository', $this->categoryRepository);

    }

    protected function tearDown()
    {
    }
}
