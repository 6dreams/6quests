<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\User;
use SixQuests\Domain\Repository\PointRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PointManager
 */
class PointManager
{
    /**
     * @var PointRepository
     */
    private $points;

    /**
     * PointManager constructor.
     *
     * @param PointRepository $points
     */
    public function __construct(PointRepository $points)
    {
        $this->points = $points;
    }

    /**
     * Получить активные точки доступные пользователю.
     *
     * @param User $user
     *
     * @return Point[]
     */
    public function getActivePointsByUser(User $user): array
    {
        return $this->points->getActivePointsByUser($user);
    }

    /**
     * Получить точку, привязанную к пользователю.
     *
     * @param int  $id
     * @param User $user
     *
     * @throws NotFoundHttpException
     *
     * @return Point
     */
    public function getActivePoint(int $id, User $user): Point
    {
        $point = $this
            ->points
            ->getActivePoint($user, $id);

        if (!$point) {
            throw new NotFoundHttpException();
        }

        return $point;
    }

    /**
     * Получить репозиторий.
     *
     * @return PointRepository
     */
    public function getRepository(): PointRepository
    {
        return $this->points;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return Point::class;
    }
}
