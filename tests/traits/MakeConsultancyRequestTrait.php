<?php

use Faker\Factory as Faker;
use App\Models\ConsultancyRequest;
use App\Repositories\Admin\ConsultancyRequestRepository;

trait MakeConsultancyRequestTrait
{
    /**
     * Create fake instance of ConsultancyRequest and save it in database
     *
     * @param array $consultancyRequestFields
     * @return ConsultancyRequest
     */
    public function makeConsultancyRequest($consultancyRequestFields = [])
    {
        /** @var ConsultancyRequestRepository $consultancyRequestRepo */
        $consultancyRequestRepo = App::make(ConsultancyRequestRepository::class);
        $theme = $this->fakeConsultancyRequestData($consultancyRequestFields);
        return $consultancyRequestRepo->create($theme);
    }

    /**
     * Get fake instance of ConsultancyRequest
     *
     * @param array $consultancyRequestFields
     * @return ConsultancyRequest
     */
    public function fakeConsultancyRequest($consultancyRequestFields = [])
    {
        return new ConsultancyRequest($this->fakeConsultancyRequestData($consultancyRequestFields));
    }

    /**
     * Get fake data of ConsultancyRequest
     *
     * @param array $postFields
     * @return array
     */
    public function fakeConsultancyRequestData($consultancyRequestFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->word,
            'car_id' => $fake->word,
            'bank_id' => $fake->word,
            'type' => $fake->word,
            'name' => $fake->word,
            'email' => $fake->word,
            'country_code' => $fake->word,
            'phone' => $fake->word,
            'subject' => $fake->word,
            'message' => $fake->text,
            'status' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $consultancyRequestFields);
    }
}
