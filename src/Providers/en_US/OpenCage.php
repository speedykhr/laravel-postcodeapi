<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class OpenCage extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&' . $options : '';

        $this->setRequestUrl($this->getRequestUrl() . '?q=' . $postCode . '&key=' . $this->getApiKey() . $options);

        $response = $this->request();

        if ($response['total_results'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['results'][0]['components']['city'] ?? $response['results'][0]['components']['suburb'])
            ->setMunicipality($response['results'][0]['components']['country'])
            ->setProvince($response['results'][0]['components']['state'])
            ->setLatitude($response['results'][0]['geometry']['lat'])
            ->setLongitude($response['results'][0]['geometry']['lng']);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
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
