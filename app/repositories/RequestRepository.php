<?php
namespace app\repositories;
use app\repositories\contracts\RequestRepositoryContract;
use app\services\request\dto\RequestCreateDto;
use app\services\request\enums\RequestStatusEnum;
use DateTime;

class RequestRepository extends BaseRepository implements RequestRepositoryContract
{
    public const  string TABLE = 'request';

    public function create(RequestCreateDto $dto)
    {
        $this->getCommand()->insert(
            self::TABLE,
            [
                'name' => $dto->name,
                'email' => $dto->email,
                'message' => $dto->message,
                'status' => RequestStatusEnum::ACTIVE->value,
                'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            ]
        )
            ->execute();
    }

    public function getFiltered(?array $filters): array
    {
        $query = $this->getQuery()->from(self::TABLE);

        if (!empty($filters['status'])) {
          $query->andWhere(['status' => $filters['status']]);
        }

        return $query->all();
    }
}