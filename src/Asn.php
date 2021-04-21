<?php

namespace CmdrSharp\NetBoxBgp;

use CmdrSharp\NetBox\Dcim\Site;
use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Tenancy\Tenant;
use CmdrSharp\NetBox\Traits\HandlesNetBoxResults;
use CmdrSharp\NetBox\Traits\RequiresSlugs;
use Psr\Http\Message\ResponseInterface;

class Asn extends NetBox
{
    use HandlesNetBoxResults,
        RequiresSlugs;

    /** @var string */
    const API_PATH = parent::API_PATH . 'plugins/bgp/asn/';

    /** @var array|string[] */
    protected array $fillable = [
        'number',
        'status',
        'description',
        'site',
        'tenant',
    ];

    /**
     * @param int $number
     * @return ResponseInterface
     */
    public static function whereNumber(int $number): ResponseInterface
    {
        return parent::where("?number={$number}");
    }

    /**
     * @param int $number
     * @return $this
     */
    public function setNumber(int $number): Asn
    {
        $this->setAttribute('number', $number);

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): Asn
    {
        $this->setAttribute('status', $status);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Asn
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    /**
     * @param int $site
     * @return $this
     */
    public function setSite(int $site): Asn
    {
        $this->setAttribute('site', $site);

        return $this;
    }

    /**
     * @param string $site
     * @return $this
     */
    public function setSiteByName(string $site): Asn
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
    public function setTenant(int $tenant): Asn
    {
        $this->setAttribute('tenant', $tenant);

        return $this;
    }

    /**
     * @param string $tenant
     * @return $this
     */
    public function setTenantByName(string $tenant): Asn
    {
        $query = Tenant::whereName($tenant);
        $model = $this->getOnlyResult($query);

        $this->setAttribute('tenant', $model->id);

        return $this;
    }
}
