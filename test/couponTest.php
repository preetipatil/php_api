<?php
/**
 * Created by IntelliJ IDEA.
 * User: preeti
 * Date: 2019-07-07
 * Time: 22:11
 */

use PHPUnit\Framework\TestCase;

include_once "../api/src/coupon.php";

class couponTest extends TestCase
{
    public function testCreateCoupon()
    {

        $stub = $this->createMock(Coupon::class);

        $stub->method('createCoupon')
            ->willReturn('foo');

        $this->assertSame('foo', $stub->createCoupon(array()));

    }

    public function testUpdateCoupon()
    {

        $stub = $this->createMock(Coupon::class);

        $stub->method('updateCoupon')
            ->willReturn('foo');

        $this->assertSame('foo', $stub->updateCoupon(2,array()));

    }

    public function testFindAll(){
        $stub = $this->createMock(Coupon::class);

        $stub->method('findAll')
            ->willReturn('foo');

        $this->assertSame('foo', $stub->findAll());
    }

    public function testFindCouponById(){
        $stub = $this->createMock(Coupon::class);

        $stub->method('findCoupon')
            ->willReturn('foo');

        $this->assertSame('foo', $stub->findCoupon(5));
    }
}
