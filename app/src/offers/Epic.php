<?php

namespace Offers;

class Epic
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $results;

    /**
     * @var array
     */
    private array $offers;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * epic constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    /**
     * @return mixed
     */
    public function getResults(): string
    {
        return $this->results;
    }

    /**
     * @param string $data
     */
    public function setResults(string $data): void
    {
        $this->results = $data;
    }

    /**
     * @return array
     */
    public function getOffers(): array
    {
        return $this->offers;
    }

    /**
     * @param array $offers
     */
    public function setOffers(array $offers): void
    {
        $this->offers = $offers;
    }

    /**
     * @return void
     */
    public function fetchData(): void
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $this->setResults(curl_exec($curl));
        curl_close($curl);
    }

    /**
     * @return void
     */
    public function prepareData(): void
    {
        $data = json_decode($this->getResults(), true);
        $offers = [];
        foreach ($data['data']['Catalog']['searchStore']['elements'] as $offer) {
            array_push($offers, [
                'title' => $offer['title'],
                'id' => $offer['id'],
                'description' => $offer['description'],
                'effectiveData' => $offer['effectiveDate'],
                'keyImages' => $offer['keyImages'],
                'seller' => $offer['seller'],
                'price' => $offer['price']
            ]);
        }
        $this->setOffers($offers);
    }
}