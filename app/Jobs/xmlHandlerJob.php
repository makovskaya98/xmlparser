<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\CategoryMappings;
use App\Models\Offers;
use App\Models\Feeds;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class xmlHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $feed;

    public function __construct(Feeds $feed)
    {
        $this->feed = $feed;
    }

    public function handle(): void
    {
        try {
            $xml = $this->getXml($this->feed->url);

            if ($xml) {
                $this->processCategories($xml);
                $this->processOffers($xml);
            }
        } catch (\Exception $e) {
            Log::error('xmlHandlerJob failed: ' . $e->getMessage());
        }
    }

    private function processCategories($xml): void
    {
        $categories = $xml->shop->categories->category;

        if (isset($categories) && !empty($categories)) {
            foreach ($categories as $category) {
                $externalId = (int)$category->attributes()['id'];

                Category::firstOrCreate([
                    'name' => (string)$category,
                ]);

                CategoryMappings::firstOrCreate([
                    'feeds_id' => $this->feed->id,
                    'category_id' => Category::where('name', (string)$category)->first()->id,
                    'external_id' => $externalId,
                ]);
            }
        }
    }

    private function processOffers($xml): void
    {
        $offers = $xml->shop->offers->offer;

        if (isset($offers) && !empty($offers)) {
            foreach ($offers as $offer) {
                $externalId = (int)$offer->attributes()['id'];

                $existingOffer = Offers::where('external_id', $externalId)->first();

                $categoryId = $this->getCategoryId($offer);

                $offerData = $this->getOfferData($offer, $categoryId);

                if ($existingOffer) {
                    $existingOffer->update($offerData);
                } else {
                    Offers::create($offerData + ['external_id' => $externalId, 'feeds_id' => $this->feed->id]);
                }
            }
        }
    }

    private function getCategoryId($offer): int
    {
        $externalCategoryId = (int)$offer->categoryId;
        $categoryMapping = $this->feed->categoryMappings()->where('external_id', $externalCategoryId)->first();

        return $categoryMapping ? $categoryMapping->category_id : null;
    }

    private function getOfferData($offer, int $categoryId): array
    {
        return [
            'url' => (string)$offer->url,
            'price' => (double)$offer->price,
            'currency_id' => (string)$offer->currencyId,
            'category_id' => $categoryId,
            'oldprice' => (double)$offer->oldprice,
            'picture' => json_encode($offer->picture),
            'store' => (bool)$offer->store,
            'pickup' => (bool)$offer->pickup,
            'delivery' => (bool)$offer->delivery,
            'type_prefix' => (string)$offer->typePrefix,
            'vendor' => (string)$offer->vendor,
            'model' => (int)$offer->model,
            'name' => (string)$offer->name,
            'vendor_code' => (int)$offer->vendorCode,
            'description' => (string)$offer->description,
            'param' => json_encode($offer->param),
        ];
    }

    private function getXml(string $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            Log::error('Getting XML error: ' . curl_error($ch));
            return null;
        }

        return simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOWARNING | LIBXML_NOERROR);
    }
}
