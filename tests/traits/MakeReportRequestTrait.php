<?php

use Faker\Factory as Faker;
use App\Models\ReportRequest;
use App\Repositories\Admin\ReportRequestRepository;

trait MakeReportRequestTrait
{
    /**
     * Create fake instance of ReportRequest and save it in database
     *
     * @param array $reportRequestFields
     * @return ReportRequest
     */
    public function makeReportRequest($reportRequestFields = [])
    {
        /** @var ReportRequestRepository $reportRequestRepo */
        $reportRequestRepo = App::make(ReportRequestRepository::class);
        $theme = $this->fakeReportRequestData($reportRequestFields);
        return $reportRequestRepo->create($theme);
    }

    /**
     * Get fake instance of ReportRequest
     *
     * @param array $reportRequestFields
     * @return ReportRequest
     */
    public function fakeReportRequest($reportRequestFields = [])
    {
        return new ReportRequest($this->fakeReportRequestData($reportRequestFields));
    }

    /**
     * Get fake data of ReportRequest
     *
     * @param array $postFields
     * @return array
     */
    public function fakeReportRequestData($reportRequestFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->word,
            'car_id' => $fake->word,
            'message' => $fake->text,
            'status' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $reportRequestFields);
    }
}
