<?php
namespace HcCoreTest\Service\Collection\Filtration\Query;

use HcCore\Service\Filtration\Query\FiltrationService;
use Zend\Stdlib\Parameters;

class FiltrationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $qb;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $exprMock;

    /**
     * @var FiltrationService
     */
    protected $filter;

    public function setUp()
    {
        $this->qb = $this->getMock('Doctrine\ORM\QueryBuilder', array(), array(), '', false);

        $this->filter = new FiltrationService();

        $this->exprMock = $this->getMock('Doctrine\ORM\Query\Expr');

        $this->qb->expects($this->once())
                 ->method('expr')
                 ->will($this->returnValue($this->exprMock));

        $this->qb->expects($this->once())
                 ->method('andWhere')
                 ->with($this->exprMock)
                 ->will($this->returnSelf());
    }

    public function testEqualConditionAppliedSuccess()
    {
        $parameters = new Parameters(array('fedya'=>'54'));

        $this->exprMock->expects($this->once())
                       ->method('eq')->with($this->equalTo('l.fedya'), $this->equalTo(':fedya'))
                       ->will($this->returnSelf());

        $this->qb->expects($this->once())
                 ->method('setParameter')
                 ->with($this->equalTo('fedya'), $this->equalTo('54'));

        $this->assertEquals($this->qb, $this->filter->apply($parameters, $this->qb, 'l'));
    }

    public function testLteConditionAppliedSuccess()
    {
        $parameters = new Parameters(array('smooth<='=>'pump'));

        $this->exprMock->expects($this->once())
            ->method('lte')->with($this->equalTo('smooth'), $this->equalTo(':smooth'))
            ->will($this->returnSelf());

        $this->qb->expects($this->once())
            ->method('setParameter')
            ->with($this->equalTo('smooth'), $this->equalTo('pump'));

        $this->assertEquals($this->qb, $this->filter->apply($parameters, $this->qb));
    }

    public function testFieldMapsAppliedSuccess()
    {
        $parameters = new Parameters(array('pimpa>='=>'param'));

        $this->exprMock->expects($this->once())
            ->method('gte')->with($this->equalTo('ter.kick'), $this->equalTo(':pimpa'))
            ->will($this->returnSelf());

        $this->qb->expects($this->once())
            ->method('setParameter')
            ->with($this->equalTo('pimpa'), $this->equalTo('param'));

        $maps = array('pimpa'=>'ter.kick');

        $this->assertEquals($this->qb, $this->filter->apply($parameters, $this->qb, 'tbl1', $maps));
    }
}
