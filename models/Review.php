<?php

namespace app\models;

use app\system\DbModel;

class Review extends DbModel
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public int $id;
    public int $user_id;
    public int $profile_id;
    public int $status = self::STATUS_INACTIVE;
    public string $content = '';
    public ?int $rating = 1; // TODO: rating na gwiazdki

    public static function tableName(): string
    {
        return 'reviews';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        return parent::save();
    }

    public function rules(): array
    {

        return [
            'content' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 1000]],
            'profile_id' => [self::RULE_USER],
            'rating' => [self::RULE_INT, [self::RULE_INT_MIN, 'min' => 1], [self::RULE_INT_MAX, 'max' => 5]]
        ];
    }

    public function attributes(): array
    {
        return ['content', 'profile_id', 'user_id', 'rating', 'status'];
    }

    public function labels(): array
    {
        return [
            'content' => 'Treść opinii',
            'rating' => 'Ocena'
        ];
    }

    public static function getReviews($where)
    {

        $reviews = self::findAll($where);

        // return $reviews ? array_map(function($review){
        //     $review->user = User::getUserData($review->user_id);
        //     return $review;
        // }, $reviews) : false;
        return $reviews ? array_map(fn($review) => $review->user = User::getUserData($review->user_id), $reviews) : false;


    }

}
