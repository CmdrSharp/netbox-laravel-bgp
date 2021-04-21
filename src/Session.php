<?php

namespace CmdrSharp\NetBoxBgp;

use CmdrSharp\NetBox\Dcim\Site;
use CmdrSharp\NetBox\Ipam\IpAddress;
use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Tenancy\Tenant;
use CmdrSharp\NetBox\Traits\HandlesNetBoxResults;
use CmdrSharp\NetBox\Traits\RequiresSlugs;

class Session extends NetBox
{
    use HandlesNetBoxResults,
        RequiresSlugs;

    /** @var string */
    const API_PATH = parent::API_PATH . 'plugins/bgp/session/';

    /** @var array|string[] */
    protected array $fillable = [
        'name',
        'status',
        'description',
        'site',
        'tenant',
        'device',
        'local_address',
        'remote_address',
        'local_as',
        'remote_as',
    ];

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Session
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): Session
    {
        $this->setAttribute('status', $status);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Session
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    /**
     * @param int $site
     * @return $this
     */
    public function setSite(int $site): Session
    {
        $this->setAttribute('site', $site);

        return $this;
    }

    /**
     * @param string $site
     * @return $this
     */
    public function setSiteByName(string $site): Session
    {
        $query = Site::whereName($site);
        $model = $this->getOnlyResult($query);

        $this->setAttribute('site', $model->id);

        return $this;
    }

    /**
     * @param int $tenant
     * @return $this
     */
    public function setTenant(int $tenant): Session
    {
        $this->setAttribute('tenant', $tenant);

        return $this;
    }

    /**
     * @param string $tenant
     * @return $this
     */
    public function setTenantByName(string $tenant): Session
    {
        $query = Tenant::whereName($tenant);
        $model = $this->getOnlyResult($query);

        $this->setAttribute('tenant', $model->id);

        return $this;
    }

    /**
     * @param int $device
     * @return $this
     */
    public function setDevice(int $device): Session
    {
        $this->setAttribute('device', $device);

        return $this;
    }

    /**
     * @param int $address
     * @return $this
     */
    public function setLocalAddress(int $address): Session
    {
        $this->setAttribute('local_address', $address);

        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setLocalAddressByAddress(string $address): Session
    {
        $query = IpAddress::whereAddress($address);
        $model = $this->getOnlyResult($query);

        $this->setAttribute('local_address', $model->id);

        return $this;
    }

    /**
     * @param int $address
     * @return $this
     */
    public function setRemoteAddress(int $address): Session
    {
        $this->setAttribute('remote_address', $address);

        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setRemoteAddressByAddress(string $address): Session
    {
        $query = IpAddress::whereAddress($address);
        $model = $this->getOnlyResult($query);

        $this->setAttribute('remote_address', $model->id);

        return $this;
    }

    /**
     * @param int $as
     * @return $this
     */
    public function setLocalAs(int $as): Session
    {
        $this->setAttribute('local_as', $as);

        return $this;
    }

    /**
     * @param int $number
     * @return $this
     */
    public function setLocalAsByNumber(int $number): Session
    {
        $query = Asn::whereNumber($number);
        $model = $this->getOnlyResult($query);

        $this->setAttribute('local_as', $model->id);

        return $this;
    }

    /**
     * @param int $as
     * @return $this
     */
    public function setRemoteAs(int $as): Session
    {
        $this->setAttribute('remote_as', $as);

        return $this;
    }

    /**
     * @param int $number
     * @return $this
     */
    public function setRemoteAsByNumber(int $number): Session
    {
        $query = Asn::whereNumber($number);
        $model = $this->getOnlyResult($query);

        $this->setAttribute('remote_as', $model->id);

        return $this;
    }
}
