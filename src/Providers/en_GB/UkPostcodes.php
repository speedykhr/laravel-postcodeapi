<?php

namespace nickurt\postcodeapi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractProvider;

class UkPostcodes extends AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'http://uk-postcodes.com/postcode/%s.json';

    /**
     * @param string $postCode
     * @return Address
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $response = $this->get(sprintf($this->getRequestUrl(), $postCode));

        $address = new Address();
        $address
            ->setLatitude($response['geo']['lat'])
            ->setLongitude($response['geo']['lng']);

        return $address;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }
}
