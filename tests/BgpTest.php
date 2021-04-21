<?php

namespace CmdrSharp\NetBoxBgp\Tests;

use CmdrSharp\NetBox\Ipam\IpAddress;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;
use CmdrSharp\NetBoxBgp\Asn;
use CmdrSharp\NetBoxBgp\Session;

class BgpTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_asns()
    {
        $query = Asn::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_get_all_sessions()
    {
        $query = Session::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_create_asn_via_mass_assignment()
    {
        $model = new Asn([
            'number' => '65535',
            'status' => 'deprecated',
            'description' => 'Test Case',
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function create_local_ip_for_session()
    {
        $query = (new IpAddress([
            'address' => '172.16.10.10',
            'status' => 'active',
            'description' => 'Test Case'
        ]))->create();

        $body = json_decode($query->getBody());

        $this->assertTrue(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function create_remote_ip_for_session()
    {
        $query = (new IpAddress([
            'address' => '172.16.10.11',
            'status' => 'active',
            'description' => 'Test Case'
        ]))->create();

        $body = json_decode($query->getBody());

        $this->assertTrue(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_asn_via_mass_assignment
     * @depends create_local_ip_for_session
     * @depends create_remote_ip_for_session
     * @param int $asn
     * @param int $localIp
     * @param int $remoteIp
     * @return mixed
     */
    public function can_create_session_via_mass_assignment(int $asn, int $localIp, int $remoteIp)
    {
        $model = new Session([
            'name' => 'PHPUnit Session 1',
            'status' => 'deprecated',
            'description' => 'Test Case',
            'local_address' => $localIp,
            'remote_address' => $remoteIp,
            'local_as' => $asn,
            'remote_as' => $asn,
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_asn_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_asn(int $id)
    {
        $query = Asn::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }

    /**
     * @test
     * @depends can_create_session_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_session(int $id)
    {
        $query = Session::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }


    /**
     * @test
     * @depends can_create_asn_via_mass_assignment
     */
    public function can_get_asn_by_number()
    {
        $query = Asn::whereNumber(65535);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_session_via_mass_assignment
     * @param int $id
     */
    public function can_delete_session(int $id)
    {
        $query = Session::delete($id);

        $this->assertEquals(204, $query->getStatusCode());
    }

    /**
     * @test
     * @depends can_create_asn_via_mass_assignment
     * @depends can_create_asn_via_fluid_setters
     * @param int $idOne
     * @param int $idTwo
     */
    public function can_delete_asns(int $idOne, int $idTwo)
    {
        $deleteOne = Asn::delete($idOne);
        $deleteTwo = Asn::delete($idTwo);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}
