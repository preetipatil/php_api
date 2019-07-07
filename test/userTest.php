<?php
/**
 * Created by IntelliJ IDEA.
 * User: preeti
 * Date: 2019-07-07
 * Time: 08:48
 */

use PHPUnit\Framework\TestCase;

include_once "../api/src/user.php";

class userTest extends TestCase
{

    public function testFindUser()
    {

        $stub = $this->createMock(User::class);

        $stub->method('findUser')
            ->willReturn('foo');

        $this->assertSame('foo', $stub->findUser('email'));

    }
}
